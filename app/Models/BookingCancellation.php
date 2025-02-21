<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingCancellation extends Model
{

    use HasFactory;

    protected $table = 'booking_cancellations';

    protected $fillable = [
        'booking_id',
        'reason',
        'details',
        'charges',
        'charges_received',
        'added_by',
        'updated_by',
        'is_cancelled',
        'is_deleted',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class,'booking_id');
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
