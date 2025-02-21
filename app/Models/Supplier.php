<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'suppliers';

    protected $fillable = ['name','gstin', 'contact','email','contact_person','is_deleted','added_by','updated_by'];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'supplier_services')
                    ->withPivot('is_deleted')
                    ->withTimestamps();
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
