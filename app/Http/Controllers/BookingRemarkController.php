<?php

namespace App\Http\Controllers;

use App\Models\BookingRemark;
use Illuminate\Http\Request;

class BookingRemarkController extends Controller
{
    public function index($bookingId)
    {
        // Fetch only the remarks related to the specific booking ID
        $remarks = BookingRemark::active()->where('booking_id', $bookingId)->get();

        return response()->json([
            'remarks' => $remarks
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'remark_type' => 'required|string|max:255',
            'description' => 'required|string',
            // 'is_active' => 'required|boolean',
            // 'is_acknowledged' => 'required|boolean',
            'is_shareable' => 'required|boolean',
        ]);

        $remark_data['remark_type'] = $request->input('remark_type');
        $remark_data['booking_id'] = $request->input('booking_id');
        $remark_data['description'] = $request->input('description');
        $remark_data['is_shareable'] = $request->input('is_shareable');
        $remark_data['added_by'] = auth()->id();

        $remark = BookingRemark::create($remark_data);

        return response()->json(['remark' => $remark]);
    }
    public function edit($id)
    {
        $remark = BookingRemark::active()->findOrFail($id);
        return response()->json($remark);
    }

    public function show($id)
    {
        $remark = BookingRemark::active()->findOrFail($id);
        return response()->json(['remark' => $remark]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'remark_type' => 'required|string|max:255',
            'description' => 'required|string',
            // 'is_active' => 'required|boolean',
            // 'is_acknowledged' => 'required|boolean',
            'is_shareable' => 'required|boolean',
        ]);

        $remark_data['remark_type'] = $request->input('remark_type');
        $remark_data['booking_id'] = $request->input('booking_id');
        $remark_data['description'] = $request->input('description');
        $remark_data['is_shareable'] = $request->input('is_shareable');
        $remark_data['updated_by'] = auth()->id();

        $remark = BookingRemark::findOrFail($id);
        $remark->update($remark_data);

        return response()->json(['remark' => $remark]);
    }

    public function destroy($id)
    {
        $remark = BookingRemark::findOrFail($id);
        $remark->softDelete();
        return response()->json(['message' => 'Remark deleted successfully']);
    }
}
