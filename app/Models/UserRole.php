<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active', 'updated_by', 'added_by','is_deleted'];

    public function addedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'added_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(UserEmployee::class, 'updated_by');
    }

    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

}
