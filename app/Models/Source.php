<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $table = 'sources';

    protected $fillable = ['title', 'description','added_by','updated_by','is_deleted'];

    public function enquiries()
    {
        return $this->hasMany(Enquiry::class);
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
