<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Vendor;
use App\Models\Branch;
use App\Models\VendorVisit;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $stats = [
            'totalAgents' => Agent::count(),
            'totalVendors' => Vendor::count(),
            'totalBranches' => Branch::count(),
            'totalVisits' => VendorVisit::count(),
            'totalPackages' => Package::count(),
        ];

        // Get monthly visits data for chart
        $monthlyVisits = VendorVisit::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Get top performing agents
        $topAgents = Agent::withCount('vendorVisits')
            ->orderBy('vendor_visits_count', 'desc')
            ->limit(5)
            ->get();

        // Get recent activity
        $recentActivity = $this->getRecentActivity();

        return view('dashboard', compact('stats', 'monthlyVisits', 'topAgents', 'recentActivity'));
    }

    private function getRecentActivity()
    {
        $activities = collect();

        // Recent vendor registrations
        $recentVendors = Vendor::latest()->limit(3)->get();
        foreach ($recentVendors as $vendor) {
            $activities->push([
                'type' => 'vendor_registered',
                'title' => 'New vendor registered',
                'description' => $vendor->commercial_name . ' was added',
                'time' => $vendor->created_at->diffForHumans(),
                'icon' => 'fas fa-plus',
                'color' => 'green'
            ]);
        }

        // Recent visits
        $recentVisits = VendorVisit::with(['agent', 'branch'])->latest()->limit(3)->get();
        foreach ($recentVisits as $visit) {
            $activities->push([
                'type' => 'visit_completed',
                'title' => 'Branch visit completed',
                'description' => 'Agent ' . $visit->agent->name . ' completed visit to ' . $visit->branch->name,
                'time' => $visit->created_at->diffForHumans(),
                'icon' => 'fas fa-map-marker-alt',
                'color' => 'blue'
            ]);
        }

        // Recent agent registrations
        $recentAgents = Agent::latest()->limit(2)->get();
        foreach ($recentAgents as $agent) {
            $activities->push([
                'type' => 'agent_joined',
                'title' => 'New agent joined',
                'description' => $agent->name . ' joined as Agent #' . str_pad($agent->id, 3, '0', STR_PAD_LEFT),
                'time' => $agent->created_at->diffForHumans(),
                'icon' => 'fas fa-user-plus',
                'color' => 'yellow'
            ]);
        }

        return $activities->sortByDesc('time')->take(10);
    }

    public function getStats()
    {
        $stats = [
            'totalAgents' => Agent::count(),
            'totalVendors' => Vendor::count(),
            'totalBranches' => Branch::count(),
            'totalVisits' => VendorVisit::count(),
            'totalPackages' => Package::count(),
            'activeAgents' => Agent::whereHas('vendorVisits', function($query) {
                $query->where('created_at', '>=', now()->subDays(30));
            })->count(),
            'pendingVisits' => VendorVisit::where('status', 'pending')->count(),
            'completedVisits' => VendorVisit::where('status', 'completed')->count(),
        ];

        return response()->json($stats);
    }

    public function getChartData()
    {
        // Monthly visits data
        $monthlyVisits = VendorVisit::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Agent performance data
        $agentPerformance = Agent::withCount('vendorVisits')
            ->orderBy('vendor_visits_count', 'desc')
            ->limit(10)
            ->get();

        return response()->json([
            'monthlyVisits' => $monthlyVisits,
            'agentPerformance' => $agentPerformance
        ]);
    }
}
