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
                'message' => 'راجع الحقول ',
                'errors' => $validator->errors()
            ], 422)
        );
    }

    public function messages(): array
    {
        return [
    'owner_name.required' => 'اسم المالك مطلوب.',
    'commercial_name.required' => 'الاسم التجاري مطلوب.',
    'mobile.required' => 'رقم الجوال مطلوب.',
    'mobile.unique' => 'رقم الجوال مسجل مسبقاً.',
    'mobile.max' => 'يجب ألا يتجاوز رقم الجوال 25 حرفاً.',
    'whatsapp.max' => 'يجب ألا يتجاوز رقم الواتساب 25 حرفاً.',
    'email.required' => 'البريد الإلكتروني مطلوب.',
    'email.email' => 'يرجى إدخال بريد إلكتروني صحيح.',
    'email.unique' => 'البريد الإلكتروني مسجل مسبقاً.',
    'city.required' => 'المدينة مطلوبة.',
    'street_name.max' => 'يجب ألا يتجاوز اسم الشارع 255 حرفاً.',
    'activity_type.max' => 'يجب ألا يتجاوز نوع النشاط 100 حرف.',
    'has_commercial_registration.max' => 'يجب ألا يتجاوز حالة السجل التجاري 50 حرفاً.',
    'previous_platform_experience.max' => 'يجب ألا يتجاوز وصف تجربة المنصات السابقة 1000 حرف.',
    'previous_platform_issues.max' => 'يجب ألا يتجاوز وصف مشاكل المنصات السابقة 1000 حرف.',
    'notes.max' => 'يجب ألا تتجاوز الملاحظات 2000 حرف.',
    'shop_front_image.mimes' => 'يجب أن تكون صورة المحل من نوع JPG أو PNG.',
    'commercial_registration_image.mimes' => 'يجب أن تكون صورة السجل التجاري من نوع JPG أو PNG.',
    'id_image.mimes' => 'يجب أن تكون صورة الهوية من نوع JPG أو PNG.',
    'other_attachments.*.mimes' => 'يجب أن يكون كل مرفق من نوع JPG أو PNG أو PDF.',
    'license_photos.mimes' => 'يجب أن تكون صورة الرخصة من نوع JPG أو PNG.',
    'id_number.unique' => 'رقم الهوية مسجل مسبقاً.',
];
    }
}