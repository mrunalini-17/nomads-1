<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->orderByDesc('created_at')->get();
        return view('homecontent.service.index', compact('services'));
    }

    public function create()
    {
        return view('homecontent.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'is_active' => 1,
            'added_by' => auth()->id(),
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function edit(Service $service)
    {
        return view('homecontent.service.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'is_active' => 'required|boolean'
            ]);


            $service->update([
                'name' => $request->name,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'updated_by' => auth()->id(),
            ]);


            return redirect()->route('services.index')->with('success', 'Service updated successfully.');

        } catch (\Exception $e) {

            \Log::error('Service update failed: ' . $e->getMessage());
            return redirect()->route('services.index')->with('error', $e->getMessage());
        }
    }


    public function destroy(Service $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }
}
