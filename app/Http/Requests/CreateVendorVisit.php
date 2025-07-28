<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateVendorVisit extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'vendor_id' => ['required', 'exists:vendors,id'],
            'branch_id' => ['required', 'exists:branches,id'],
            'visit_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'visit_status' => ['nullable', 'string', Rule::in(['visited', 'closed', 'not_found', 'refused'])],
            'vendor_rating' => ['nullable', 'string', Rule::in(['very_interested', 'hesitant', 'refused', 'inappropriate'])],
            'audio_recording' => ['nullable', 'file',  'max:10240'],
            'video_recording' => ['nullable', 'file',  'max:20480'],
            'agent_notes' => ['nullable', 'string', 'max:1000'],
            'internal_notes' => ['nullable', 'string', 'max:1000'],
            'signature_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'gps_latitude' => ['nullable', 'numeric'],
            'gps_longitude' => ['nullable', 'numeric'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'visit_end_at' => ['nullable', 'date'],
            'met_person_name' => ['nullable', 'string', 'max:255'],
            'met_person_role' => ['nullable', 'string', 'max:100'], // Changed to support custom values
            'delivery_service_requested' => ['nullable', 'boolean'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
            'vendor_id.required' => 'The vendor is required.',
            'vendor_id.exists' => 'The selected vendor does not exist.',
            'branch_id.required' => 'The branch is required.',
            'branch_id.exists' => 'The selected branch does not exist.',
            'agent_id.required' => 'The agent is required.',
            'agent_id.exists' => 'The selected agent does not exist.',
            'visit_date.required' => 'The visit date is required.',
            'visit_date.date' => 'The visit date must be a valid date.',
            'audio_recording.mimes' => 'The audio must be an mp3 or wav file.',
            'video_recording.mimes' => 'The video must be an mp4, avi, or mov file.',
            'signature_image.mimes' => 'The signature image must be a JPG or PNG file.',
            'met_person_role.max' => 'The met person role must not exceed 100 characters.',
            'delivery_service_requested.boolean' => 'The delivery service requested field must be true or false.',
            // Add more as needed
        ];
    }
}
