<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Models\Service;
use App\Models\SupplierService;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::active()->with('services')->orderBy('id', 'desc')->get();
        $services = Service::active()->orderBy('name', 'asc')->get();
        return view('homecontent.masterdata.suppliers.suppliers', compact('suppliers','services'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'gstin' => 'nullable',
                'contact' => 'nullable|string|max:15',
                'contact_person' => 'nullable|string|max:255',
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
            ]);

            $existingSupplier = Supplier::where('name', $request->name)
                ->where('contact', $request->contact)
                ->first();

            if ($existingSupplier) {
                return response()->json([
                    'success' => false,
                    'message' => 'A supplier with the same name already exists.',
                ], 409);
            }


            $supplier = Supplier::create([
                'name' => $request->name,
                'gstin' => $request->gstin,
                'contact' => $request->contact,
                'email' => $request->email,
                'contact_person' => $request->contact_person,
                'added_by' => Auth::id(),
            ]);

            $supplier->services()->attach($request->services);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'id' => $supplier->id,
                    'name' => $supplier->name,
                ]);
            }

            return redirect()->route('suppliers.index')->with('success', 'Supplier added successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating service: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while creating the supplier. Please try again.',
                ], 500);
            }


            return redirect()->back()->with('error',  'An error occurred while creating the service. Please try again.'. $e->getMessage());
        }
    }

    public function edit($id)
    {
        $supplier = Supplier::with('services')->findOrFail($id);
        $services = Service::active()->orderBy('name', 'asc')->get();
        return response()->json([
            'supplier' => $supplier,
            'services' => $services
        ]);
    }


    public function update(Request $request)
    {
        //dd($request->all());
        try {

            $request->validate([
                'editName' => 'required|string|max:255',
                'editgstin' => 'nullable',
                'editcontact' => 'nullable|string|max:15',
                'editcontact_person' => 'nullable|string|max:255',
                'services' => 'required|array',
                'services.*' => 'exists:services,id',
            ]);

            $id = $request->id;

            $supplier = Supplier::findOrFail($id);

            $supplier->update([
                'name' => $request->input('editName'),
                'contact' => $request->input('editcontact'),
                'gstin' => $request->input('editgstin'),
                'email' => $request->input('editemail'),
                'contact_person' => $request->input('editcontact_person'),
                'updated_by' => Auth::id(),
            ]);

            // Sync services
            $supplier->services()->sync($request->input('services', []));

            return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');

        } catch (\Exception $e) {
            \Log::error('Error creating source: ' . $e->getMessage());
            // return redirect()->back()->with('error', 'An error occurred while updating the service. Please try again.');
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->softDelete();

            $serviceIds = $supplier->services()->pluck('supplier_services.service_id')->toArray();

            // Update the pivot table to mark the services as deleted
            $supplier->services()->updateExistingPivot($serviceIds, ['is_deleted' => true]);


            return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');

        } catch (\Exception $e) {
            \Log::error('Error deleting supplier: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the service. Please try again.' . $e->getMessage());
        }
    }


    public function getSuppliers(Request $request, $serviceId)
    {
        $search = $request->input('query');
        $suppliers = Supplier::active()
            ->whereHas('services', function ($query) use ($serviceId) {
                $query->where('service_id', $serviceId);
            })
            ->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
            ->get();

        return response()->json(['suppliers' => $suppliers]);
    }





}
