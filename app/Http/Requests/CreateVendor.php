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
            'mobile' => ['required', 'string', 'max:20', 'unique:vendors,mobile'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'snapchat' => ['nullable', 'string', 'max:100'],
            'instagram' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:vendors,email'],
            'location_url' => ['nullable', 'url', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'activity_type' => ['required', 'string', Rule::in(['wholesale', 'retail', 'both'])],
            'activity_start_date' => ['nullable', 'date'],
            'has_commercial_registration' => ['required', 'string', Rule::in(['yes', 'no', 'not_sure'])],
            'has_online_platform' => ['required', 'boolean'],
            'previous_platform_experience' => ['nullable', 'string', 'max:500'],
            'previous_platform_issues' => ['nullable', 'string', 'max:500'],
            'has_product_photos' => ['required', 'boolean'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'shop_front_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'commercial_registration_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'id_image' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'other_attachments' => ['nullable', 'array'],
            'other_attachments.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'natural_photos' => ['nullable', 'array'],
            'natural_photos.*' => ['file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'license_photos' => ['nullable', 'array'],
            'license_photos.*' => ['file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'license_number' => ['nullable', 'string', 'max:255'],
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
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'city.required' => 'The city is required.',
            'activity_type.required' => 'The activity type is required.',
            'has_commercial_registration.required' => 'Please specify if there is a commercial registration.',
            'has_online_platform.required' => 'Please specify if there is an online platform.',
            'has_product_photos.required' => 'Please specify if product photos are available.',
            'shop_photo.mimes' => 'The shop photo must be a JPG or PNG file.',
            'commercial_registration_image.mimes' => 'The commercial registration image must be a JPG or PNG file.',
            'id_image.mimes' => 'The ID image must be a JPG or PNG file.',
            'other_attachments.*.mimes' => 'Each attachment must be a JPG, PNG, or PDF file.',
            'natural_photos.*.mimes' => 'Each natural photo must be a JPG or PNG file.',
            'license_photos.*.mimes' => 'Each license photo must be a JPG or PNG file.',
            // Add more custom messages as needed
        ];
    }
}