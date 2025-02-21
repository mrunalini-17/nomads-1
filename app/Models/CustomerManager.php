<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'fname',
        'lname',
        'mobile',
        'whatsapp',
        'email',
        'relation',
        'updated_by',
        'added_by',
        'is_deleted',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function softDelete($id)
    {
        $this->is_deleted = true;
        $this->updated_by = $id;
        $this->save();
    }
}
