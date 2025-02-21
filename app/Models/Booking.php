<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_code',
        'customer_id',
        'customer_manager_id',
        'user_id',
        'booking_date',
        'passenger_count',
        'service_id',
        'status',
        'pan_number',
        'invoice_number',
        'payment_status',
        'payment_received_remark',
        'office_reminder',
        'url',
        'is_cancelled',
        'is_approved',
        'is_accepted',
        'accepted_by',
        'updated_by',
        'added_by',
        'is_deleted',
        'is_approved',
    ];

    public function reference()
    {
        return $this->belongsTo(Reference::class)->where('is_deleted', false);
    }

    public function customer()
    {
        // return $this->belongsTo(Customer::class)->where('is_deleted', false);
        return $this->belongsTo(Customer::class);
    }

    public function customerManager()
    {
        return $this->belongsTo(Customer::class, 'customer_manager_id');
    }

    public function userEmployee()
    {
        return $this->belongsTo(UserEmployee::class)->where('is_deleted', false);
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function bill()
    {
        return $this->belongsTo(Customer::class, 'bill_id');
    }

    public function bookedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'booked_by');
    }

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }

    public function acceptedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'accepted_by');
    }

    public function bookingCancellation()
    {
        return $this->hasOne(BookingCancellation::class);
    }

    public function passengerCounts()
    {
        return $this->hasMany(PassengerCount::class)->where('is_deleted', false);
    }

    public function card()
    {
        return $this->belongsTo(Card::class);
    }

    public function bookingServices()
    {
        return $this->hasMany(BookingService::class, 'booking_id');
    }

    public function bookingRemarks()
    {
        return $this->hasMany(BookingRemark::class, 'booking_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    // Add a method to handle soft delete
    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }

    // Optional: If you need to get soft-deleted records
    public function scopeOnlyDeleted($query)
    {
        return $query->where('is_delete', true);
    }

    public function serviceDetails()
    {
        return $this->hasMany(ServiceDetail::class, 'booking_id', 'id');
    }

    public function bookingConfirmations()
    {
        return $this->hasMany(BookingConfirmation::class);
    }

}
