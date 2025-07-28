<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Http\Requests\CreateVendor;
use App\Http\Resources\VendorResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\ImageUploadTrait;

class VendorController extends Controller
{
    use ImageUploadTrait;
    public function index(Request $request)
    {
        $query = Vendor::query();

        // Get all searchable fields from the Vendor model
        $searchableFields = [
            'owner_name', 'commercial_name', 'commercial_registration_number',
            'mobile', 'whatsapp', 'snapchat', 'instagram', 'email',
            'location_url', 'city', 'district', 'activity_type',
            'has_commercial_registration', 'has_online_platform',
            'has_product_photos', 'notes', 'id_number', 'license_number'
        ];

        // Handle dynamic field-specific searches
        foreach ($searchableFields as $field) {
            if ($request->has($field) && !empty($request->input($field))) {
                $value = $request->input($field);
                $query->where($field, 'like', "%{$value}%");
            }
        }

        // Handle general search across multiple fields
        if ($request->has('search') && !empty($request->input('search'))) {
            $search = $request->input('search');
            $query->where(function($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        // Handle pagination
        $perPage = $request->input('per_page', 15);
        $vendors = $query->paginate($perPage);

        return VendorResource::collection($vendors);
    }

public function store(CreateVendor $request)
    {
        try {
            $data = $request->validated();
            $data['agent_id'] = auth('agent')->id();
            if (!empty($request->shop_front_image)) {
                $data['shop_front_image'] = $this->saveImage($request->shop_front_image, 'vendors');
            }
            if (!empty($request->commercial_registration_image)) {
                $data['commercial_registration_image'] = $this->saveImage($request->commercial_registration_image, 'vendors');
            }
            if (!empty($request->id_image)) {
                $data['id_image'] = $this->saveImage($request->id_image, 'vendors');
            }
            if (!empty($request->license_photos)) {
                $data['license_photos'] = $this->saveImage($request->license_photos, 'vendors');
            }
            if ($request->hasFile('other_attachments')) {
                $attachments = [];
                foreach ($request->file('other_attachments') as $file) {
                    $attachments[] = $this->saveImage($file, 'vendors/attachments');
                }
                $data['other_attachments'] = json_encode($attachments);
            }

            $vendor = Vendor::create($data);

            // Check if vendor was created
            if (!$vendor || !$vendor->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vendor could not be created.',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Vendor created successfully!',
                'data' => new VendorResource($vendor)
            ], 201);

        } catch (\Exception $e) {
            Log::error('Vendor creation failed: ' . $e->getMessage(), ['exception' => $e]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the vendor.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Vendor $vendor)
    {
        return new VendorResource($vendor);
    }

    public function update(CreateVendor $request, Vendor $vendor)
    {
        $data = $request->validated();
        // Handle single file uploads
        foreach ([
            'shop_front_image',
            'commercial_registration_image',
            'id_image'
        ] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('vendors', 'public');
            }
        }
        // Handle multiple file uploads for other_attachments
        if ($request->hasFile('other_attachments')) {
            $attachments = [];
            foreach ($request->file('other_attachments') as $file) {
                $attachments[] = $file->store('vendors/attachments', 'public');
            }
            $data['other_attachments'] = $attachments;
        }
        $vendor->update($data);
        return new VendorResource($vendor);
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }
}
