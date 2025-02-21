<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $casts = [
        'accepted_at' => 'datetime',
    ];

    protected $fillable = [
        'unique_code','fname', 'lname','mobile', 'whatsapp', 'email', 'address', 'source_id', 'priority',
        'services', 'employees', 'status', 'note', 'is_accepted', 'accepted_by', 'updated_by',
        'added_by', 'is_deleted','is_transferred','accepted_at'
    ];

    public function followups()
    {
        return $this->hasMany(Followup::class);
    }

    public function getServicesAttribute($value)
    {
        $serviceIds = json_decode($value, true) ?: [];
        return empty($serviceIds) ? collect() : Service::whereIn('id', $serviceIds)->get();
    }

    public function getEmployeesAttribute($value)
    {
        $employeeIds = json_decode($value, true) ?: [];
        return empty($employeeIds) ? collect() : UserEmployee::whereIn('id', $employeeIds)->get();
    }

    public function enquiryRemarks()
    {
        return $this->hasMany(EnquiryRemark::class, 'enquiry_id');
    }

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }

    public function source()
    {
        return $this->belongsTo(Source::class, 'source_id');
    }


    public function acceptedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'accepted_by');
    }


    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function softDelete()
    {
        $this->updated_by = auth()->id();
        $this->is_deleted = true;
        $this->save();
    }
}
