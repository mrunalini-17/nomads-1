<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Models\Enquiry;
use App\Models\Booking;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    // public function index()
    // {
    //     return view('homecontent.notifications.index');
    // }
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->get();

        // Manually retrieve the employees who have read each notification
        foreach ($notifications as $notification) {
            $notification->readEmployees = $notification->read_by_employees;

        }

        // dd($notifications);

        return view('homecontent.notifications.index', compact('notifications'));
    }

    public function create()
    {
        $employees = UserEmployee::active()->get();
        $enquiries = Enquiry::active()->get();
        $bookings = Booking::active()->get();
        return view('homecontent.notifications.create', compact('employees', 'enquiries', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:enquiries,id',
            'enquired_by' => 'required|exists:users,id',
            'message' => 'required|string',
            'reason' => 'required|in:booking,alert',
            'message_read' => 'nullable|boolean',
            'message_read_by_sales' => 'nullable|exists:users,id',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        try {
            Notification::create([
                'enquiry_id' => $request->enquiry_id,
                'enquired_by' => $request->enquired_by,
                'message' => $request->message,
                'reason' => $request->reason,
                'message_read' => $request->has('message_read') ? true : false,
                'message_read_by_sales' => $request->message_read_by_sales,
                'booking_id' => $request->booking_id,
                'added_by' => $request->added_by ?? Auth::id(),
            ]);

            return redirect()->route('notifications.index')->with('success', 'Notification created successfully.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Failed to create notification: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        $users = UserEmployee::all();
        $enquiries = Enquiry::all();
        $bookings = Booking::all();

        return view('homecontent.notifications.edit', compact('notification', 'users', 'enquiries', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:enquiries,id',
            'enquired_by' => 'required|exists:users,id',
            'message' => 'required|string',
            'reason' => 'required|in:booking,alert',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        try {
            $notification = Notification::findOrFail($id);
            $notification->update(
                array_merge($request->all(), [
                    'updated_by' => Auth::id(),
                ]),
            );

            return redirect()->route('notifications.index')->with('success', 'Notification updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('notifications.index')->with('error', 'There was an issue updating the notification.');
        }
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->softDelete();

            return redirect()->route('notifications.index')->with('success', 'Notification deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('notifications.index')->with('error', 'There was an issue deleting the notification.');
        }
    }
    public function fetchNotifications()
    {
        $userId = Auth::id();

        // Check the result of this query for debugging
        $notifications = Notification::whereJsonContains('employees', $userId)
            ->whereJsonDoesntContain('read_by', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return response()->json($notifications);
    }


    public function markAsRead($id)
{
    $userId = Auth::id();
    $notification = Notification::find($id);

    if ($notification) {

        $readBy = $notification->read_by ? json_decode($notification->read_by, true) : [];

        if (!in_array($userId, $readBy)) {

            $readBy[] = $userId;
        }

        $notification->read_by = json_encode($readBy);
        $notification->is_read = true;

        $notification->save();
    }

    return response()->json(['success' => true]);
}

}
