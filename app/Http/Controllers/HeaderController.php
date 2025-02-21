<?php
// app/Http/Controllers/NotificationController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Reminder;

class NotificationController extends Controller
{
    //  public function getNotifications()
    // {
    //     $userId = Auth::id();

    //     $notifications = Notification::where('enquired_by', $userId)
    //         ->where('message_read', false)
    //         ->latest()
    //         ->take(5) // Adjust as needed
    //         ->get();

    //     return response()->json($notifications);
    // }

    // public function getReminders()
    // {
    //     $userId = Auth::id();

    //     $reminders = Reminder::where('user_id', $userId)
    //         ->where('message_read', false)
    //         ->latest()
    //         ->take(5) // Adjust as needed
    //         ->get();

    //     return response()->json($reminders);
    // }
}

