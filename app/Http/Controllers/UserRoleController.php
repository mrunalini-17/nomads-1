<?php

namespace App\Http\Controllers;

use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Add this for authentication

class UserRoleController extends Controller
{
    public function index()
    {
        $userRoles = UserRole::active()->orderByDesc('created_at')->get();
        return view('homecontent.role.index', compact('userRoles'));
    }

    public function create()
    {
        return view('homecontent.role.create');
    }


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        try {
            // Add current user as 'added_by'
            UserRole::create(array_merge($request->all(), [
                'added_by' => Auth::id(),
            ]));

            // Redirect back with success message
            return redirect()->route('roles.index')
                            ->with('success', 'User role created successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging (optional)
            \Log::error('Error creating user role: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()->with('error', 'An error occurred while creating the user role: ' . $e->getMessage());
        }
    }


    public function edit(UserRole $userRole)
    {
        return view('homecontent.role.edit', compact('userRole'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        $role = UserRole::findOrFail($id);

        $role->update(array_merge($request->all(), [
            'updated_by' => Auth::id(),
        ]));

        return redirect()->route('roles.index')
                         ->with('success', 'User role updated successfully.');
    }

    public function destroy(UserRole $userRole)
    {
        try {
            $userRole->softDelete();
            return redirect()->route('roles.index')
                             ->with('success', 'User role deleted successfully.');
        } catch (\Exception $e) {
            // Log the error or handle it as needed
            return redirect()->route('roles.index')
                             ->with('error', 'Failed to delete user role.');
        }
    }

}
