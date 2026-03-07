<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use DivisionByZeroError;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'blood_group',
        'division_id',
        'district_id',
        'upazilla_id',
        'city_corporation_id',
        'city_area_id',
        'address_line',
        'role',
        'medical_history',
        'is_blocked',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function donorProfile()
    {
        return $this->hasOne(DonorProfile::class);
    }

    public function division()
    {
        return $this->belongsTo(Division::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function upazilla()
    {
        return $this->belongsTo(Upazilla::class);
    }

    public function cityCorporation()
    {
        return $this->belongsTo(CityCorporation::class);
    }

    public function cityArea()
    {
        return $this->belongsTo(CityArea::class);
    }
}
