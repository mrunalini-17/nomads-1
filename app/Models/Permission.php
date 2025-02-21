<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'add',
        'view',
        'edit',
        'update',
        'delete',
    ];


    public function employee()
    {
        return $this->belongsTo(UserEmployee::class, 'employee_id');
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
