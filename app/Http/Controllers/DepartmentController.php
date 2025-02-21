<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
  public function index(){
    $departments = Department::active()->orderByDesc('created_at')->get();
    return view('homecontent.department.index',compact('departments'));
  }

  public function create()
  {
      return view('homecontent.department.create');
  }

  public function store(Request $request)
  {
      $request->validate([
          'department_name' => 'required|string|max:255',
          'description' => 'nullable|string|max:255'
      ]);

      Department::create([
          'department_name' => $request->department_name,
          'description' => $request->description,
          'added_by' => auth()->id()
      ]);

      return redirect()->route('departments.index')->with('success', 'Department created successfully.');
  }

  public function edit(Department $department)
  {
      return view('homecontent.department.edit', compact('department'));
  }

  public function update(Request $request, Department $department)
  {
      $request->validate([
          'department_name' => 'required|string|max:255',
          'description' => 'nullable|string|max:255'
      ]);

      $department->update([
          'department_name' => $request->department_name,
          'description' => $request->description,
          'updated_by' => auth()->id()
      ]);

      return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
  }

  public function destroy(Department $department)
  {
      $department->softDelete();

      return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
  }

}
