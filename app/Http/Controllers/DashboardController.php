<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobApplication;
use App\Models\Client;
use App\Models\JobCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'jobs' => Job::count(),
            'applications' => JobApplication::count(),
            'clients' => Client::count(),
            'categories' => JobCategory::count(),
        ];
        $recentApplications = JobApplication::with('job')->latest()->take(5)->get();
        
        return view('admin.dashboard.index', compact('stats', 'recentApplications'));
    }

    public function stats()
    {
        return response()->json([
            'jobs' => Job::count(),
            'applications' => JobApplication::count(),
            'clients' => Client::count(),
            'categories' => JobCategory::count(),
        ]);
    }
}
