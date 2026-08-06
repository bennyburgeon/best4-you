<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use Illuminate\Http\Request;

use App\Traits\HandlesDataTables;

class JobController extends Controller
{
    use HandlesDataTables;

    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $query = Job::with(['category', 'skills', 'client', 'currency', 'industryType', 'jobType', 'region']);

            if ($request->filled('region_id')) {
                $query->where('region_id', $request->region_id);
            }

            if ($request->filled('region')) {
                $query->whereHas('region', function ($q) use ($request) {
                    $q->where('slug', $request->region);
                });
            }

            if ($request->has('draw')) {
                return $this->paginateDataTable(
                    $query,
                    $request,
                    ['job_code', 'title']
                );
            }
            
            // Standard API response fallback if not DataTables draw
            $jobs = $query->latest()->get();
            return response()->json($jobs);
        }

        return view('admin.jobs.index', [
            'clients' => \App\Models\Client::orderBy('title')->get(),
            'industryTypes' => \App\Models\IndustryType::orderBy('name')->get()
        ]);
    }

    
    public function create()
    {
        return view('admin.jobs.create', [
            'categories' => \App\Models\JobCategory::all(),
            'industryTypes' => \App\Models\IndustryType::all(),
            'jobTypes' => \App\Models\JobType::all(),
            'clientsList' => \App\Models\Client::all(),
            'currencies' => \App\Models\Currency::all(),
            'skills' => \App\Models\Skill::all(),
            'regions' => \App\Models\Region::all()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_code' => 'nullable|string|unique:jobs',
            'title' => 'required|string|max:255',
            'job_category_id' => 'required',
            'industry_type_id' => 'nullable|exists:industry_types,id',
            'job_type_id' => 'nullable|exists:job_types,id',
            'skills' => 'nullable|array',
            'client_id' => 'nullable|exists:clients,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'opening_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'gender_preference' => 'nullable|string',
            'experience_min' => 'nullable|integer',
            'experience_max' => 'nullable|integer',
            'salary_from' => 'nullable|numeric',
            'salary_to' => 'nullable|numeric',
            'region_id' => 'nullable|exists:regions,id'
        ]);

        $data = $request->except(['skills', '_token', '_method']);
        $job = Job::create($data);

        // Generate dynamic job code: BJ-{category symbol}-{job type}-{id}
        $category = \App\Models\JobCategory::find($job->job_category_id);
        $jobType = \App\Models\JobType::find($job->job_type_id);
        
        $catSymbol = $category ? ($category->symbol ?: strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->name), 0, 3))) : 'GEN';
        $typeLabel = $jobType ? strtoupper(substr($jobType->name, 0, 2)) : 'GEN';
        $serial = str_pad($job->id, 4, '0', STR_PAD_LEFT);
        
        $job->update([
            'job_code' => "BJ-{$catSymbol}-{$typeLabel}-{$serial}"
        ]);

        if ($request->has('skills')) {
            $skillIds = $this->syncSkills($request->skills);
            $job->skills()->sync($skillIds);
        }

        return redirect()->route('jobs.index')->with('success', 'Created successfully!');
    }

    public function show(Job $job)
    {
        return redirect()->route('jobs.index')->with('success', 'Updated successfully!');
    }

    
    public function edit(Job $job)
    {
        return view('admin.jobs.edit', [
            'item' => $job,
            'categories' => \App\Models\JobCategory::all(),
            'industryTypes' => \App\Models\IndustryType::all(),
            'jobTypes' => \App\Models\JobType::all(),
            'clientsList' => \App\Models\Client::all(),
            'currencies' => \App\Models\Currency::all(),
            'skills' => \App\Models\Skill::all(),
            'regions' => \App\Models\Region::all()
        ]);
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'job_code' => 'nullable|string|unique:jobs,job_code,' . $job->id,
            'title' => 'required|string|max:255',
            'job_category_id' => 'required',
            'industry_type_id' => 'nullable|exists:industry_types,id',
            'job_type_id' => 'nullable|exists:job_types,id',
            'skills' => 'nullable|array',
            'client_id' => 'nullable|exists:clients,id',
            'currency_id' => 'nullable|exists:currencies,id',
            'opening_date' => 'nullable|date',
            'closing_date' => 'nullable|date|after_or_equal:opening_date',
            'gender_preference' => 'nullable|string',
            'experience_min' => 'nullable|integer',
            'experience_max' => 'nullable|integer',
            'salary_from' => 'nullable|numeric',
            'salary_to' => 'nullable|numeric',
            'region_id' => 'nullable|exists:regions,id'
        ]);

        $data = $request->except(['skills', '_token', '_method']);
        $job->update($data);

        // Update dynamic job code if category or type changed
        $category = \App\Models\JobCategory::find($job->job_category_id);
        $jobType = \App\Models\JobType::find($job->job_type_id);
        
        $catSymbol = $category->symbol ?: strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $category->name), 0, 3));
        $typeLabel = $jobType ? strtoupper(substr($jobType->name, 0, 2)) : 'GEN';
        $serial = str_pad($job->id, 4, '0', STR_PAD_LEFT);
        
        $job->update([
            'job_code' => "BJ-{$catSymbol}-{$typeLabel}-{$serial}"
        ]);

        if ($request->has('skills')) {
            $skillIds = $this->syncSkills($request->skills);
            $job->skills()->sync($skillIds);
        }

        return redirect()->route('jobs.index')->with('success', 'Updated successfully!');
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Updated successfully!');
    }

    private function syncSkills(array $skills)
    {
        $skillIds = [];
        foreach ($skills as $skillData) {
            // Handle both skill ID and new skill name
            if (is_numeric($skillData)) {
                $skillIds[] = $skillData;
            } else {
                $skill = Skill::firstOrCreate(['name' => $skillData]);
                $skillIds[] = $skill->id;
            }
        }
        return $skillIds;
    }
}
