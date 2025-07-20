<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\VendorVisit;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'name',
        'mobile',
        'email',
        'address',
        'location_url',
        'city',
        'district',
        'agent_id',
        'added_by',
        'added_by_role',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function vendorVisits()
    {
        return $this->hasMany(VendorVisit::class);
    }

    public function photos()
    {
        return $this->hasMany(\App\Models\BranchPhoto::class);
    }
}
