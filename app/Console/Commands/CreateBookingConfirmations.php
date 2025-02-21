<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use App\Models\BookingConfirmation;
use Carbon\Carbon;

class CreateBookingConfirmations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-booking-confirmations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
   public function handle()
{
    $today = Carbon::today()->toDateString();

    // Get bookings with services having travel_date1 or travel_date2 today or in the future
    $bookings = Booking::whereHas('bookingServices', function ($query) use ($today) {
        $query->where('travel_date1', '>=', $today)
              ->orWhere('travel_date2', '>=', $today);
    })->get();

    foreach ($bookings as $booking) {
        foreach ($booking->bookingServices as $service) {
            // Check and create for travel_date1 if it is today or in the future
            if ($service->travel_date1 && $service->travel_date1 >= $today) {
                $confirmationExists = BookingConfirmation::where('booking_service_id', $service->id)
                                                         ->whereDate('date', $service->travel_date1)
                                                         ->exists();

                if (!$confirmationExists) {
                    BookingConfirmation::create([
                        'booking_id' => $booking->id,
                        'booking_service_id' => $service->id,
                        'date' => $service->travel_date1,
                        'is_delivered' => false,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                }
            }

            // Check and create for travel_date2 if it is today or in the future
            if ($service->travel_date2 && $service->travel_date2 >= $today) {
                $confirmationExists = BookingConfirmation::where('booking_service_id', $service->id)
                                                         ->whereDate('date', $service->travel_date2)
                                                         ->exists();

                if (!$confirmationExists) {
                    BookingConfirmation::create([
                        'booking_id' => $booking->id,
                        'booking_service_id' => $service->id,
                        'date' => $service->travel_date2,
                        'is_delivered' => false,
                        'created_by' => 1,
                        'updated_by' => 1,
                    ]);
                }
            }
        }
    }

    $this->info('Booking confirmations created successfully for today\'s and future travel dates.');
}

}
