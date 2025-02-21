<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Source;
use Illuminate\Support\Facades\Auth;

class SourcesController extends Controller
{
    public function index()
    {
        $sources = Source::active()->orderBy('id', 'desc')->get();
        return view('homecontent.masterdata.sources', compact('sources'));
    }


    public function store(Request $request)
    {
        try {

            $request->validate([
                'title' => 'required|string|max:255',
            ]);


            Source::create(array_merge($request->all(), [
                'added_by' => Auth::id(),
            ]));

            return redirect()->route('sources.index')->with('success', 'Service created successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating service: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the service. Please try again.');
        }
    }

    public function edit($id)
    {
        $source = Source::findOrFail($id);
        return response()->json($source);
    }

    public function update(Request $request)
    {
        //dd($request->all());
        try {

            $request->validate([
                'title' => 'required',
            ]);

            $id = $request->id;

            $source = Source::findOrFail($id);

            $source->update([
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('sources.index')->with('success', 'Source updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating source: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'An error occurred while updating the service. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {

            $booking = Source::findOrFail($id);
            $booking->softDelete();
            return redirect()->route('sources.index')->with('success', 'Source deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting service: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'An error occurred while deleting the service. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



}
