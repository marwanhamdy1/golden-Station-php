<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Vendor;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\CreateBranch;
use App\Http\Resources\BranchResource;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['vendor', 'agent'])
            ->withCount('vendorVisits')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('branches.index', compact('branches'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        $agents = Agent::all();
        return view('branches.create', compact('vendors', 'agents'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            // 'agent_id' => 'nullable|exists:agents,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        // من أضاف الفرع
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();
            $data['added_by'] = $user->name;
            $roles = $user->getRoleNames();
            $data['added_by_role'] = $roles && $roles->count() > 0 ? $roles->first() : 'user';
        }
        Branch::create($data);

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully!');
    }

    public function show(Branch $branch)
    {
        $branch->load([
            'vendor' => function($query) {
                $query->with(['vendorVisits.package' => function($q) {
                    $q->where('is_active', true);
                }]);
            },
            'agent',
            'vendorVisits' => function($query) {
                $query->latest()->limit(10);
            }
        ]);

        // Add vendor subscription data for the view
        if ($branch->vendor) {
            $branch->vendor->has_active_subscription = $branch->vendor->hasActiveSubscription();
            $branch->vendor->latest_package = $branch->vendor->getLatestPackage();
            $branch->vendor->total_visits = $branch->vendor->vendorVisits()->count();
            $branch->vendor->recent_visits_count = $branch->vendor->vendorVisits()->where('visit_date', '>=', now()->subDays(30))->count();
        }

        return view('branches.show', compact('branch'));
    }

    public function edit(Branch $branch)
    {
        $vendors = Vendor::all();
        $agents = Agent::all();
        return view('branches.edit', compact('branch', 'vendors', 'agents'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'agent_id' => 'nullable|exists:agents,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $branch->update($request->all());

        return redirect()->route('branches.index')
            ->with('success', 'Branch updated successfully!');
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully!');
    }

    // API Methods
    public function apiIndex()
    {
        $branches = Branch::with(['vendor', 'agent'])
            ->withCount('vendorVisits')
            ->get();
        return response()->json(['success' => true, 'data' => $branches]);
    }

    public function apiStore(CreateBranch $request)
    {
        $data = $request->validated();
        $branch = Branch::create($data);
        return new BranchResource($branch);
    }

    public function apiShow(Branch $branch)
    {
        $branch->load(['vendor', 'agent', 'vendorVisits']);
        return response()->json(['success' => true, 'data' => $branch]);
    }

    public function apiUpdate(Request $request, Branch $branch)
    {
        $validator = Validator::make($request->all(), [
            'vendor_id' => 'required|exists:vendors,id',
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'location_url' => 'nullable|url',
            'city' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'agent_id' => 'nullable|exists:agents,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        $branch->update($request->all());

        return response()->json(['success' => true, 'data' => $branch]);
    }

    public function apiDestroy(Branch $branch)
    {
        $branch->delete();
        return response()->json(['success' => true, 'message' => 'Branch deleted successfully']);
    }
}
