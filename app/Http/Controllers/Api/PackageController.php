<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Select packages by IDs and return them as JSON.
     */
    public function selectPackages(Request $request)
    {
        $request->validate([
            'package_ids' => 'required|array',
            'package_ids.*' => 'integer|exists:packages,id',
        ]);

        $packages = Package::whereIn('id', $request->package_ids)->get();
        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }

    /**
     * Get all packages as JSON.
     */
    public function index()
    {
        $packages = Package::all();
        return response()->json([
            'success' => true,
            'data' => $packages
        ]);
    }
}