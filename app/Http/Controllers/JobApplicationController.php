<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Traits\HandlesDataTables;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    use HandlesDataTables;

    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = JobApplication::with(['job', 'job.category']);
            return $this->paginateDataTable(
                $query,
                $request,
                ['name', 'phone']
            );
        }

        return view('admin.job-applications.index', [
            'jobs' => \App\Models\Job::orderBy('title')->get()
        ]);
    }

    
    public function create()
    {
        return view('admin.job-applications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_id' => 'nullable|exists:jobs,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'resume' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ]);

        $data = $request->except('resume');
        
        $application = JobApplication::create($data);

        if ($request->hasFile('resume')) {
            $application->addMediaFromRequest('resume')->toMediaCollection('resume');
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Your application has been submitted successfully!']);
        }

        return redirect()->back()->with('success', 'Your application has been submitted successfully!');
    }

    public function destroy(JobApplication $jobApplication)
    {
        $jobApplication->clearMediaCollection('resume');
        $jobApplication->delete();
        return redirect()->route('job-applications.index')->with('success', 'Updated successfully!');
    }
}
