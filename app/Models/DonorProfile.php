<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonorProfile extends Model
{
    protected $fillable = ['user_id', 'last_donate_date'];

    protected $casts = [
        'is_available' => 'boolean',
        'last_donate_date' => 'date',
        'next_eligible_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
