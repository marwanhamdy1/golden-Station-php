<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::orderBy('created_at', 'desc')->paginate(12);
        return view('packages.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('packages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:packages',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'product_limit' => 'nullable|integer|min:1',
            'duration_in_days' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $package = Package::create([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'product_limit' => $request->product_limit,
                'duration_in_days' => $request->duration_in_days,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('packages.index')
                ->with('success', 'Package created successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error creating package: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        return view('packages.show', compact('package'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        return view('packages.edit', compact('package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:packages,name,' . $package->id,
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'product_limit' => 'nullable|integer|min:1',
            'duration_in_days' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $package->update([
                'name' => $request->name,
                'description' => $request->description,
                'price' => $request->price,
                'product_limit' => $request->product_limit,
                'duration_in_days' => $request->duration_in_days,
                'is_active' => $request->has('is_active'),
            ]);

            return redirect()->route('packages.index')
                ->with('success', 'Package updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating package: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        try {
            $package->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Export packages to CSV
     */
    public function export()
    {
        $packages = Package::all();

        $filename = 'packages_' . date('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($packages) {
            $file = fopen('php://output', 'w');

            // Add headers
            fputcsv($file, ['ID', 'Name', 'Description', 'Price', 'Product Limit', 'Duration (Days)', 'Status', 'Created At']);

            // Add data
            foreach ($packages as $package) {
                fputcsv($file, [
                    $package->id,
                    $package->name,
                    $package->description,
                    $package->price,
                    $package->product_limit,
                    $package->duration_in_days,
                    $package->is_active ? 'Active' : 'Inactive',
                    $package->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
