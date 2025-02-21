<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_id',
        'booking_id',
        'message',
        'reason',
        'message_read',
        'message_read_by_user',
        'updated_by',
        'added_by',
        'is_deleted'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(UserEmployee::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function messageReadByUser()
    {
        return $this->belongsTo(UserEmployee::class, 'message_read_by_user');
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
