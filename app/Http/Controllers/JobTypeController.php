<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use App\DataTables\JobTypesDataTable;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    public function index(Request $request, JobTypesDataTable $dataTable)
    {
        if ($request->wantsJson() && !$request->ajax()) {
            return response()->json(JobType::latest()->get());
        }

        return $dataTable->render('admin.job-types.index');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        JobType::create($request->only(['name']));
        return redirect()->route('job-types.index')->with('success', 'Created successfully!');
    }

    public function update(Request $request, JobType $jobType)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $jobType->update($request->only(['name']));
        return redirect()->route('job-types.index')->with('success', 'Updated successfully!');
    }

    public function destroy(JobType $jobType)
    {
        $jobType->delete();
        return redirect()->route('job-types.index')->with('success', 'Deleted successfully!');
    }
}
