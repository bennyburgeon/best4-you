<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Traits\HandlesDataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    use HandlesDataTables;

    public function index(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $this->paginateDataTable(
                Client::query(),
                $request,
                ['title', 'contact_email', 'contact_number']
            );
        }

        return view('admin.clients.index');
    }

    
    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $request->merge([
            'verified' => filter_var($request->verified, FILTER_VALIDATE_BOOLEAN)
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image',
            'verified' => 'boolean',
            'contact_number' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'hr_name' => 'nullable|string|max:255',
            'hr_contact' => 'nullable|string',
            'hr_email' => 'nullable|email'
        ]);

        $data = $request->except(['logo', '_token', '_method']);

        $client = Client::create($data);

        if ($request->hasFile('logo')) {
            $client->addMediaFromRequest('logo')->toMediaCollection('logo');
        }

        

        return redirect()->route('clients.index')->with('success', 'Client created successfully');
    }

    public function show(Client $client)
    {
        return redirect()->route('clients.index')->with('success', 'Updated successfully!');
    }

    // Since we are using FormData in Vue, PUT requests with files might be tricky.
    // It's common to handle it using POST with _method=PUT.
    
    public function edit(Client $client)
    {
        return view('admin.clients.edit', ['item' => $client]);
    }

    public function update(Request $request, Client $client)
    {
        $request->merge([
            'verified' => filter_var($request->verified, FILTER_VALIDATE_BOOLEAN)
        ]);

        $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image',
            'verified' => 'boolean',
            'contact_number' => 'nullable|string',
            'contact_email' => 'nullable|email',
            'hr_name' => 'nullable|string|max:255',
            'hr_contact' => 'nullable|string',
            'hr_email' => 'nullable|email'
        ]);

        $data = $request->except(['logo', '_token', '_method']);
        $client->update($data);

        if ($request->hasFile('logo')) {
            $client->clearMediaCollection('logo');
            $client->addMediaFromRequest('logo')->toMediaCollection('logo');
        } elseif ($request->input('remove_logo')) {
            $client->clearMediaCollection('logo');
        }

        

        return redirect()->route('clients.index')->with('success', 'Client updated successfully');
    }

    public function destroy(Client $client)
    {
        $client->clearMediaCollection('logo');
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Updated successfully!');
    }
}
