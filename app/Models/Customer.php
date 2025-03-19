<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;


class Customer extends Model
{
    use HasFactory;


    protected static function boot()
    {
        parent::boot();

        static::created(function ($customer) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Added new customer: $customer->name",
                'status' => 'Completed'
            ]);
        });

        static::updated(function ($customer) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Updated customer: $customer->name",
                'status' => 'Completed'
            ]);
        });

        static::deleted(function ($customer) {
            Activity::create([
                'user_id' => Auth::id(),
                'activity' => "Deleted customer: $customer->name",
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
        'job_title',
        'gender',
        'date_of_birth',
        'nationality',
        'customer_type',
        'notes',
        'preferred_contact_method',
        'newsletter_subscription',
        'account_balance',
    ];
}
