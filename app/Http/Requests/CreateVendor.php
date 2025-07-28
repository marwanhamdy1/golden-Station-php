<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CreateVendor extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'owner_name' => ['required', 'string', 'max:255'],
            'commercial_name' => ['required', 'string', 'max:255'],
            'commercial_registration_number' => ['nullable', 'string', 'max:100'],
            'mobile' => ['required', 'string', 'max:25', 'unique:vendors,mobile'], // Increased for international numbers
            'whatsapp' => ['nullable', 'string', 'max:25'], // Increased for international numbers
            'snapchat' => ['nullable', 'string', 'max:100'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vendors,email'],
            'location_url' => ['nullable', 'url', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'street_name' => ['nullable', 'string', 'max:255'],
            'activity_type' => ['nullable', 'string', 'max:100'], // Changed to allow custom values
            'activity_start_date' => ['nullable', 'date'],
            'has_commercial_registration' => ['nullable', 'string', 'max:50'], // Changed to allow custom values
            'has_online_platform' => ['nullable', 'boolean'],
            'previous_platform_experience' => ['nullable', 'string', 'max:1000'], // Increased length
            'previous_platform_issues' => ['nullable', 'string', 'max:1000'], // Increased length
            'has_product_photos' => ['nullable', 'boolean'],
            'notes' => ['nullable', 'string', 'max:2000'], // Increased length
            'shop_front_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'commercial_registration_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'id_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'other_attachments' => ['nullable', 'array'],
            'other_attachments.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'license_photos' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'id_number' => ['nullable', 'string', 'max:100', 'unique:vendors,id_number'],
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
            'owner_name.required' => 'The owner name is required.',
            'commercial_name.required' => 'The commercial name is required.',
            'mobile.required' => 'The mobile number is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'mobile.max' => 'Mobile number must not exceed 25 characters.',
            'whatsapp.max' => 'WhatsApp number must not exceed 25 characters.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'city.required' => 'The city is required.',
            'street_name.max' => 'Street name must not exceed 255 characters.',
            'activity_type.max' => 'Activity type must not exceed 100 characters.',
            'has_commercial_registration.max' => 'Commercial registration status must not exceed 50 characters.',
            'previous_platform_experience.max' => 'Previous platform experience must not exceed 1000 characters.',
            'previous_platform_issues.max' => 'Previous platform issues must not exceed 1000 characters.',
            'notes.max' => 'Notes must not exceed 2000 characters.',
            'shop_front_image.mimes' => 'The shop photo must be a JPG or PNG file.',
            'commercial_registration_image.mimes' => 'The commercial registration image must be a JPG or PNG file.',
            'id_image.mimes' => 'The ID image must be a JPG or PNG file.',
            'other_attachments.*.mimes' => 'Each attachment must be a JPG, PNG, or PDF file.',
            'license_photos.mimes' => 'The license photo must be a JPG or PNG file.',
            'id_number.unique' => 'This ID number is already registered.',
        ];
    }
}