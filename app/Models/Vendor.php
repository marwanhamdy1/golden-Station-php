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
        'id_number',
        'other_attachments',
        'natural_photos',
        'license_photos',
        'license_number',
        'agent_id',
        'added_by',
        'added_by_role',
    ];

    public function branches()
    {
        return $this->hasMany(Branch::class);
    }

    public function vendorVisits()
    {
        return $this->hasMany(VendorVisit::class);
    }

    public function agent()
    {
        return $this->belongsTo(\App\Models\Agent::class);
    }

    /**
     * Get all images related to the vendor (as array of paths).
     */
    public function images()
    {
        $images = [];
        if ($this->shop_front_image) $images[] = $this->shop_front_image;
        if ($this->commercial_registration_image) $images[] = $this->commercial_registration_image;
        if ($this->id_image) $images[] = $this->id_image;
        if ($this->other_attachments) $images[] = $this->other_attachments;
        if ($this->natural_photos) {
            $arr = is_array($this->natural_photos) ? $this->natural_photos : json_decode($this->natural_photos, true);
            if (is_array($arr)) $images = array_merge($images, $arr);
        }
        if ($this->license_photos) {
            $arr = is_array($this->license_photos) ? $this->license_photos : json_decode($this->license_photos, true);
            if (is_array($arr)) $images = array_merge($images, $arr);
        }
        return $images;
    }
}
