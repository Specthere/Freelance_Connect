<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DetailProject;
use App\Models\Freelancer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Payment;

class FreelancerController extends Controller
{
    // READ ALL PROJECT
    public function read_all_project()
    {
        // Ambil proyek dengan pagination
        $projects = Project::where('status', 'open')->get();

        return view('freelancer.project', compact('projects'));
    }

    public function show($id)
    {
        // Mengambil proyek dengan relasi client dan user
        $project = Project::with(['client.user'])->findOrFail($id);
        return view('freelancer.detail', compact('project'));
    }

    public function ongoingdetail($id)
    {
        $project = Project::findOrFail($id);
        $detailProject = DetailProject::where('project_id', $id)->firstOrFail(); // Sesuaikan logika pencarian

        return view('freelancer.detail_ongoing', compact('project', 'detailProject'));
    }

    public function showProfile()
    {
        $user= Auth::user(); // Mengambil data user yang login
        return view('freelancer.profile', compact('user'));
    }
    public function edit($id)
    {
        $user = User::findOrFail($id); // Mengambil user berdasarkan ID
        return view('freelancer.editprofile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'nullable|min:8|confirmed', // Validasi password (nullable jika tidak ingin mengganti)
    ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password); // Hash password baru
        }

        $user->save();

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }
    public function acceptProject($id)
    {
        // Mendapatkan proyek berdasarkan ID
        $project = Project::findOrFail($id);
    
        // Cek apakah proyek masih tersedia (berstatus 'open')
        if ($project->status !== 'open') {
            return redirect()->back()->with('error', 'Proyek ini sudah tidak tersedia.');
        }
    
        // Mendapatkan user_id dari sesi login
        $userId = Auth::id();
    
        // Menemukan freelancer berdasarkan user_id
        $freelancer = Freelancer::where('user_id', $userId)->first();
    
        // Pastikan freelancer ditemukan
        if (!$freelancer) {
            return redirect()->back()->withErrors('Freelancer tidak ditemukan.');
        }
    
        // Mendapatkan freelancer_id
        $freelancerId = $freelancer->id;
    
        // Memasukkan data ke dalam detail_projects
        DetailProject::create([
            'project_id' => $project->id,         // Pastikan project_id diisi dengan benar
            'freelancer_id' => $freelancerId,      // Menyimpan freelancer_id yang sesuai
            'status' => 'in progress',                // Status proyek menjadi diterima
        ]);
    
        // Update status proyek menjadi 'close'
        $project->update(['status' => 'close']);
    
        // Redirect ke halaman proyek freelancer dengan pesan sukses
        return redirect()->route('freelancer.ongoing_projects')->with('success', 'Proyek berhasil diterima!');
    }
    
    public function showOngoingProjects()
    {

        // Mendapatkan user_id dari sesi login
        $userId = Auth::id();
    
        // Menemukan freelancer berdasarkan user_id
        $freelancer = Freelancer::where('user_id', $userId)->first();
    
        // Pastikan freelancer ditemukan
        if (!$freelancer) {
            return redirect()->back()->withErrors('Freelancer tidak ditemukan.');
        }
    
        $freelancerId = $freelancer->id;
        
        // Mengambil proyek yang sedang berlangsung
        $ongoingProjects = DB::table('detail_projects')
        ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
        ->join('clients', 'projects.client_id', '=', 'clients.id')
        ->select(
            'detail_projects.id',
            'projects.title',
            'clients.company',
            'projects.budget',
            'projects.deadline'
        )
        ->where('detail_projects.status', 'in progress')
        ->where('detail_projects.freelancer_id', $freelancerId)
        ->get();

        return view('freelancer.ongoing_projects', compact('ongoingProjects'));
    }


    // Fungsi untuk memperbarui status proyek
    public function submitAndDone(Request $request, $projectId)
    {
        // Validasi file yang diunggah
        $request->validate([
            'submission' => 'required|file|mimes:zip,rar,7z,pdf,doc,docx|max:10240' // max 10MB
        ]);

        // Cari freelancer berdasarkan user yang login
        $userId = Auth::id();
        $freelancer = Freelancer::where('user_id', $userId)->firstOrFail();

        // Cari detail proyek berdasarkan project_id dan freelancer_id
        $detailProject = DetailProject::where('project_id', $projectId)
            ->where('freelancer_id', $freelancer->id)
            ->firstOrFail();
        
        // Jika ada file submission baru
        if ($request->hasFile('submission')) {
            // Simpan file baru dengan nama unik
            $fileName = time() . '_' . $request->file('submission')->getClientOriginalName();
            $request->file('submission')->storeAs('public/submissions', $fileName);

            // Simpan nama file ke kolom 'submission' (tidak menghapus file lama)
            $detailProject->submission = $fileName;
        }

        // Tandai status proyek sebagai 'done'
        $detailProject->status = 'done';

        // Simpan perubahan ke database
        $detailProject->save();

        // Tambahkan data ke tabel payments
        DB::table('payments')->insert([
            'detail_project_id' => $detailProject->id,
        ]);

        // Redirect ke halaman ongoing_projects dengan pesan sukses
        return redirect()->route('freelancer.ongoing_projects')
            ->with('success', 'File berhasil diupload dan status proyek ditandai selesai!');
    }



    public function detailOngoing($id)
    {
        try {
            $detailProject = DetailProject::with(['project', 'freelancer'])
                ->where('id', $id)
                ->firstOrFail();
                
            return view('freelancer.detail_ongoing', [
                'detailProject' => $detailProject,
                'project' => $detailProject->project
            ]);
            
        } catch (\Exception $e) {
            return redirect()
                ->route('freelancer.ongoing_projects')
                ->with('error', 'Project tidak ditemukan');
        }
    }
    
    public function downloadSubmission($id)
    {
        $detailProject = DetailProject::findOrFail($id);
        
        // Cari freelancer berdasarkan user yang login
        $userId = Auth::id();
        $freelancer = Freelancer::where('user_id', $userId)->firstOrFail();
        
        // Pastikan freelancer yang request adalah pemilik submission
        if ($detailProject->freelancer_id != $freelancer->id) {
            return back()->with('error', 'Anda tidak memiliki akses ke file ini');
        }

        // Cek apakah file ada
        $filePath = 'public/submissions/' . $detailProject->submission;
        if (!Storage::exists($filePath)) {
            return back()->with('error', 'File tidak ditemukan');
        }

        // Unduh file
        return Storage::download($filePath);
    }

    public function reopenProject($id)
    {
        $project = Project::findOrFail($id);

        DetailProject::where('project_id', $id)->delete();

        if ($project->status === 'close') {
            $project->status = 'open';
            $project->save();
            session()->flash('success', 'Proyek berhasil dibuka kembali!');
        } else {
            session()->flash('error', 'Proyek tidak ditemukan!');
        }

        return redirect()->route('freelancer.ongoing_projects');
    }

    public function showWaitingPayment()
    {
        // Mendapatkan user_id dari sesi login
        $userId = Auth::id();

        // Menemukan freelancer berdasarkan user_id
        $freelancer = Freelancer::where('user_id', $userId)->first();

        // Pastikan freelancer ditemukan
        if (!$freelancer) {
            return redirect()->back()->withErrors('Freelancer tidak ditemukan.');
        }

        $freelancerId = $freelancer->id;
        
        // Mengambil proyek yang sedang berlangsung
        $payments = DB::table('payments')
        ->join('detail_projects', 'payments.detail_project_id', '=', 'detail_projects.id')
        ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
        ->join('clients', 'projects.client_id', '=', 'clients.id')
        ->select(
            'payments.id',
            'payments.status',
            'projects.title',
            'clients.company',
            'projects.budget',
            'projects.deadline'
        ) 
        ->where('detail_projects.status', 'done')
        ->whereNot('payments.status', 'completed')
        ->where('detail_projects.freelancer_id', $freelancerId)
        ->get();

        return view('freelancer.waitingpayment', compact('payments'));
    }
    public function paymentDetail($id)
    {
        $payment = DB::table('payments')
            ->join('detail_projects', 'payments.detail_project_id', '=', 'detail_projects.id')
            ->join('projects', 'detail_projects.project_id', '=', 'projects.id')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->select(
                'payments.*',
                'projects.title',
                'projects.description',
                'projects.budget',
                'projects.deadline',
                'clients.company'
            )
            ->where('payments.id', $id)
            ->first();

        if (!$payment) {
            return redirect()->back()->with('error', 'Data pembayaran tidak ditemukan');
        }

        return view('freelancer.payment_detail', compact('payment'));
    }

    public function confirmPayment($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            
            // Memastikan status payment adalah pending
            if ($payment->status !== 'pending') {
                return back()->with('error', 'Status pembayaran tidak valid untuk dikonfirmasi');
            }

            // Update status dan konfirmasi pembayaran
            $payment->update([
                'status' => 'completed',
                'confirm' => true,
                'confirmed_at' => now() // Jika Anda memiliki kolom confirmed_at
            ]);

            return redirect()->route('freelancer.waiting.payment')
                            ->with('success', 'Pembayaran berhasil dikonfirmasi');
                            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengkonfirmasi pembayaran');
        }
    }

    public function History()
    {
        $userId = Auth::id();

        // Menemukan freelancer berdasarkan user_id
        $freelancer = Freelancer::where('user_id', $userId)->first();

        // Pastikan freelancer ditemukan
        if (!$freelancer) {
            return redirect()->back()->withErrors('Freelancer tidak ditemukan.');
        }

        $freelancerId = $freelancer->id;

        $projects = DB::table('projects')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->leftJoin('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->leftJoin('payments', 'detail_projects.id', '=', 'payments.detail_project_id')
            ->select(
                'projects.id',
                'projects.title',
                'clients.company',
                'projects.budget',
                'detail_projects.status as project_status',
                'payments.status as payment_status'
            )
            ->where(function ($query) use ($freelancerId) {
                $query->where('detail_projects.freelancer_id', $freelancerId)
                      ->where('detail_projects.status', 'done')
                      ->where('payments.status', 'completed');
            })
            // ->orWhere('projects.status', 'cancelled')
            ->get();

        return view('freelancer.history', compact('projects'));
    }

    public function detailHistory($id)
    {
        $projectDetail = DB::table('projects')
            ->join('clients', 'projects.client_id', '=', 'clients.id')
            ->join('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->join('payments', 'detail_projects.id', '=', 'payments.detail_project_id')
            ->join('freelancers', 'detail_projects.freelancer_id', '=', 'freelancers.id')
            ->select(
                'projects.id',
                'projects.title',
                'projects.budget',
                'projects.deadline',
                'clients.company',
                'payments.status as payment_status',
                'freelancers.rekening'
            )
            ->where('projects.id', $id)
            ->first();

        if (!$projectDetail) {
            return redirect()->back()->with('error', 'Detail proyek tidak ditemukan');
        }

        return view('freelancer.detailhistory', compact('projectDetail'));
    }
}

