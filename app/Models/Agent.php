<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Branch;
use App\Models\VendorVisit;

class Agent extends Model implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'last_latitude',
        'last_longitude'
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function vendorVisits()
    {
        return $this->hasMany(VendorVisit::class);
    }
}
