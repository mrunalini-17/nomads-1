<?php

namespace App\Http\Controllers;

use App\Models\Penalty;
use App\Models\User;
use App\Models\UserEmployee;
use App\Models\Enquiry;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PenaltyController extends Controller
{
    public function index()
    {
        $penalties = Penalty::active()->with(['user', 'enquiry', 'booking', 'addedBy', 'updatedBy'])->get();
        return view('homecontent.penalty.index', compact('penalties'));
    }

    public function create()
    {
        $users = UserEmployee::active()->get();
        $enquiries = Enquiry::active()->get();
        $bookings = Booking::active()->get();
        return view('homecontent.penalty.create', compact('users', 'enquiries', 'bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'enquire_id' => 'required|exists:enquiries,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'reason' => 'required|string|max:255',
        ]);

        try {
            Penalty::create(array_merge($request->all(), [
                'added_by' => Auth::id(),
            ]));

            return redirect()->route('penalties.index')->with('success', 'Penalty created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('penalties.index')->with('error', 'There was an issue creating the penalty.');
        }
    }

    public function edit($id)
    {
        $penalty = Penalty::findOrFail($id);
        $users = UserEmployee::active()->get();
        $enquiries = Enquiry::active()->get();
        $bookings = Booking::active()->get();

        return view('homecontent.penalty.edit', compact('penalty', 'users', 'enquiries', 'bookings'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'enquire_id' => 'required|exists:enquiries,id',
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric',
            'reason' => 'required|string|max:255',
        ]);

        try {
            $penalty = Penalty::findOrFail($id);
            $penalty->update(array_merge($request->all(), [
                'updated_by' => Auth::id(),
            ]));

            return redirect()->route('penalties.index')->with('success', 'Penalty updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('penalties.index')->with('error', 'There was an issue updating the penalty.');
        }
    }

    public function destroy($id)
    {
        try {
            $penalty = Penalty::findOrFail($id);
            $penalty->softDelete();

            return redirect()->route('penalties.index')->with('success', 'Penalty deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('penalties.index')->with('error', 'There was an issue deleting the penalty.');
        }
    }
}

