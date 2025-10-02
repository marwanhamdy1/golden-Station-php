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

    public function index(Request $request)
    {
        $query = Vendor::withCount(['branches', 'vendorVisits']);

        // Search by commercial name
        if ($request->filled('search')) {
            $searchTerm = $request->get('search');
            $query->where('commercial_name', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by activity type
        if ($request->filled('activity_type')) {
            $query->where('activity_type', $request->get('activity_type'));
        }

        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->get('city'));
        }

        $vendors = $query->orderBy('created_at', 'desc')->paginate(10);

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
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $data['added_by'] = $user->name;
            $roles = $user->getRoleNames();
            $data['added_by_role'] = $roles && $roles->count() > 0 ? $roles->first() : 'user';
        }

        Vendor::create($data);

        return redirect()->route('vendors.index')
            ->with('success', 'Vendor created successfully!');
    }

    public function show(Vendor $vendor)
    {
        $vendor->load([
            'branches',
            'vendorVisits' => function($query) {
                $query->with('package')->latest()->limit(10);
            }
        ]);

        // Add subscription and visit flags for the view
        $vendor->has_active_subscription = $vendor->hasActiveSubscription();
        $vendor->latest_package = $vendor->getLatestPackage();
        $vendor->total_visits = $vendor->vendorVisits()->count();
        $vendor->recent_visits_count = $vendor->vendorVisits()->where('visit_date', '>=', now()->subDays(30))->count();

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
