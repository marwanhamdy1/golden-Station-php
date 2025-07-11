<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorVisit extends Model
{
    use HasFactory;

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
        'selected_package',
        'package_price',
        'visit_end_at',
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
}
