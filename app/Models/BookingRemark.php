<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingRemark extends Model
{
    use HasFactory;
    protected $table = 'booking_remark';
    protected $fillable = [
        'booking_id',
        'description',
        'remark_type',
        'is_active',
        'is_acknowledged',
        'is_shareable',
        'acknowledged_by',
        'updated_by',
        'added_by',
        'is_deleted',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }
    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
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
