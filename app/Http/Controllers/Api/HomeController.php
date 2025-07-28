<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\VendorVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Agent;

class HomeController extends Controller
{
    public function summary(Request $request)
    {
        $latestVendor = Vendor::orderBy('created_at', 'desc')->first();
        $latestBranches = Branch::orderBy('created_at', 'desc')->take(5)->get();
        $vendorCount = Vendor::count();
        $branchCount = Branch::count();
        $avgRating = VendorVisit::whereNotNull('vendor_rating')->avg('vendor_rating'); // If numeric, else handle below
        $visitsToday = VendorVisit::whereDate('created_at', Carbon::today())->count();

        /** @var Agent $agent */
        $agent = Auth::guard('agent')->user();
        $agentBranches = $agent ? Branch::where('agent_id', $agent->id)->count() : 0;
        $agentVisits = $agent ? VendorVisit::where('agent_id', $agent->id)->count() : 0;
        
        // Calculate monthly visits for the authenticated agent
        $visitsMonth = 0;
        if ($agent) {
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now();
            $visitsMonth = VendorVisit::where('agent_id', $agent->id)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count();
        }
        
        $agentDetails = $agent ? [
            'id' => $agent->id,
            'name' => $agent->name,
            'email' => $agent->email,
            // Add more agent details as needed
        ] : null;

        // If vendor_rating is not numeric, calculate average by mapping to numbers
        $ratingMap = [
            'very_interested' => 5,
            'hesitant' => 3,
            'refused' => 1,
            'inappropriate' => 0
        ];
        $ratings = VendorVisit::whereNotNull('vendor_rating')->pluck('vendor_rating');
        $numericRatings = $ratings->map(fn($r) => $ratingMap[$r] ?? null)->filter();
        $avgRating = $numericRatings->count() ? round($numericRatings->avg(), 2) : null;

        return response()->json([
            'latest_vendor' => $latestVendor,
            'latest_branches' => $latestBranches,
            'vendor_count' => $vendorCount,
            'branch_count' => $branchCount,
            'avg_vendor_rating' => $avgRating,
            'visits_today' => $visitsToday,
            'agent' => [
                'details' => $agentDetails,
                'branches_count' => $agentBranches,
                'visits_count' => $agentVisits,
                'visits_month' => $visitsMonth,
                'monthly_visits' => [
                    'count' => $visitsMonth,
                    'key' => 'Monthly Visits'
                ],
                'total_visits' => [
                    'count' => $agentVisits,
                    'key' => 'Total Visits'
                ]
            ],
        ]);
    }

    public function agentDetails(Request $request)
    {
        /** @var Agent $agent */
        $agent = Auth::guard('agent')->user();
        if (!$agent) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        $branches = $agent->branches()->with('vendor')->get();
        $visits = $agent->vendorVisits()->with('vendor', 'branch', 'package')->get();
        return response()->json([
            'success' => true,
            'agent' => $agent,
            'branches' => $branches,
            'visits' => $visits,
        ]);
    }
}
