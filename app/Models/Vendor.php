<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gst_no',
        'contact',
        'email',
        'managed_by',
    ];

    /**
     * Get the user that manages the vendor.
     */
    public function manager()
    {
        return $this->belongsTo(UserEmployee::class, 'managed_by');
    }

    public function managedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'managed_by');
    }

    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }
}
