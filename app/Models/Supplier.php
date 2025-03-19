<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Supplier extends Model
{
    use HasFactory;


    protected static function boot()
    {
        parent::boot();

        static::created(function ($supplier) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Added new supplier: $supplier->name",
                'status' => 'Completed'
            ]);
        });

        static::updated(function ($supplier) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Updated supplier: $supplier->name",
                'status' => 'Completed'
            ]);
        });

        static::deleted(function ($supplier) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Deleted supplier: $supplier->name",
                'status' => 'Completed'
            ]);
        });
    }




    protected $fillable = [
        'name', 
        'email', 
        'contact_number', 
        'address', 
        'company_name', 
        'gst_number', 
        'website', 
        'state_id',
        'city_id',
        'postal_code', 
        'contact_person', 
        'status', 
        'contract_start_date', 
        'contract_end_date'
    ];
    // protected $casts = [
    //     'state_id' => 'integer', // Ensure it's an integer
    //     'city_id' => 'integer',
    //     'contract_start_date' => 'date',
    //     'contract_end_date' => 'date',
    // ];


    // Relationship with State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // Relationship with City
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
