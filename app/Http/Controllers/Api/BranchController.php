<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Http\Requests\CreateBranch;
use App\Http\Resources\BranchResource;
use Illuminate\Http\Request;
use App\ImageUploadTrait;

class BranchController extends Controller
{
    use ImageUploadTrait;
    public function index()
    {
        $branches = Branch::with(['vendor', 'agent'])
            ->withCount('vendorVisits')
            ->get();
        return BranchResource::collection($branches);
    }

    public function store(CreateBranch $request)
    {
        try {
            $data = $request->validated();
            $data['agent_id'] = auth('agent')->id();
            $branch = Branch::create($data);

            // Handle multiple branch photos
            if ($request->hasFile('branch_photos')) {
                foreach ($request->file('branch_photos') as $photo) {
                    $path = $this->saveImage($photo, 'branches');
                    $branch->photos()->create(['photo' => $path]);
                }
            }

            if (!$branch || !$branch->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Branch could not be created.',
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Branch created successfully!',
                'data' => new BranchResource($branch)
            ], 201);

        } catch (\Exception $e) {
            // \Log::error('Branch creation failed: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the branch.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Branch $branch)
    {
        $branch->load(['vendor', 'agent', 'vendorVisits']);
        return new BranchResource($branch);
    }

    public function update(CreateBranch $request, Branch $branch)
    {
        $data = $request->validated();
        $branch->update($data);
        return new BranchResource($branch);
    }

    public function destroy(Branch $branch)
    {
        $branch->delete();
        return response()->json(['success' => true, 'message' => 'Branch deleted successfully']);
    }
}
