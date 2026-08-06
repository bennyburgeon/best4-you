<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\JobCategory;
use App\Models\IndustryType;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        return view('frontend.home');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function uploadResume()
    {
        return view('frontend.upload-resume');
    }

    public function index(Request $request)
    {
        $query = Job::with(['category', 'skills', 'client', 'currency', 'industryType', 'jobType']);

        $today = now()->toDateString();
        $query->where(function($q) use ($today) {
            $q->whereNull('opening_date')
              ->orWhere('opening_date', '<=', $today);
        })->where(function($q) use ($today) {
            $q->whereNull('closing_date')
              ->orWhere('closing_date', '>=', $today);
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('job_code', 'like', "%{$search}%")
                    ->orWhere('company', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($cq) use ($search) {
                        $cq->where('title', 'like', "%{$search}%");
                    })
                    ->orWhereHas('skills', function ($sq) use ($search) {
                        $sq->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('category_id')) {
            $query->where('job_category_id', $request->category_id);
        }

        if ($request->filled('industry_type_id')) {
            $query->where('industry_type_id', $request->industry_type_id);
        }

        $jobs = $query->latest()->paginate(10);
        $categories = JobCategory::all();
        $industryTypes = IndustryType::all();

        return view('frontend.index', compact('jobs', 'categories', 'industryTypes'));
    }

    public function show($job_code)
    {
        $job = Job::with(['category', 'skills', 'client', 'currency', 'industryType', 'jobType'])
                  ->where('job_code', $job_code)
                  ->firstOrFail();

        return view('frontend.show', compact('job'));
    }
}
