<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnquiryRemark extends Model
{
    use HasFactory;
    protected $table = 'enquiry_remarks';
    protected $fillable = [
        'enquiry_id',
        'remark_type',
        'description',
        'is_acknowledged',
        'is_shareable',
        'acknowledged_by',
        'email_sent',
        'updated_by',
        'added_by',
        'is_deleted',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class, 'enquiry_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }
    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }
    public function acknowledgedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'acknowledged_by');
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
