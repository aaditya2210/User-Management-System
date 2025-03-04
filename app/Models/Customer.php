<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

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
