<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use DataTables;

class ProjectController extends Controller
{
    public function downloadSubmission($project)
    {
        $projectData = DB::table('projects')
            ->join('detail_projects', 'projects.id', '=', 'detail_projects.project_id')
            ->where('projects.id', $project)
            ->first();

        if (!$projectData || !$projectData->submission) {
            return back()->with('error', 'File tidak ditemukan');
        }

        $fileName = 'submission_project_' . $project . '.zip';

        return response($projectData->submission)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    public function index()
    {
        $projects = Project::latest()->paginate(7);
        return view('admin.tableproject', compact('projects'));
    }

    public function cancelProject($id)
    {
        $project = Project::findOrFail($id);

        // Check if the project is still in 'open' status
        if ($project->status === 'open') {
            $project->status = 'cancelled';
            $project->save();

            return redirect()->route('client.detailproject', $project->id)
                ->with('success', 'Project has been cancelled successfully.');
        }

        return redirect()->route('client.detailproject', $project->id)
            ->with('error', 'Project cannot be cancelled at this stage.');
    }

    public function previewDetail($id)
    {
        $project = Project::findOrFail($id);
        
        // Debug information
        logger('Project data:', [
            'id' => $project->id,
            'file_path' => $project->detail_file,
            'all_data' => $project->toArray()
        ]);

        // Safety check
        if (!$project->detail_file) {
            return back()->with('error', 'File path tidak ditemukan di database.');
        }

        try {
            // Check if file exists in storage
            if (!Storage::disk('public')->exists($project->detail_file)) {
                return back()->with('error', 'File tidak ditemukan di storage.');
            }

            // Get file mime type
            $mimeType = mime_content_type(public_path('storage/' . $project->detail_file));

            // For PDFs, display in browser
            if ($mimeType === 'application/pdf') {
                return response()->file(storage_path('app/public/' . $project->detail_file));
            }

            // For other files, download
            $path = storage_path('app/public/' . $project->detail_file);
            return response()->download($path);

        } catch (\Exception $e) {
            logger('File handling error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat memproses file.');
        }
    }

    public function downloadDetail($id)
    {
        $project = Project::findOrFail($id);
        
        // Debug information
        logger('Download attempt:', [
            'id' => $project->id,
            'file_path' => $project->detail_file
        ]);

        // Safety check
        if (!$project->detail_file) {
            return back()->with('error', 'File path tidak ditemukan di database.');
        }

        $fullPath = public_path('storage/' . $project->detail_file);
        
        if (!file_exists($fullPath)) {
            return back()->with('error', 'File tidak ditemukan di sistem.');
        }

        return response()->download($fullPath);
    }

} 