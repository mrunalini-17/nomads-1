<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model
{
    use HasFactory;

    protected $fillable = ['department_id', 'name', 'updated_by', 'added_by','is_deleted'];

    public function department()
    {
        return $this->belongsTo(Department::class);
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
