<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Customer;
use App\Models\Reminder;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    public function index()
    {
        return view('homecontent.reminder.index');
    }
    // public function index()
    // {
    //     $reminders = Reminder::with(['customer', 'user', 'booking', 'messageReadByUser', 'addedBy', 'updatedBy'])->get();
    //     return view('homecontent.reminder.index', compact('reminders'));
    // }

    public function create()
    {
        // Retrieve necessary data from the database
        $customers = Customer::all();
        $users = UserEmployee::all();
        $bookings = Booking::all();

        // Pass the data to the view
        return view('homecontent.reminder.create', compact('customers', 'users', 'bookings'));
    }

    public function store(Request $request)
    {
        try {
            // Validate incoming request data
            $data = $request->validate([
                'customer_id' => 'required|exists:customers,id',
                'user_id' => 'required|exists:users,id',
                'booking_id' => 'required|exists:bookings,id',
                'message' => 'required|string',
                'reason' => 'required|in:booking,alert',
                'message_read' => 'boolean',
                'message_read_by_user' => 'nullable|exists:users,id',
                'updated_by' => 'nullable|integer',
            ]);

            // Set the added_by field to the current authenticated user's ID
            $data['added_by'] = auth()->id();

            // Create the reminder
            Reminder::create($data);

            // Redirect with success message
            return redirect()->route('reminders.index')->with('success', 'Reminder created successfully.');
        } catch (\Exception $e) {
            // Redirect back with error message for display
            return redirect()
                ->back()
                ->withErrors(['error' => 'An error occurred while creating the reminder: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $reminder = Reminder::findOrFail($id);
        $customers = Customer::all();
        $users = UserEmployee::all();
        $bookings = Booking::all();

        return view('homecontent.reminder.edit', compact('reminder', 'customers', 'users', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'user_id' => 'required|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
            'message' => 'required|string',
            'reason' => 'required|in:booking,alert',
            'message_read' => 'boolean',
            'message_read_by_user' => 'nullable|exists:users,id',
        ]);

        $reminder = Reminder::findOrFail($id);
        $reminder->update(array_merge($data, [
            'updated_by' => auth()->id(), // Automatically set the updated_by field
        ]));

        return redirect()->route('reminders.index')->with('success', 'Reminder updated successfully.');
    }


    public function destroy(Reminder $reminder)
    {
        try {
            $reminder->delete();
            return redirect()->route('reminders.index')->with('success', 'Reminder deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('reminders.index')->with('error', 'Failed to delete reminder.');
        }
    }
    public function fetchReminders()
    {
        $userId = Auth::id(); // Get the ID of the currently logged-in user

        $reminders = Reminder::where('user_id', $userId) // Filter by the logged-in user's ID
            ->where('message_read', false)
            ->orderBy('created_at', 'desc')
            ->take(5) // Adjust the number as needed
            ->get();

        return response()->json($reminders);
    }
}
