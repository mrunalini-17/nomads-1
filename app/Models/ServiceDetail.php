<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDetail extends Model
{
    use HasFactory;

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
        'updates',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }


    public function card()
    {
        return $this->belongsTo(Card::class);
    }


    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }


    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }
}
