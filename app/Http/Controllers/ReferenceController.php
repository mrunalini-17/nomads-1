<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReferenceController extends Controller
{

    public function index()
    {
        $references = Reference::active()->orderBy('id', 'desc')->get();
        return view('homecontent.masterdata.references.index', compact('references'));
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required',
                'mobile' => ['required', 'regex:/^\d{10}$/','unique:references,mobile'],
                'whatsapp' => ['required', 'regex:/^\d{10}$/','unique:references,whatsapp'],
                'email' => 'nullable|email|max:255',
                'gstin' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255'
            ]);


            Reference::create(array_merge($request->all(), [
                'added_by' => Auth::id(),
            ]));

            return redirect()->route('references.index')->with('success', 'Reference added successfully.');

        } catch (\Exception $e) {
            \Log::error('Error adding reference: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }



    public function edit($id)
    {
        $reference = Reference::findOrFail($id);
        return response()->json($reference);
    }


    public function update(Request $request)
    {
        //dd($request->all());
        try {
            $id = $request->id;
            $request->validate([
                'name' => 'required',
                'mobile' => [
                    'required',
                    'regex:/^\d{10}$/',
                    Rule::unique('references', 'mobile')->ignore($id)
                ],
                'whatsapp' => [
                    'required',
                    'regex:/^\d{10}$/',
                    Rule::unique('references', 'whatsapp')->ignore($id)
                ],
                'email' => 'required|email|max:255',
                'gstin' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255'
            ]);

            $reference = Reference::findOrFail($id);

            $reference->update([
                'name' => $request->input('name'),
                'mobile' => $request->input('mobile'),
                'whatsapp' => $request->input('whatsapp'),
                'email' => $request->input('email'),
                'gstin' => $request->input('gstin'),
                'description' => $request->input('description'),
                'updated_by' => Auth::id(),
            ]);

            return redirect()->route('references.index')->with('success', 'Reference updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Error updating reference: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'An error occurred while updating the service. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Reference::findOrFail($id);
            $booking->softDelete();
            return redirect()->route('references.index')->with('success', 'References deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting reference: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'An error occurred while deleting the service. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
