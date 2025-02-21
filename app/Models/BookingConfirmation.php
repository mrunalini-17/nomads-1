<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingConfirmation extends Model
{
    use HasFactory;

    // Define the table name (optional if it follows Laravel's naming convention)
    protected $table = 'booking_confirmations';

    // Define fillable attributes for mass assignment
    protected $fillable = [
        'date',
        'booking_id',
        'booking_service_id',
        'is_delivered',
        'note',
        'updated_by',
    ];

    /**
     * Define relationships.
     */

    // Booking relationship
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // BookingService relationship
    public function bookingService()
    {
        return $this->belongsTo(BookingService::class);
    }

    // Updated by (employee) relationship
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }
}
