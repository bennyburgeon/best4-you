<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\DataTables\SkillsDataTable;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request, SkillsDataTable $dataTable)
    {
        if ($request->wantsJson() && !$request->ajax()) {
            return response()->json(Skill::latest()->get());
        }

        return $dataTable->render('admin.skills.index');
    }

    public function create()
    {
        // Handled by modal
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:skills,name'
        ]);

        Skill::create($validated);
        return redirect()->route('skills.index')->with('success', 'Skill created successfully');
    }

    public function edit(Skill $skill)
    {
        // Handled by modal
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|unique:skills,name,' . $skill->id
        ]);

        $skill->update($validated);
        return redirect()->route('skills.index')->with('success', 'Skill updated successfully');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return redirect()->route('skills.index')->with('success', 'Skill deleted successfully');
    }
}
