<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\Freelancer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserData;

class AdminController extends Controller
{
    //Prroject
    public function read_project()
    {
        $projects = Project::all();
        return view('admin.tableproject', compact('projects'));
    }

    public function destroy_project($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('listproject')->with('success', 'Project deleted successfully.');
    }

    //Client
    public function read_client()
    {
        $clients = Client::all();
        return view('Admin.tableclient', compact('clients'));
    }

    public function destroy_client($id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('listclient')->with('success', 'Client deleted successfully.');
    }

    //Freelancer
    public function read_freelancer()
    {
        $freelancers = Freelancer::all();
        return view('Admin.tablefreelancer', compact('freelancers'));
    }

    public function destroy_freelancer($id)
    {
        $freelancer = Freelancer::findOrFail($id);
        $freelancer->delete();
        return redirect()->route('listfreelancer')->with('success', 'Freelancer deleted successfully.');
    }

}
