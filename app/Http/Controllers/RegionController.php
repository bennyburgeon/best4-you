<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Traits\HandlesDataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegionController extends Controller
{
    use HandlesDataTables;

    public function index(Request $request)
    {
        if (Region::count() === 0) {
            Region::insert([
                ['name' => 'India', 'slug' => 'india', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Gulf', 'slug' => 'gulf', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Europe', 'slug' => 'europe', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
                ['name' => 'Others', 'slug' => 'others', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            if ($request->has('all')) {
                return response()->json(Region::all());
            }
            return $this->paginateDataTable(Region::query(), $request, ['name']);
        }

        return view('admin.regions.index');
    }

    public function create()
    {
        return view('admin.regions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions'
        ]);

        $region = Region::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status') ? filter_var($request->status, FILTER_VALIDATE_BOOLEAN) : true
        ]);

        if ($request->wantsJson()) {
            return response()->json($region, 201);
        }

        return redirect()->route('regions.index')->with('success', 'Region created successfully!');
    }

    public function show(Region $region)
    {
        if (request()->wantsJson()) {
            return response()->json($region);
        }
        return redirect()->route('regions.index');
    }

    public function edit(Region $region)
    {
        return view('admin.regions.edit', ['item' => $region]);
    }

    public function update(Request $request, Region $region)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:regions,name,' . $region->id
        ]);

        $region->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'status' => $request->has('status') ? filter_var($request->status, FILTER_VALIDATE_BOOLEAN) : $region->status
        ]);

        if ($request->wantsJson()) {
            return response()->json($region);
        }

        return redirect()->route('regions.index')->with('success', 'Region updated successfully!');
    }

    public function destroy(Region $region)
    {
        $region->delete();

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('regions.index')->with('success', 'Region deleted successfully!');
    }
}
