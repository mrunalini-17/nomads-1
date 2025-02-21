<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Source;
use App\Models\UserEmployee;
use App\Models\Customer;
use App\Models\EnquiryRemark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function enquiry_index()
    {
        $services = Service::active()->get();
        $sources = Source::active()->get();
        $employees = UserEmployee::active()->where('is_active', true)
            ->whereHas('userRole', function ($query) {
                $query->where('name', '!=', 'Accounts'); // Exclude role name 'Accounts'
            })
            ->orderBy('first_name', 'asc')
            ->get();
            $enquiries = null;
        return view('homecontent.reports.enquiryindex', compact('services','sources','employees','enquiries'));
    }

    public function operations_enquiry_index()
    {
        $services = Service::active()->get();
        $sources = Source::active()->get();
        $enquiries = null;
        return view('homecontent.reports.operationsenquiryindex', compact('services','sources','enquiries'));
    }

    public function booking_index()
    {
        $loggedInUser = auth()->user();

        $services = Service::active()->get();
        $customers = Customer::active()->get();

        $employees = UserEmployee::active()
        ->where('is_active', true)
        ->whereHas('userRole', function ($query) {
            $query->where('name', '!=', 'Accounts'); // Exclude role name 'Accounts'
        })
        ->orderBy('first_name', 'asc')
        ->get();

        return view('homecontent.reports.bookingindex', compact('services','employees','customers'));
    }

    public function operations_booking_index()
    {
        $services = Service::active()->get();
        $customers = Customer::active()->get();

        return view('homecontent.reports.operationsbookingindex', compact('services','customers'));
    }

    public function enquiry_reports(Request $request)
    {
        // dd($request->all());

        // Start a query for Enquiry model
        $query = Enquiry::active()->with('addedBy','source','acceptedBy');

        // Customer search: match fname or lname
        if ($request->filled('customer')) {
            $customerSearch = $request->customer;
            $query->where(function ($q) use ($customerSearch) {
                $q->where('fname', 'like', '%' . $customerSearch . '%')
                  ->orWhere('lname', 'like', '%' . $customerSearch . '%');
            });
        }

        if ($request->filled('unique_code')) {
            $uid = $request->unique_code;
            $query->where('unique_code', 'like', '%' . $uid . '%');
        }

        // Filter by Services if selected
        if ($request->filled('services')) {
            $services = $request->input('services');

            // Assuming 'services' column stores service IDs as JSON
            $query->whereJsonContains('services', $services);
        }

        // Filter by Sources if selected
        if ($request->filled('sources')) {
            $query->where('source_id', $request->input('sources'));
        }

        // Filter by Priority if selected
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Filter by Status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Assigned to (employee) if selected
        if ($request->filled('assigned_to')) {
            $employee = (int) $request->input('assigned_to');
            $query->whereJsonContains('employees', $employee);
        }

        // Filter by Added by (employee) if selected
        if ($request->filled('added_by')) {
            $query->where('added_by', $request->input('added_by'));
        }

        // Filter by Accepted  if selected
        if ($request->filled('accepted')) {
            $query->where('is_accepted', $request->input('accepted'));
        }

        // Filter by Date Range (From Date and To Date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

            // Log the generated SQL query
            // \Log::info($query->toSql());

        // Execute the query and get results
        $enquiries = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['enquiries' => $enquiries]);
    }

    public function operations_enquiry_reports(Request $request)
    {
        // dd($request->all());

        $emp_id = auth()->id();

        $query = Enquiry::active()->with('addedBy', 'source', 'acceptedBy')
                ->where(function ($q) use ($emp_id) {
                    $q->where(function ($q1) use ($emp_id) {
                            $q1->where('added_by', $emp_id) // Created by the employee
                                ->whereNull('accepted_by'); // But not yet accepted
                        })
                    ->orWhere(function ($q2) use ($emp_id) {
                        $q2->whereJsonContains('employees', $emp_id) // Assigned to the employee
                            ->whereNull('accepted_by'); // But not yet accepted
                    })
                    ->orWhere('accepted_by', $emp_id); // Accepted by the employee
                });


        // Customer search: match fname or lname
        if ($request->filled('customer')) {
            $customerSearch = $request->customer;
            $query->where(function ($q) use ($customerSearch) {
                $q->where('fname', 'like', '%' . $customerSearch . '%')
                  ->orWhere('lname', 'like', '%' . $customerSearch . '%');
            });
        }

        if ($request->filled('unique_code')) {
            $uid = $request->unique_code;
            $query->where('unique_code', 'like', '%' . $uid . '%');
        }

        // Filter by Services if selected
        if ($request->filled('services')) {
            $services = $request->input('services');

            // Assuming 'services' column stores service IDs as JSON
            $query->whereJsonContains('services', $services);
        }

        // Filter by Sources if selected
        if ($request->filled('sources')) {
            $query->where('source_id', $request->input('sources'));
        }

        // Filter by Priority if selected
        if ($request->filled('priority')) {
            $query->where('priority', $request->input('priority'));
        }

        // Filter by Status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Date Range (From Date and To Date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        // Execute the query and get results
        $enquiries = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['enquiries' => $enquiries]);
    }

    public function booking_reports(Request $request)
    {
        // dd($request->all());

        // Start a query for Enquiry model
        $query = Booking::active()->with('addedBy','acceptedBy','customer','service');

        // Customer
        if ($request->filled('customer')) {
            $query->where('customer_id', $request->input('customer'));
        }
        if ($request->filled('unique_code')) {
            $uid = $request->unique_code;
            $query->where('unique_code', 'like', '%' . $uid . '%');
        }
        // Filter by Services if selected
        if ($request->filled('service')) {
            $query->where('service_id', $request->input('service'));
        }

        // Filter by Status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Added by (employee) if selected
        if ($request->filled('added_by')) {
            $query->where('added_by', $request->input('added_by'));
        }

        // Filter by Accepted  if selected
        if ($request->filled('accepted')) {
            $query->where('is_accepted', $request->input('accepted'));
        }

        // Filter by Date Range (From Date and To Date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        // Execute the query and get results
        $bookings = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['bookings' => $bookings]);
    }

    public function operations_booking_reports(Request $request)
    {
        // dd($request->all());
        $emp_id = auth()->id();
        // Start a query for Enquiry model
        $query = Booking::active()->where('added_by', $emp_id)->with('addedBy','acceptedBy','customer','service');

        // Customer
        if ($request->filled('customer')) {
            $query->where('customer_id', $request->input('customer'));
        }
        if ($request->filled('unique_code')) {
            $uid = $request->unique_code;
            $query->where('unique_code', 'like', '%' . $uid . '%');
        }
        // Filter by Services if selected
        if ($request->filled('service')) {
            $query->where('service_id', $request->input('service'));
        }

        // Filter by Status if selected
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by Accepted  if selected
        if ($request->filled('accepted')) {
            $query->where('is_accepted', $request->input('accepted'));
        }

        // Filter by Date Range (From Date and To Date)
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->input('to_date'));
        }

        // Execute the query and get results
        $bookings = $query->orderBy('created_at', 'desc')->get();

        return response()->json(['bookings' => $bookings]);
    }


}
