<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorVisitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'vendor_id' => $this->vendor_id,
            'branch_id' => $this->branch_id,
            'agent_id' => $this->agent_id,
            'visit_date' => $this->visit_date,
            'notes' => $this->notes,
            'visit_status' => $this->visit_status,
            'vendor_rating' => $this->vendor_rating,
            'audio_recording' => $this->audio_recording,
            'video_recording' => $this->video_recording,
            'agent_notes' => $this->agent_notes,
            'internal_notes' => $this->internal_notes,
            'signature_image' => $this->signature_image,
            'gps_latitude' => $this->gps_latitude,
            'gps_longitude' => $this->gps_longitude,
            'package_id' => $this->package_id,
            'package' => $this->whenLoaded('package'),
            'visit_end_at' => $this->visit_end_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
