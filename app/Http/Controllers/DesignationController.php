<?php

namespace App\Http\Controllers;

use App\Models\Designation;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function index(){
        $designations = Designation::active()->orderByDesc('created_at')->get();
        return view('homecontent.designation.index',compact('designations'));
      }
      public function create()
      {
          return view('homecontent.designation.create');
      }

      public function store(Request $request)
      {
          $request->validate([
              'designation_name' => 'required|string|max:255',
              'description' => 'nullable|string|max:255'
          ]);

          Designation::create([
              'designation_name' => $request->designation_name,
              'description' => $request->description,
              'added_by' => auth()->id()
          ]);

          return redirect()->route('designations.index')->with('success', 'Designation created successfully.');
      }

      public function edit(Designation $designation)
      {
          return view('homecontent.designation.edit', compact('designation'));
      }

      public function update(Request $request, Designation $designation)
      {
          $request->validate([
              'designation_name' => 'required|string|max:255',
              'description' => 'nullable|string|max:255'
          ]);

          $designation->update([
              'designation_name' => $request->designation_name,
              'description' => $request->description,
              'updated_by' => auth()->id()
          ]);

          return redirect()->route('designations.index')->with('success', 'Designation updated successfully.');
      }

      public function destroy(Designation $designation)
      {
          $designation->softDelete();
          return redirect()->route('designations.index')->with('success', 'Designation deleted successfully.');
      }
}
