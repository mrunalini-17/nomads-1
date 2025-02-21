<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Enquiry;
use App\Models\Followup;
use App\Models\User;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FollowupController extends Controller
{

    public function index()
    {
        $emp = Auth::id();
        $today = now()->format('Y-m-d');
        $followupsToday = Followup::active()->with('enquiry')->whereDate('fdate', $today)->where('added_by', $emp)->get();
        $followupsUpcoming = Followup::active()->with('enquiry')->whereDate('fdate', '>', $today)->where('added_by', $emp)->get();
        $followupsMissed = Followup::active()->with('enquiry')->whereDate('fdate', '<', $today)->where('status', 0)->where('added_by', $emp)->get();

        // dd($followupsUpcoming);

        return view('homecontent.followup.index', [
            'followupsToday' => $followupsToday,
            'followupsUpcoming' => $followupsUpcoming,
            'followupsMissed' => $followupsMissed,
        ]);
    }

    public function create()
    {
        $enquiries = Enquiry::active()->get(); // Fetch all enquiries
        $users = UserEmployee::active()->get(); // Fetch all users
        return view('homecontent.followup.create', compact('enquiries', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:enquiries,unique_code',
            'fdate' => 'required|date',
            'ftime' => 'required|date_format:H:i',
            'remark' => 'required|string',
            'type' => 'required|in:Routine Follow-up,Schedule Meeting',
            // 'status' => 'required|in:1,0',
        ]);

        Followup::create(array_merge(
            $request->all(),
            ['added_by' => auth()->id()],
        ),);

        return redirect()->route('followups.index')->with('success', 'Follow-up created successfully.');
    }

    public function edit($id)
    {
        $followup = Followup::findOrFail($id); // Find the follow-up record by ID
        $enquiries = Enquiry::active()->get();  // Fetch all enquiries
        $users = UserEmployee::active()->get();  // Fetch all users

        return view('homecontent.followup.edit', compact('followup', 'enquiries', 'users'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validate the request data
            $request->validate([
                'enquiry_id' => 'nullable|exists:enquiries,id',
                'user_id' => 'required|exists:employees,id',
                'followup_date' => 'required|date',
                'followup_time' => 'nullable',
                'remarks' => 'nullable|string',
                'followup_type' => 'required|in:routine_followup,schedule_meeting',
                'status' => 'required|in:active,inactive',
            ]);

            // Find the follow-up record by ID
            $followup = Followup::findOrFail($id);

            // Update the record with new data, including the current logged-in user ID for updated_by
            $followup->update(
                array_merge(
                    $request->all(),
                    ['updated_by' => auth()->id()],
                ),
            );

            // Redirect with success message
            return redirect()->route('followups.index')->with('success', 'Follow-up updated successfully.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Handle the case when the follow-up record is not found
            return redirect()->back()->with('error', 'Follow-up not found.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()
                ->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            // Handle any other exceptions
            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating the follow-up: ' . $e->getMessage());
        }
    }


    public function followups_update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required|exists:followups,id',
                'note' => 'nullable|string|max:255',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }


            $followup = Followup::findOrFail($request->id);

            $followup->update([
                'status' => true,
                'note' => $request->input('note'),
                'updated_by' => Auth::id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Followup updated successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update followup: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        // Fetch the enquiry by unique code
        $enquiry = Enquiry::where('unique_code', $id)->first();

        // Check if the enquiry exists
        if (!$enquiry) {
            return response()->json([
                'status' => 'error',
                'message' => 'Enquiry not found.',
            ], 404);
        }

        // Return the enquiry details as JSON
        return response()->json([
            'status' => 'success',
            'data' => $enquiry,
        ]);
    }


    public function destroy(Followup $followup)
    {
        $followup->softDelete();
        return redirect()->route('followups.index')->with('success', 'Follow-up deleted successfully.');
    }
}
