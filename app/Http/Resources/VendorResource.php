<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
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
            'owner_name' => $this->owner_name,
            'commercial_name' => $this->commercial_name,
            'commercial_registration_number' => $this->commercial_registration_number,
            'mobile' => $this->mobile,
            'whatsapp' => $this->whatsapp,
            'snapchat' => $this->snapchat,
            'instagram' => $this->instagram,
            'email' => $this->email,
            'location_url' => $this->location_url,
            'city' => $this->city,
            'district' => $this->district,
            'activity_type' => $this->activity_type,
            'activity_start_date' => $this->activity_start_date,
            'has_commercial_registration' => $this->has_commercial_registration,
            'has_online_platform' => $this->has_online_platform,
            'previous_platform_experience' => $this->previous_platform_experience,
            'previous_platform_issues' => $this->previous_platform_issues,
            'has_product_photos' => $this->has_product_photos,
            'notes' => $this->notes,
            'shop_front_image' => $this->shop_front_image,
            'commercial_registration_image' => $this->commercial_registration_image,
            'id_image' => $this->id_image,
            'other_attachments' => $this->other_attachments,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
} 