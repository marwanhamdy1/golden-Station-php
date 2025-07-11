<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Branch;
use App\Models\VendorVisit;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_name',
        'commercial_name',
        'commercial_registration_number',
        'mobile',
        'whatsapp',
        'snapchat',
        'instagram',
        'email',
        'location_url',
        'city',
        'district',
        'activity_type',
        'activity_start_date',
        'has_commercial_registration',
        'has_online_platform',
        'previous_platform_experience',
        'previous_platform_issues',
        'has_product_photos',
        'notes',
        'shop_front_image',
        'commercial_registration_image',
        'id_image',
        'other_attachments',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function vendorVisits()
    {
        return $this->hasMany(VendorVisit::class);
    }
}
