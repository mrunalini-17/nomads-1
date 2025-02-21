<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'booking_services';
    protected $fillable = [
        'booking_id',
        'service_details',
        'service_type',
        'travel_date1',
        'travel_date2',
        'confirmation_number',
        'gross_amount',
        'net',
        'service_fees',
        'mask_fees',
        'bill',
        'bill_to',
        'bill_to_remark',
        'tcs',
        'card_id',
        'supplier_id',
        'updated_by',
        'added_by',
        'is_deleted',
        'is_approved',
    ];

    // Relationships

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    /**
     * Get the card associated with the service.
     */
    public function card()
    {
        return $this->belongsTo(Card::class, 'card_id');
    }

    /**
     * Get the supplier associated with the service.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    /**
     * Get the user who added the booking service.
     */
    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }

    public function bookingConfirmations()
    {
        return $this->hasMany(BookingConfirmation::class);
    }


    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }
}
