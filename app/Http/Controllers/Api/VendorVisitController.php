<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VendorVisit;
use App\Http\Requests\CreateVendorVisit;
use App\Http\Resources\VendorVisitResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VendorVisitController extends Controller
{
    public function index()
    {
        $visits = VendorVisit::all();
        return VendorVisitResource::collection($visits);
    }

    public function store(CreateVendorVisit $request)
    {
        try {
            $data = $request->validated();
            // Handle file uploads
            foreach ([
                'audio_recording',
                'video_recording',
                'signature_image'
            ] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('vendor_visits', 'public');
                }
            }
            $visit = VendorVisit::create($data);
            if (!$visit || !$visit->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vendor visit could not be created.',
                ], 500);
            }
            return response()->json([
                'success' => true,
                'message' => 'Vendor visit created successfully!',
                'data' => new VendorVisitResource($visit)
            ], 201);
        } catch (\Exception $e) {
            Log::error('Vendor visit creation failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the vendor visit.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(VendorVisit $vendorVisit)
    {
        return new VendorVisitResource($vendorVisit);
    }

    public function update(CreateVendorVisit $request, VendorVisit $vendorVisit)
    {
        try {
            $data = $request->validated();
            foreach ([
                'audio_recording',
                'video_recording',
                'signature_image'
            ] as $field) {
                if ($request->hasFile($field)) {
                    $data[$field] = $request->file($field)->store('vendor_visits', 'public');
                }
            }
            $vendorVisit->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Vendor visit updated successfully!',
                'data' => new VendorVisitResource($vendorVisit)
            ]);
        } catch (\Exception $e) {
            Log::error('Vendor visit update failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the vendor visit.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(VendorVisit $vendorVisit)
    {
        $vendorVisit->delete();
        return response()->json(['success' => true, 'message' => 'Vendor visit deleted successfully']);
    }
}
