<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'fname',
        'lname',
        'countrycode',
        'mobile',
        'whatsapp',
        'email',
        'gender',
        'reference_id',
        'country_id',
        'state_id',
        'city_id',
        'locality',
        'pincode',
        'have_manager',
        'have_company',
        'updated_by',
        'added_by',
        'is_deleted',
    ];

    protected $casts = [
        'manager_id' => 'array', // Auto-converts JSON to an array
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function managers()
    {
        return $this->belongsToMany(Customer::class, 'customers_managers', 'customer_id', 'manager_id');
    }

    public function company()
    {
        return $this->hasOne(Company::class)->where('is_deleted', false);
    }
    // public function manager()
    // {
    //     return $this->hasOne(CustomerManager::class, 'customer_id')->where('is_deleted', false);
    // }
    public function country()
    {
        return $this->hasOne(Country::class,'id', 'country_id');
    }

    public function state()
    {
        return $this->hasOne(State::class,'id', 'state_id');
    }

    public function city()
    {
        return $this->hasOne(City::class,'id', 'city_id');
    }
    public function reference()
    {
        return $this->hasOne(Reference::class,'id', 'reference_id')->where('is_deleted', false);
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

    public function managedCustomers()
    {
        return $this->belongsToMany(Customer::class, 'customers_managers', 'manager_id', 'customer_id');
    }

}
