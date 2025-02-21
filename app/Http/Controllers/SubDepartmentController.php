<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Http\Request;

class SubDepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::active()->get();
        $subDepartments = SubDepartment::active()->orderByDesc('created_at')->with('department')->get();
        // dd($subDepartments);
        return view('homecontent.subdepartment.index', compact('subDepartments','departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('homecontent.subdepartment.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
        ]);

        SubDepartment::create([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'added_by' => auth()->user()->id,
        ]);

        return redirect()->route('subdepartments.index')->with('success', 'Sub-Department created successfully.');
    }

    public function edit(SubDepartment $subdepartment)
    {
        $departments = Department::active()->get();
        return view('homecontent.subdepartment.edit ', compact('subdepartment', 'departments'));
    }

    public function update(Request $request, SubDepartment $subdepartment)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
        ]);

        $subdepartment->update([
            'department_id' => $request->department_id,
            'name' => $request->name,
            'updated_by' => auth()->user()->id,
        ]);

        return redirect()->route('subdepartments.index')->with('success', 'Sub-Department updated successfully.');
    }

    public function destroy(SubDepartment $subdepartment)
    {
        $subdepartment->softDelete();
        return redirect()->route('subdepartments.index')->with('success', 'Sub-Department deleted successfully.');
    }
}



