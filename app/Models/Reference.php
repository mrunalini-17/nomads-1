<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'references';

    protected $primaryKey = 'id';

    // Specify the fillable fields
    protected $fillable = ['name', 'mobile','whatsapp','gstin','email','description','added_by','updated_by','is_deleted'];

    public function customers()
    {
        return $this->hasMany(Customer::class,'reference_id','id');
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
