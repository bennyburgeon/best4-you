<?php

namespace App\Http\Controllers;

use App\Models\JobCategory;
use App\DataTables\JobCategoriesDataTable;
use Illuminate\Http\Request;

class JobCategoryController extends Controller
{
    public function index(Request $request, JobCategoriesDataTable $dataTable)
    {
        if ($request->wantsJson() && !$request->ajax()) {
            return response()->json(JobCategory::latest()->get());
        }

        return $dataTable->render('admin.job-categories.index', [
            'categories' => JobCategory::all()
        ]);
    }

    
    public function create()
    {
        return view('admin.job-categories.create', ['categories' => JobCategory::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10'
        ]);
        $category = JobCategory::create($request->only('name', 'symbol', 'parent_category_id'));
        return redirect()->route('job-categories.index')->with('success', 'Created successfully!');
    }

    public function show(JobCategory $jobCategory)
    {
        return redirect()->route('job-categories.index')->with('success', 'Updated successfully!');
    }

    
    public function edit(JobCategory $jobCategory)
    {
        return view('admin.job-categories.edit', ['item' => $jobCategory, 'categories' => JobCategory::where('id', '!=', $jobCategory->id)->get()]);
    }

    public function update(Request $request, JobCategory $jobCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'nullable|string|max:10'
        ]);
        $jobCategory->update($request->only('name', 'symbol', 'parent_category_id'));
        return redirect()->route('job-categories.index')->with('success', 'Updated successfully!');
    }

    public function destroy(JobCategory $jobCategory)
    {
        $jobCategory->delete();
        return redirect()->route('job-categories.index')->with('success', 'Updated successfully!');
    }
}
