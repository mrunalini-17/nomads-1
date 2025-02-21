<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'enquire_id',
        'booking_id',
        'amount',
        'reason',
        'updated_by',
        'added_by',
        'is_deleted',
    ];

    public function user()
    {
        return $this->belongsTo(UserEmployee::class);
    }

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquire_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
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
