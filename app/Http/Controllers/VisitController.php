<?php

namespace App\Http\Controllers;

use App\Models\VendorVisit;
use App\Models\Vendor;
use App\Models\Agent;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $visits = VendorVisit::with(['vendor', 'agent', 'package', 'branch'])
        ->orderBy('created_at', 'desc')
        ->paginate(15);

    // Statistics for the dashboard cards
    $totalVisits = VendorVisit::count();
    $successfulVisits = VendorVisit::where('visit_status', 'visited')->count();
    $activeAgents = VendorVisit::distinct('agent_id')->count('agent_id');
    $visitsWithPackages = VendorVisit::whereNotNull('package_id')->count();

    // Get all agents for the filter dropdown
    $allAgents = Agent::orderBy('name')->get();

    // Calculate visit counts for each agent-vendor combination
    $visitCountsArr = [];
    $agentVendorVisits = VendorVisit::select('agent_id', 'vendor_id')
        ->get()
        ->groupBy('agent_id');

    foreach ($agentVendorVisits as $agentId => $agentVisits) {
        $visitCountsArr[$agentId] = [];
        $vendorGroups = $agentVisits->groupBy('vendor_id');
        foreach ($vendorGroups as $vendorId => $vendorVisits) {
            $visitCountsArr[$agentId][$vendorId] = $vendorVisits->count();
        }
    }

    // Calculate total visit counts per vendor
    $vendorVisitCounts = VendorVisit::select('vendor_id')
        ->get()
        ->groupBy('vendor_id')
        ->map(function ($visits) {
            return $visits->count();
        });

    // Calculate total visit counts per agent
    $agentVisitCounts = VendorVisit::select('agent_id')
        ->get()
        ->groupBy('agent_id')
        ->map(function ($visits) {
            return $visits->count();
        });

    return view('visits.index', compact(
        'visits',
        'totalVisits',
        'successfulVisits',
        'activeAgents',
        'visitsWithPackages',
        'allAgents',
        'visitCountsArr',
        'vendorVisitCounts',
        'agentVisitCounts'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $vendors = Vendor::orderBy('owner_name')->get();
        $agents = Agent::orderBy('name')->get();
        $packages = Package::where('is_active', true)->orderBy('name')->get();

        return view('visits.create', compact('vendors', 'agents', 'packages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'branch_id' => 'required|exists:branches,id',
            'agent_id' => 'required|exists:agents,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'visit_status' => 'nullable|in:visited,closed,not_found,refused',
            'vendor_rating' => 'nullable|in:very_interested,hesitant,refused,inappropriate',
            'agent_notes' => 'nullable|string|max:1000',
            'internal_notes' => 'nullable|string|max:1000',
            'gps_latitude' => 'nullable|numeric',
            'gps_longitude' => 'nullable|numeric',
            'package_id' => 'nullable|exists:packages,id',
            'visit_end_at' => 'nullable|date|after:visit_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $visitData = [
                'vendor_id' => $request->vendor_id,
                'branch_id' => $request->branch_id,
                'agent_id' => $request->agent_id,
                'visit_date' => $request->visit_date ?: now(),
                'notes' => $request->notes,
                'visit_status' => $request->visit_status ?? 'visited',
                'vendor_rating' => $request->vendor_rating,
                'agent_notes' => $request->agent_notes,
                'internal_notes' => $request->internal_notes,
                'gps_latitude' => $request->gps_latitude,
                'gps_longitude' => $request->gps_longitude,
                'package_id' => $request->package_id,
                'visit_end_at' => $request->visit_end_at,
            ];
            
            // Generate Google Maps URL if GPS coordinates are provided
            if ($request->gps_latitude && $request->gps_longitude) {
                $visitData['google_maps_url'] = "https://www.google.com/maps?q={$request->gps_latitude},{$request->gps_longitude}";
            }
            
            // If no visit_date provided, use current timestamp
            if (!$request->visit_date) {
                $visitData['visit_date'] = now();
            }
            
            $visit = VendorVisit::create($visitData);

            return redirect()->route('visits.index')
                ->with('success', 'Visit created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating visit: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
   public function show(VendorVisit $visit)
{
    $visit->load(['vendor', 'agent', 'package', 'branch']);

    // حساب عدد مرات زيارة هذا المندوب لنفس التاجر
    $agentVendorVisitsCount = VendorVisit::where('agent_id', $visit->agent_id)
        ->where('vendor_id', $visit->vendor_id)
        ->count();

    // جلب جميع الزيارات لهذا التاجر مع ترتيبها بالتاريخ
    $allVendorVisits = VendorVisit::with(['agent', 'package', 'branch'])
        ->where('vendor_id', $visit->vendor_id)
        ->orderBy('visit_date', 'desc')
        ->get();

    return view('visits.show', compact('visit', 'agentVendorVisitsCount', 'allVendorVisits'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(VendorVisit $visit)
    {
        $vendors = Vendor::orderBy('owner_name')->get();
        $agents = Agent::orderBy('name')->get();
        $packages = Package::where('is_active', true)->orderBy('name')->get();

        return view('visits.edit', compact('visit', 'vendors', 'agents', 'packages'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, VendorVisit $visit)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'branch_id' => 'required|exists:branches,id',
            'agent_id' => 'required|exists:agents,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
            'visit_status' => 'nullable|in:visited,closed,not_found,refused',
            'vendor_rating' => 'nullable|in:very_interested,hesitant,refused,inappropriate',
            'agent_notes' => 'nullable|string|max:1000',
            'internal_notes' => 'nullable|string|max:1000',
            'gps_latitude' => 'nullable|numeric',
            'gps_longitude' => 'nullable|numeric',
            'package_id' => 'nullable|exists:packages,id',
            'visit_end_at' => 'nullable|date|after:visit_date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $visit->update([
                'vendor_id' => $request->vendor_id,
                'branch_id' => $request->branch_id,
                'agent_id' => $request->agent_id,
                'visit_date' => $request->visit_date,
                'notes' => $request->notes,
                'visit_status' => $request->visit_status ?? 'visited',
                'vendor_rating' => $request->vendor_rating,
                'agent_notes' => $request->agent_notes,
                'internal_notes' => $request->internal_notes,
                'gps_latitude' => $request->gps_latitude,
                'gps_longitude' => $request->gps_longitude,
                'package_id' => $request->package_id,
                'visit_end_at' => $request->visit_end_at,
            ]);

            return redirect()->route('visits.index')
                ->with('success', 'Visit updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating visit: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VendorVisit $visit)
    {
        try {
            $visit->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Export visits to CSV
     */
    public function export()
    {
        $visits = VendorVisit::with(['vendor', 'agent', 'package', 'branch'])->get();

        $filename = 'visits_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($visits) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, [
                'Visit ID', 'Visit Date', 'Vendor Name', 'Vendor Company', 'Agent Name',
                'Branch', 'Status', 'Rating', 'Package', 'Package Price', 'Notes', 'Created At'
            ]);

            // Add data
            foreach ($visits as $visit) {
                fputcsv($file, [
                    $visit->id,
                    $visit->visit_date->format('Y-m-d H:i:s'),
                    $visit->vendor->owner_name ?? 'N/A',
                    $visit->vendor->commercial_name ?? 'N/A',
                    $visit->agent->name ?? 'N/A',
                    $visit->branch->name ?? 'N/A',
                    ucfirst(str_replace('_', ' ', $visit->visit_status)),
                    $visit->vendor_rating ? ucfirst(str_replace('_', ' ', $visit->vendor_rating)) : 'N/A',
                    $visit->package->name ?? 'N/A',
                    $visit->package->price ?? 'N/A',
                    $visit->notes ?? 'N/A',
                    $visit->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}