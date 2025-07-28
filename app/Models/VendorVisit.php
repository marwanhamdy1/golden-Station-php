<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVisit extends Model
{
    use HasFactory;

    protected $casts = [
        'visit_date' => 'datetime',
        'visit_end_at' => 'datetime',
    ];

    protected $fillable = [
        'vendor_id',
        'branch_id',
        'agent_id',
        'visit_date',
        'notes',
        'visit_status',
        'vendor_rating',
        'audio_recording',
        'video_recording',
        'agent_notes',
        'internal_notes',
        'signature_image',
        'gps_latitude',
        'gps_longitude',
        'package_id',
        'visit_end_at',
        'met_person_name',
        'met_person_role',
        'custom_role',
        'delivery_service_requested',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
