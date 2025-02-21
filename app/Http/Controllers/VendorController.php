<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('manager')->get(); // Assuming you have a relation to the managing user
        return view('homecontent.vendor.index', compact('vendors'));
    }

    public function create()
    {
        $users = UserEmployee::all(); // Fetch users for the dropdown in the create form
        return view('homecontent.vendor.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'gst_no' => 'required|unique:vendors,gst_no',
            'contact' => 'required',
            'email' => 'required|email|unique:vendors,email',
            'managed_by' => 'required|exists:users,id',
        ]);

        Vendor::create($request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor created successfully.');
    }

    public function edit($id)
    {
        $vendor = Vendor::findOrFail($id);
        $users = UserEmployee::all();
        return view('homecontent.vendor.edit', compact('vendor', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'gst_no' => 'required|unique:vendors,gst_no,' . $id,
            'contact' => 'required',
            'email' => 'required|email|unique:vendors,email,' . $id,
            'managed_by' => 'required|exists:users,id',
        ]);

        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());

        return redirect()->route('vendors.index')->with('success', 'Vendor updated successfully.');
    }

    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();

        return redirect()->route('vendors.index')->with('success', 'Vendor deleted successfully.');
    }
}
