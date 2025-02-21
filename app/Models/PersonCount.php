<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonCount extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'manager_id',
        'name',
        'age',
        'gender',
        'category',
        'count',
        'is_deleted',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
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
