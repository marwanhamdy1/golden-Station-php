<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::withCount('vendorVisits')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('agents.index', compact('agents'));
    }

    public function create()
    {
        return view('agents.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'last_latitude' => $request->last_latitude,
            'last_longitude' => $request->last_longitude,
        ]);

        return redirect()->route('agents.index')
            ->with('success', 'Agent created successfully!');
    }

    public function show(Agent $agent, Request $request)
    {
        // Get current tab from request (default to 'overview')
        $activeTab = $request->get('tab', 'overview');

        // Load basic agent data with counts
        $agent->loadCount(['vendorVisits', 'branches']);

        // Initialize variables
        $vendorVisits = collect();
        $branches = collect();
        $statistics = [];

        // Calculate agent statistics
        $statistics = [
            'total_visits' => $agent->vendor_visits_count,
            'total_branches' => $agent->branches_count,
            'recent_visits' => $agent->vendorVisits()->where('created_at', '>=', now()->subDays(7))->count(),
            'this_month_visits' => $agent->vendorVisits()->whereMonth('created_at', now()->month)->count(),
        ];

        // Load data based on active tab with pagination
        switch ($activeTab) {
            case 'visits':
                $vendorVisits = $agent->vendorVisits()
                    ->with(['vendor', 'branch'])
                    ->orderBy('created_at', 'desc')
                    ->paginate(15, ['*'], 'visits_page');
                break;

            case 'branches':
                $branches = $agent->branches()
                    ->withCount('vendorVisits')
                    ->with('vendor')
                    ->orderBy('created_at', 'desc')
                    ->paginate(15, ['*'], 'branches_page');
                break;

            case 'overview':
            default:
                // For overview, get limited recent data
                $vendorVisits = $agent->vendorVisits()
                    ->with(['vendor', 'branch'])
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();

                $branches = $agent->branches()
                    ->withCount('vendorVisits')
                    ->with('vendor')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
                break;
        }

        return view('agents.show', compact('agent', 'vendorVisits', 'branches', 'statistics', 'activeTab'));
    }

    public function edit(Agent $agent)
    {
        return view('agents.edit', compact('agent'));
    }

    public function update(Request $request, Agent $agent)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'last_latitude' => $request->last_latitude,
            'last_longitude' => $request->last_longitude,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $agent->update($data);

        return redirect()->route('agents.show', $agent)
            ->with('success', 'Agent updated successfully!');
    }

    public function destroy(Agent $agent)
    {
        $agent->delete();

        return redirect()->route('agents.index')
            ->with('success', 'Agent deleted successfully!');
    }

    // API Methods
    public function apiIndex()
    {
        $agents = Agent::withCount('vendorVisits')->get();
        return response()->json(['success' => true, 'data' => $agents]);
    }

    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $agent = Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'last_latitude' => $request->last_latitude,
            'last_longitude' => $request->last_longitude,
        ]);

        return response()->json(['success' => true, 'data' => $agent], 201);
    }

    public function apiShow(Agent $agent)
    {
        $agent->load(['vendorVisits.vendor', 'vendorVisits.branch', 'branches.vendor']);
        return response()->json(['success' => true, 'data' => $agent]);
    }

    public function apiUpdate(Request $request, Agent $agent)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:agents,email,' . $agent->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'last_latitude' => $request->last_latitude,
            'last_longitude' => $request->last_longitude,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $agent->update($data);

        return response()->json(['success' => true, 'data' => $agent]);
    }

    public function apiDestroy(Agent $agent)
    {
        $agent->delete();
        return response()->json(['success' => true, 'message' => 'Agent deleted successfully']);
    }
}
