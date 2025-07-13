<?php

namespace App\Http\Controllers;

use App\Models\VendorVisit;
use App\Models\Vendor;
use App\Models\Agent;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     */
    public function index()
    {
        // Get basic statistics
        $stats = [
            'totalVisits' => VendorVisit::count(),
            'totalVendors' => Vendor::count(),
            'totalAgents' => Agent::count(),
            'totalPackages' => Package::count(),
        ];

        // Get visit statistics by status
        $visitStats = VendorVisit::select('visit_status', DB::raw('count(*) as count'))
            ->groupBy('visit_status')
            ->get();

        // Get top performing agents
        $topAgents = Agent::withCount('vendorVisits')
            ->orderBy('vendor_visits_count', 'desc')
            ->limit(5)
            ->get();

        // Get vendor ratings
        $vendorRatings = VendorVisit::select('vendor_rating', DB::raw('count(*) as count'))
            ->whereNotNull('vendor_rating')
            ->groupBy('vendor_rating')
            ->get();

        // Get monthly visits for the current year
        $monthlyVisits = VendorVisit::select(
                DB::raw('MONTH(visit_date) as month'),
                DB::raw('count(*) as count')
            )
            ->whereYear('visit_date', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        for ($i = 1; $i <= 12; $i++) {
            if (!isset($monthlyVisits[$i])) {
                $monthlyVisits[$i] = 0;
            }
        }
        ksort($monthlyVisits);

        return view('reports.index', compact(
            'stats',
            'visitStats',
            'topAgents',
            'vendorRatings',
            'monthlyVisits'
        ));
    }
}
