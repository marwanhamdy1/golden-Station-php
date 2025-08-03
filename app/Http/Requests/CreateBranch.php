<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateBranch extends FormRequest
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
            'vendor_id' => ['required', 'exists:vendors,id'],
            'name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'location_url' => ['nullable', 'url', 'max:500'],
            'city' => ['required', 'string', 'max:100'],
            'district' => ['nullable', 'string', 'max:100'],
            'branch_photos' => ['nullable', 'array'],
            'branch_photos.*' => ['file', 'mimes:jpg,jpeg,png', 'max:5120'],
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
        'vendor_id.required' => 'المتجر مطلوب.',
        'vendor_id.exists' => 'المتجر المحدد غير موجود.',
        'name.required' => 'اسم الفرع مطلوب.',
        'mobile.required' => 'رقم الجوال مطلوب.',
        'email.email' => 'يرجى إدخال بريد إلكتروني صالح.',
        'city.required' => 'المدينة مطلوبة.',
        'branch_photos.*.mimes' => 'يجب أن تكون كل صورة للفرع من نوع JPG أو PNG.',
        // أضف المزيد إذا لزم الأمر
    ];
}
}