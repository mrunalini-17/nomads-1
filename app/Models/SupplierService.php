<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierService extends Model
{
    use HasFactory;

    protected $table = 'supplier_services'; // Explicitly defining the pivot table name

    protected $fillable = [
        'supplier_id',
        'service_id',
        'is_deleted',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function softDelete()
    {
        $this->is_deleted = true;
        $this->save();
    }
}
