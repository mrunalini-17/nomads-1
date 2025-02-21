<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



use function PHPUnit\Framework\isNull;

class CustomerManagerController extends Controller
{
    public function create(Customer $customer)
    {

        return view('homecontent.customer.manager.create', compact('customer'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {
            $managerValidatedData = $request->validate([
                'customer_id' => 'nullable|exists:customers,id',
                'manager_fname' => 'required|string|max:255',
                'manager_lname' => 'required|string|max:255',
                'manager_mobile' => 'required|string|max:15',
                'manager_whatsapp' => 'nullable|string|max:15',
                'manager_email' => 'required|string|email|max:255',
                'manager_position' => 'nullable|string|max:255',
            ]);

            $managerData = [
                'customer_id' => $managerValidatedData['customer_id'],
                'fname' => $managerValidatedData['manager_fname'],
                'lname' => $managerValidatedData['manager_lname'],
                'mobile' => $managerValidatedData['manager_mobile'],
                'whatsapp' => $managerValidatedData['manager_whatsapp'],
                'email' => $managerValidatedData['manager_email'],
                'relation' => $managerValidatedData['manager_position'],
                'added_by' => Auth::id(),
            ];

            CustomerManager::create($managerData);

            $customer = Customer::find($request->customer_id);
            $customer->update(['have_manager' => true]);


            return redirect()
                ->route('customers.show', $customer->id)
                ->with('success', 'Manager added successfully.');

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related exceptions
            \Log::error('Database error while adding manager: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'There was a database error. Please try again.');

        } catch (\Exception $e) {
            // Handle other general exceptions
            \Log::error('Error adding manager: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while adding the manager. Please try again.'. $e->getMessage());
        }
    }

    public function storeforbooking(Request $request)
    {
        // dd($request->all());
        try {
            $messages = [
                'mobile.required' => 'Mobile number is required.',
                'mobile.digits' => 'Mobile number must be exactly 10 digits.',

                'whatsapp.required' => 'WhatsApp number is required.',
                'whatsapp.digits' => 'WhatsApp number must be exactly 10 digits.',

            ];

            $managerValidatedData = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'manager_fname' => 'required|string|max:255',
                'manager_lname' => 'required|string|max:255',
                'manager_mobile' => 'required|digits:10',
                'manager_whatsapp' => 'required|digits:10',
                'manager_email' => 'nullable|string|email|max:255',
                'manager_position' => 'nullable|string|max:255',
            ], $messages);

            $managerData = [
                'customer_id' => $managerValidatedData['customer_id'],
                'fname' => $managerValidatedData['manager_fname'],
                'lname' => $managerValidatedData['manager_lname'],
                'mobile' => $managerValidatedData['manager_mobile'],
                'whatsapp' => $managerValidatedData['manager_whatsapp'],
                'email' => $managerValidatedData['manager_email'],
                'relation' => $managerValidatedData['manager_position'],
                'added_by' => Auth::id(),
            ];

            $manager = CustomerManager::create($managerData);

            $customer = Customer::find($request->customer_id);
            $customer->update(['have_manager' => true]);

            return response()->json([
                'success' => true,
                'message' => 'Manager added successfully.',
                'manager_id' => $manager->id,
                'manager_name' => $manager->fname . ' ' . $manager->lname,
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => "Please enter valid manager information.",
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while saving the manager. Please try again.'
            ], 500);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            $managerValidatedData = $request->validate([
                'manager_fname' => 'required|string|max:255',
                'manager_lname' => 'required|string|max:255',
                'manager_mobile' => 'required|string|max:15',
                'manager_whatsapp' => 'nullable|string|max:15',
                'manager_email' => 'required|string|email|max:255|unique:customer_managers,email,' . $id,
                // 'manager_position' => 'nullable|string|max:255',
            ]);

            $manager = Customer::findOrFail($id);

            $manager->update([
                'fname' => $managerValidatedData['manager_fname'],
                'lname' => $managerValidatedData['manager_lname'],
                'mobile' => $managerValidatedData['manager_mobile'],
                'whatsapp' => $managerValidatedData['manager_whatsapp'],
                'email' => $managerValidatedData['manager_email'],
                // 'relation' => $managerValidatedData['manager_position'],
                'updated_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Manager updated successfully');
        } catch (\Exception $e) {

            \Log::error('Manager Update Error: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the manager. Please try again.' . $e->getMessage());
        }
    }


    public function destroy($customerId, $managerId)
    {
        try {
            // Delete record from the pivot table 'customers_managers'
            DB::table('customers_managers')
                ->where('customer_id', $customerId)
                ->where('manager_id', $managerId)
                ->delete();

            // Check if the same customer has more managers in the pivot table
            $hasMoreManagers = DB::table('customers_managers')
                ->where('customer_id', $customerId)
                ->exists(); // Returns true if there are still managers

            // If no more managers exist, update the 'have_manager' field
            if (!$hasMoreManagers) {
                Customer::where('id', $customerId)->update([
                    'have_manager' => false,
                    'updated_by' => Auth::id(),
                ]);
            }

            return redirect()->back()->with('success', 'Manager deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting manager: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the manager. Please try again.');
        }
    }



    public function searchManagers(Request $request)
    {
        $customerId = $request->input('customer_id');
        $query = $request->input('query');

        $managersQuery = CustomerManager::query();

        if ($customerId) {
            $managersQuery->where('customer_id', $customerId);
        }

        if ($query) {
            $managersQuery->orWhere(function($q) use ($query) {
                $q->where('fname', 'like', "%$query%")
                ->orWhere('lname', 'like', "%$query%");
            });
        }



        $managers = $managersQuery->get();

        return response()->json(['managers' => $managers]);
    }
}
