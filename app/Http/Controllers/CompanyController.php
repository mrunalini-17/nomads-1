<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class CompanyController extends Controller
{
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'company_name' => 'required|string|max:255',
            'company_mobile' => 'nullable|string|max:10',
            'company_gst' => 'nullable|string|max:15',
            'company_address' => 'nullable|string|max:500',
        ]);

        try {

            Company::create([
                'customer_id' => $validatedData['customer_id'],
                'name' => $validatedData['company_name'],
                'mobile' => $validatedData['company_mobile'],
                'gst' => $validatedData['gst'],
                'address' => $validatedData['company_gst'],
                'added_by' => Auth::id(),
            ]);

            $customer = Customer::find($request->customer_id);
            $customer->update(['have_company' => true]);

            return redirect()->back()->with('success', 'Customer\'s company information added successfully.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to save the company: ' . $e->getMessage());
        }
    }


    public function storeforbooking(Request $request)
    {
        $validatedData = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'company_name' => 'nullable|string|max:255',
            'company_mobile' => 'nullable|string|max:10',
            'company_gst' => 'nullable|string|max:15',
            'company_address' => 'nullable|string|max:500',
        ]);

        try {
            Company::create([
                'customer_id' => $validatedData['customer_id'],
                'name' => $validatedData['company_name'],
                'mobile' => $validatedData['company_mobile'],
                'gst' => $validatedData['company_gst'], // Fix here
                'address' => $validatedData['company_address'], // Fix here
                'added_by' => Auth::id(),
            ]);

            $customer = Customer::find($request->customer_id);
            $customer->update(['have_company' => true]);

            return response()->json(['success' => true,
                                     'message' => 'Customer\'s company information added successfully.',
                                     'company_name' => $validatedData['company_name']]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to save the company: ' . $e->getMessage()], 500);
        }
    }



    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'gst' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        try {
            $company = Company::findOrFail($id);

            $company->update([
                'name' => $validatedData['name'],
                'mobile' => $validatedData['mobile'],
                'gst' => $validatedData['gst'],
                'address' => $validatedData['address'],
                'updated_by' => Auth::id(),
            ]);

            return redirect()->back()->with('success', 'Customer\'s company information updated successfully.');

        } catch (\Exception $e) {
            // \Log::error('Customer Company Update Error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An error occurred while updating the company. Please try again. ' . $e->getMessage());
        }
    }


    public function searchCompany(Request $request)
    {
        //$companyId = $request->input('company_id');
        $query = $request->input('query');

        $cquery = Company::query();

        // if ($companyId) {
        //     $cquery->where('id', $companyId);
        // }

        if ($query) {
            $cquery->where(function($q) use ($query) {
                $q->where('name', 'like', "%$query%");
            });
        }

        $company = $cquery->get();

        return response()->json(['company' => $company]);
    }

    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $customer = Customer::findOrFail($company->customer_id);
        $company->update([
            'is_deleted' => 1,
            'updated_by' => Auth::id(),
        ]);

        $customer->update([
            'have_company' => false,
            'updated_by' => Auth::id(),
        ]);


        return redirect()->back()->with('success', 'Customer\'s company deleted successfully.');
    }

    public function searchCompanies(Request $request)
    {
        $query = $request->input('query');
        $companies = Company::where('name', 'like', "%$query%")
                            ->where('is_deleted',0)
                            ->get();

        return response()->json(['companies' => $companies]);
    }
}
