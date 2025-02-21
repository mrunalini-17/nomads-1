<?php

namespace App\Http\Controllers;

use App\Models\PassengerCount;
use Illuminate\Http\Request;

class PassengerCountController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            // 'age' => 'required|integer|min:0',
            'gender' => 'required|string|in:male,female,other',
            'booking_id' => 'required|exists:bookings,id',
        ]);

        // Create a new passenger count
        $passenger = new PassengerCount($validated);
        $passenger->save();

        return response()->json(['success' => true, 'data' => $passenger]);
    }

    public function edit($id)
    {
        $passenger = PassengerCount::findOrFail($id);
        return response()->json($passenger);
    }

    public function update(Request $request, $id)
    {
        $passenger = PassengerCount::findOrFail($id);
        $passenger->update($request->all());
        return response()->json($passenger);
    }

    public function destroy($id)
    {
        $passenger = PassengerCount::findOrFail($id);
        $passenger->softDelete();
        return response()->json(['success' => true]);
    }
}
