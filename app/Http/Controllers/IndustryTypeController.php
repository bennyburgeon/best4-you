<?php

namespace App\Http\Controllers;

use App\Models\IndustryType;
use App\DataTables\IndustryTypesDataTable;
use Illuminate\Http\Request;

class IndustryTypeController extends Controller
{
    public function index(Request $request, IndustryTypesDataTable $dataTable)
    {
        if ($request->wantsJson() && !$request->ajax()) {
            return response()->json(IndustryType::latest()->get());
        }

        return $dataTable->render('admin.industry-types.index');
    }

    
    public function create()
    {
        return view('admin.industry-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industry_types'
        ]);

        $industryType = IndustryType::create($request->only(['name']));

        return redirect()->route('industry-types.index')->with('success', 'Created successfully!');
    }

    public function show(IndustryType $industryType)
    {
        return redirect()->route('industry-types.index')->with('success', 'Updated successfully!');
    }

    
    public function edit(IndustryType $industryType)
    {
        return view('admin.industry-types.edit', ['item' => $industryType]);
    }

    public function update(Request $request, IndustryType $industryType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:industry_types,name,' . $industryType->id
        ]);

        $industryType->update($request->only(['name']));

        return redirect()->route('industry-types.index')->with('success', 'Updated successfully!');
    }

    public function destroy(IndustryType $industryType)
    {
        $industryType->delete();
        return redirect()->route('industry-types.index')->with('success', 'Updated successfully!');
    }
}
