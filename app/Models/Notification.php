<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'type_id',
        'employees',
        'message',
        'reason',
        'is_read',
        'read_by',
        'is_deleted',
    ];

    public function enquiry()
    {
        return $this->belongsTo(Enquiry::class,'type_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class,'type_id');
    }

    // public function getRolesAttribute()
    // {

    //     $roleIds = json_decode($this->for_role_id, true) ?? [];


    //     if (!empty($roleIds)) {
    //         return UserRole::whereIn('id', $roleIds)->pluck('name');
    //     }

    //     return collect();
    // }

    // public function readByEmployees()
    // {
    //     $readByIds = json_decode($this->read_by, true);

    //     if (is_array($readByIds) && count($readByIds) > 0) {
    //         return UserEmployee::whereIn('id', $readByIds)->get();
    //     }

    //     return collect();
    // }

    public function getEmployeesAttribute($value)
    {
        $employeeIds = json_decode($value, true) ?: [];
        return empty($employeeIds) ? collect() : UserEmployee::whereIn('id', $employeeIds)->get()->map(function ($employee) {
            // Concatenate first_name and last_name
            $employee->full_name = trim($employee->first_name . ' ' . $employee->last_name);
            return $employee;
        });
    }


    public function getReadByEmployeesAttribute()
    {
        $readByIds = json_decode($this->read_by, true); // Decode JSON to an array

        if (is_array($readByIds) && count($readByIds) > 0) {
            return UserEmployee::whereIn('id', $readByIds)->get()->map(function ($employee) {
                // Concatenate first_name and last_name
                $employee->full_name = trim($employee->first_name . ' ' . $employee->last_name);
                return $employee;
            });
        }

        return collect();
    }


    // public function roles()
    // {

    //     $roleIds = json_decode($this->for_role_id, true);
    //     return UserRole::whereIn('id', $roleIds)->get();
    // }

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
        $this->updated_by = auth()->id();
        $this->is_deleted = true;
        $this->save();
    }
}
