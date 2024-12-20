<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\DetailProject;
use App\Models\Payment;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    // Menampilkan form untuk menambahkan proyek
    public function index()
    {
        return view('client.addproject');
    }

    // Menambahkan proyek baru
    public function add_project(Request $request)
    {
        // Validasi minimal 3 hari dari sekarang
        $minDeadline = date('Y-m-d', strtotime('+3 days'));
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'budget' => 'required|numeric|min:1',
            'deadline' => 'required|date|after_or_equal:' . $minDeadline,
            'detail' => 'required|mimes:pdf|max:5120', // Maksimal 5MB, hanya PDF
        ], [
            'deadline.after_or_equal' => 'Deadline minimal 3 hari dari sekarang.',
            'detail.required' => 'File detail project wajib diupload.',
            'detail.mimes' => 'File detail harus berformat PDF.',
            'detail.max' => 'Ukuran file detail maksimal 5MB.',
        ]);

        try {
            $user = Auth::user();
            $client = $user->client;

            if (!$client) {
                return redirect()->route('client.addproject')
                    ->with('error', 'Client not found.');
            }

            // Upload dan simpan file detail
            if ($request->hasFile('detail')) {
                $file = $request->file('detail');
                $fileName = time() . '_' . $file->getClientOriginalName();
                // Simpan file ke storage/app/public/detail
                $filePath = $file->storeAs('detail', $fileName, 'public');
            }

            $project = Project::create([
                'title' => $request->title,
                'budget' => $request->budget,
                'deadline' => $request->deadline,
                'detail' => $filePath ?? null,
                'description' => $request->description,
                'status' => 'open',
                'client_id' => $client->id,
            ]);

            return redirect()->route('client.addproject')
                ->with('success', 'Project berhasil ditambahkan!');

        } catch (\Exception $e) {
            return redirect()->route('client.addproject')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Menampilkan daftar proyek
    public function read_project()
    {
        $user = Auth::user();
        
        if (!$user || !$user->client) {
            return redirect()->route('client.addproject')
                ->with('error', 'Silakan lengkapi profil client Anda terlebih dahulu.');
        }

        $projects = Project::select(
            'projects.id', 
            'projects.title', 
            'projects.budget', 
            'projects.deadline', 
            'projects.status', 
            'freelancers.first_name',
            'detail_projects.submission'
        )
            ->leftJoin('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->leftJoin('freelancers', 'freelancers.id', '=', 'detail_projects.freelancer_id')
            ->where('projects.client_id', $user->client->id)
            ->whereNot('projects.status', 'cancelled')
            ->get();

        return view('client.readproject', compact('projects'));
    }

    // Menampilkan form untuk mengedit proyek
    public function edit_project($id)
    {
        $project = Project::findOrFail($id);
        return view('client.editproject', compact('project'));
    }

    // Mengupdate proyek
    public function update_project(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'budget' => 'required|numeric|min:1|max:9223372036854775807',
            'deadline' => 'required|date',
        ]);

        $project = Project::findOrFail($id);
        $project->title = $request->title;
        $project->budget = $request->budget;
        $project->deadline = $request->deadline;
        $project->description = $request->description;
        $project->save();

        return redirect()->route('client.project')->with('success', 'Project updated successfully!');
    }


    public function profile()
    {
        $user = Auth::user();
        $client = $user->client;

        return view('client.profile', compact('user', 'client'));
    }

    public function updateProfile(Request $request)
    {
        try {
            $request->validate([
                'company' => 'required|string|max:255',
                'bio' => 'required|string'
            ]);

            $client = Client::where('user_id', Auth::id())->first();
            $client->company = $request->company;
            $client->bio = $request->bio;
            $client->save();

            return redirect()->back()->with('success', 'Profile berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profile.');
        }
    }

    public function detail_project($id)
    {
        $project = DB::table('projects')
            ->leftJoin('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->leftJoin('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->select(
                'projects.*',
                'detail_projects.id as detail_id',
                'detail_projects.submission',
                'detail_projects.status as detail_status',
                'freelancers.first_name',
                'freelancers.last_name',
                'users.email'
            )
            ->where('projects.id', $id)
            ->first();

        return view('client.detailproject', compact('project'));
    }

    public function payment()
    {
        $user = Auth::user();
        Log::info('User authenticated:', ['user_id' => $user ? $user->id : 'null']);

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $client = $user->client;
        Log::info('Client data:', ['client_id' => $client ? $client->id : 'null']);

        if (!$client) {
            return redirect()->route('client.profile')
                ->with('error', 'Silakan lengkapi profil client Anda terlebih dahulu.');
        }

        $payments = DB::table('payments')
                ->join('detail_projects', 'payments.detail_project_id', '=', 'detail_projects.id')
                ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
                ->leftJoin('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
                ->where('projects.client_id', $client->id)
                ->select(
                    'payments.id as id',
                    'payments.status as payment_status',
                    'projects.title as project_title',
                    'projects.budget as project_budget',
                    DB::raw('COALESCE(freelancers.first_name, "Not Assigned") as freelancer_name')
                )
                ->get();

        return view('client.payment', compact('payments'));
    }


    public function download_Detail($id)
    {
        $project = Project::findOrFail($id);
        
        if (!$project->detail) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $project->detail);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        return response()->download($filePath);
    }

    public function preview_Detail($id)
    {
        $project = Project::findOrFail($id);
        
        if (!$project->detail) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = storage_path('app/public/' . $project->detail);
        
        if (!file_exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        // Return file PDF untuk ditampilkan di browser
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf'
        ]);
    }

    public function detail_payment($id)
    {
        $payment = DB::table('payments')
            ->join('detail_projects', 'payments.detail_project_id', '=', 'detail_projects.id')
            ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->join('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->join('users', 'freelancers.user_id', '=', 'users.id')
            ->select(
                'payments.id as id',
                'payments.updated_at as payment_date',
                'payments.status',
                'projects.id as project_id',
                'projects.title as project_title',
                'projects.budget as project_budget',
                'detail_projects.status as project_status',
                'detail_projects.id as detail_project_id',
                'detail_projects.submission',
                'users.name as name',
                'freelancers.rekening as freelancer_rekening',
                'freelancers.bank as freelancer_bank',
                'clients.company as client_company',
            )
            ->where('payments.id', $id)
            ->first();

        if (!$payment) {
            return redirect()->route('client.payment')
                ->with('error', 'Payment tidak ditemukan.');
        }

        return view('client.detailpayment', compact('payment'));
    }

    public function bayar($id)
    {
        $payment = DB::table('payments')
            ->join('detail_projects', 'payments.detail_project_id', '=', 'detail_projects.id')
            ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
            ->join('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->join('users', 'freelancers.user_id', '=', 'users.id')
            ->select(
                'payments.id as id',
                'users.name as name',
                'freelancers.rekening as freelancer_rekening',
                'freelancers.bank as nama_bank',
                'projects.budget as project_budget',
                'payments.status as payment_status'
            )
            ->where('payments.id', $id)
            ->first();

        return view('client.bayar', compact('payment'));
    }
    public function downloadSubmission($id)
    {
        // Cari detail project berdasarkan ID
        $payment = DB::table('detail_projects')->where('id', $id)->first();

        if (!$payment || !$payment->submission) {
            return redirect()->back()->with('error', 'File submission tidak ditemukan.');
        }

        // Path file submission (pastikan sesuai dengan lokasi penyimpanan Anda)
        $filePath = 'public/submissions/' . $payment->submission;
        if (!Storage::exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        // Unduh file
        return Storage::download($filePath);
    }

    public function konfirmasiPembayaran($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->status = 'pending';
            $payment->save();

            return redirect()->route('client.detailpayment', $id)
                ->with('success', 'Konfirmasi pembayaran berhasil dikirim. Tim kami akan memverifikasi pembayaran Anda.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran.');
        }
    }

    public function History()
    {
        $userId = Auth::id();

        // Menemukan client berdasarkan user_id
        $client = Client::where('user_id', $userId)->first();

        // Pastikan client ditemukan
        if (!$client) {
            return redirect()->back()->withErrors('Client tidak ditemukan.');
        }

        $clientId = $client->id;

        $projects = DB::table('projects')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->leftJoin('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->leftJoin('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->leftJoin('users', 'freelancers.user_id', '=', 'users.id')
            ->leftJoin('payments', 'detail_projects.id', '=', 'payments.detail_project_id')
            ->select(
                'projects.id',
                'projects.title',
                'freelancers.first_name',
                'users.name as freelancer',
                'projects.budget',
                'projects.status as project_status',
                'detail_projects.status as detail_project_status',
                'payments.status as payment_status'
            )
            ->where('projects.client_id', $clientId)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('detail_projects.status', 'done')
                      ->where('payments.status', 'completed');
                })
                ->orWhere('projects.status', 'cancelled');
            })
            ->get();

        return view('client.history', compact('projects'));

        
    }
    public function detailHistory($id)
    {
        $projectDetail = DB::table('projects')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->join('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->join('payments', 'detail_projects.id', '=', 'payments.detail_project_id')
            ->join('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->join('users', 'freelancers.user_id', '=', 'users.id')
            ->select(
                'projects.id',
                'projects.title',
                'projects.budget',
                'projects.deadline',
                'users.name as freelancer',
                'payments.status as payment_status',
                'freelancers.rekening'
            )
            ->where('projects.id', $id)
            ->first();

        if (!$projectDetail) {
            return redirect()->back()->with('error', 'Detail proyek tidak ditemukan');
        }

        return view('client.detailhistory', compact('projectDetail'));
    }


}
