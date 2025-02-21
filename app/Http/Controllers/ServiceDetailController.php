<?php
namespace App\Http\Controllers;

use App\Models\ServiceDetail;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceDetailController extends Controller
{
    public function edit($id)
    {
        $serviceDetail = ServiceDetail::findOrFail($id);
        return response()->json($serviceDetail);
    }

    // Update an existing service detail
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $serviceDetail = ServiceDetail::findOrFail($id);
        if($serviceDetail->is_approved){
            //

            $serviceDetailnew = ServiceDetail::create([
                'booking_id' => $request->input('booking_id'),
                'service_details' => $request->input('service_details'),
                'travel_date1' => $request->input('travel_date1'),
                'travel_date2' => $request->input('travel_date2'),
                'confirmation_number' => $request->input('confirmation_number'),
                'net' => $request->input('net'),
                'gross_amount' => $request->input('gross_amount'),
                'service_fees' => $request->input('service_fees'),
                'mask_fees' => $request->input('mask_fees'),
                'tcs' => $request->input('tcs'),
                'bill_to' => $request->input('bill_to'),
                'bill_to_remark' => $request->input('bill_to_remark'),
                'supplier_id' => $request->input('supplier_id'),
                'card_id' => $request->input('card_id'),
                'updates' => $request->input('changes'),
            ]);

        }
        else{
            $serviceDetail->update($request->all());
        }

        $booking_id = $request->input('booking_id');
        $booking = Booking::findOrFail($booking_id);
        $booking->update([
            'is_approved' => false,
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true]);

    }

    public function store(Request $request)
    {
        // No validation applied

        try {
            // Create a new service detail
            $serviceDetail = ServiceDetail::create([
                'booking_id' => $request->input('booking_id'),
                'service_details' => $request->input('service_details'),
                'travel_date1' => $request->input('travel_date1'),
                'travel_date2' => $request->input('travel_date2'),
                'confirmation_number' => $request->input('confirmation_number'),
                'net' => $request->input('net'),
                'gross_amount' => $request->input('gross_amount'),
                'service_fees' => $request->input('service_fees'),
                'mask_fees' => $request->input('mask_fees'),
                'tcs' => $request->input('tcs'),
                'bill_to' => $request->input('bill_to'),
                'bill_to_remark' => $request->input('bill_to_remark'),
                'supplier_id' => $request->input('supplier_id'),
                'card_id' => $request->input('card_id'),
            ]);

            return response()->json([
                'success' => true,
                'serviceDetail' => $serviceDetail,
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    // Delete a service detail
    public function destroy($id)
    {
        ServiceDetail::destroy($id);
        return response()->json(['success' => true]);
    }
}
