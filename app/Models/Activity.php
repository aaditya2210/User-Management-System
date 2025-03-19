<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'activity', 'status'];

    public $timestamps = true; // Ensures created_at and updated_at are handled automatically

    // Relationship: Each activity belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
