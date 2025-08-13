<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateVendor;
use App\Http\Resources\VendorResource;
use Illuminate\Support\Facades\Auth;
use App\ImageUploadTrait;

class VendorController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $vendors = Vendor::withCount(['branches', 'vendorVisits'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get unique cities for the filter dropdown
        $cities = Vendor::whereNotNull('city')
            ->where('city', '!=', '')
            ->where('city', '!=', 'null')
            ->distinct()
            ->pluck('city')
            ->sort()
            ->values();

        return view('vendors.index', compact('vendors', 'cities'));
    }

    public function create()
    {
        return view('vendors.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'commercial_name' => 'required|string|max:255',
            'commercial_registration_number' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'snapchat' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'activity_type' => 'nullable|in:wholesale,retail,both',
            'activity_start_date' => 'nullable|date',
            'has_commercial_registration' => 'nullable|in:yes,no,not_sure',
            'has_online_platform' => 'nullable|boolean',
            'previous_platform_experience' => 'nullable|string',
            'previous_platform_issues' => 'nullable|string',
            'has_product_photos' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();

        // صور مفردة
        foreach ([
            'shop_front_image',
            'commercial_registration_image',
            'id_image',
            'other_attachments'
        ] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->saveImage($request->file($field), 'vendors');
            }
        }

        // صور متعددة (natural_photos, license_photos)
        foreach (['natural_photos', 'license_photos'] as $multiField) {
            if ($request->hasFile($multiField)) {
                $paths = [];
                foreach ($request->file($multiField) as $file) {
                    $paths[] = $this->saveImage($file, 'vendors');
                }
                $data[$multiField] = json_encode($paths);
            }
        }

        if (Auth::check()) {
            $data['added_by'] = Auth::user()->name;
            if (is_callable([Auth::user(), 'getRoleNames'])) {
                $roles = Auth::user()->getRoleNames();
                $data['added_by_role'] = $roles && $roles->count() > 0 ? $roles->first() : 'user';
            } else {
                $data['added_by_role'] = property_exists(Auth::user(), 'role') ? Auth::user()->role : 'user';
            }
        }

        Vendor::create($data);

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor created successfully!');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load(['branches', 'vendorVisits' => function($query) {
            $query->latest()->limit(10);
        }]);

        return view('vendors.show', compact('vendor'));
    }

    public function edit(Vendor $vendor)
    {
        return view('vendors.edit', compact('vendor'));
    }

    public function update(Request $request, Vendor $vendor)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'commercial_name' => 'required|string|max:255',
            'commercial_registration_number' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'snapchat' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'activity_type' => 'nullable|in:wholesale,retail,both',
            'activity_start_date' => 'nullable|date',
            'has_commercial_registration' => 'nullable|in:yes,no,not_sure',
            'has_online_platform' => 'nullable|boolean',
            'previous_platform_experience' => 'nullable|string',
            'previous_platform_issues' => 'nullable|string',
            'has_product_photos' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $vendor->update($request->all());

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor updated successfully!');
    }

    public function destroy(Vendor $vendor)
    {
        $vendor->delete();

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor deleted successfully!');
    }

    // API Methods
    public function apiIndex()
    {
        $vendors = Vendor::withCount(['branches', 'vendorVisits'])->get();
        return response()->json(['success' => true, 'data' => $vendors]);
    }

    public function apiStore(CreateVendor $request)
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

        $vendor = Vendor::create($data);
        return new VendorResource($vendor);
    }

    public function apiShow(Vendor $vendor)
    {
        $vendor->load(['branches', 'vendorVisits']);
        return response()->json(['success' => true, 'data' => $vendor]);
    }

    public function apiUpdate(Request $request, Vendor $vendor)
    {
        $validator = Validator::make($request->all(), [
            'owner_name' => 'required|string|max:255',
            'commercial_name' => 'required|string|max:255',
            'commercial_registration_number' => 'nullable|string|max:255',
            'mobile' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'snapchat' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'activity_type' => 'nullable|in:wholesale,retail,both',
            'activity_start_date' => 'nullable|date',
            'has_commercial_registration' => 'nullable|in:yes,no,not_sure',
            'has_online_platform' => 'nullable|boolean',
            'previous_platform_experience' => 'nullable|string',
            'previous_platform_issues' => 'nullable|string',
            'has_product_photos' => 'nullable|boolean',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $vendor->update($request->all());

        return response()->json(['success' => true, 'data' => $vendor]);
    }

    public function apiDestroy(Vendor $vendor)
    {
        $vendor->delete();
        return response()->json(['success' => true, 'message' => 'Vendor deleted successfully']);
    }
}
