<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'product_limit',
        'duration_in_days',
        'is_active',
    ];

    public function vendorVisits()
    {
        return $this->hasMany(VendorVisit::class);
    }
}
