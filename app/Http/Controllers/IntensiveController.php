<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Enquiry;
use App\Models\Intensive;
use App\Models\User;
use App\Models\UserEmployee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntensiveController extends Controller
{
    public function index()
    {
        // $intensives = Intensive::with(['user', 'enquiry', 'booking', 'addedBy', 'updatedBy'])->get();
        return view('homecontent.intensive.index');
    }

    public function create()
    {
        $users = UserEmployee::active()->get();
        $enquiries = Enquiry::active()->get();
        $bookings = Booking::active()->get();
        return view('homecontent.intensive.create', compact('users', 'enquiries', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'enquire_id' => 'required|exists:enquiries,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
        ]);

        try {
            Intensive::create(
                array_merge($request->all(), [
                    'added_by' => Auth::id(),
                ]),
            );

            return redirect()->route('intensive.index')->with('success', 'Intensive created successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Failed to create Intensive: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create Intensive. Please try again.');
        }
    }

    public function edit($id)
    {
        $intensive = Intensive::with(['user', 'enquiry', 'booking', 'addedBy', 'updatedBy'])->findOrFail($id);
        $users = UserEmployee::active()->get();
        $enquiries = Enquiry::active()->get();
        $bookings = Booking::active()->get();
        return view('homecontent.intensive.edit', compact('intensive', 'users', 'enquiries', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'enquire_id' => 'required|exists:enquiries,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
        ]);

        try {
            $intensive = Intensive::findOrFail($id);
            $intensive->update(array_merge($request->all(), [
                'updated_by' => Auth::id(),
            ]));

            return redirect()->route('intensive.index')->with('success', 'Intensive updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an issue updating the intensive.');
        }
    }


    public function destroy($id)
    {
        $intensive = Intensive::findOrFail($id);
        $intensive->softDelete();

        return redirect()->route('intensive.index')->with('success', 'Intensive deleted successfully.');
    }

    public function show($id)
    {
        $intensive = Intensive::findOrFail($id);
        return view('intensives.show', compact('intensive'));
    }
}
