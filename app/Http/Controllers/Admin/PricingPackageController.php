<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PricingPackage;
use Illuminate\Http\Request;

class PricingPackageController extends Controller
{
    public function index()
    {
        $packages = PricingPackage::orderBy('order', 'asc')->get();
        return view('admin.pricing_packages.index', [
            'packages' => $packages,
            'page' => 'pricing-packages'
        ]);
    }

    public function create()
    {
        return view('admin.pricing_packages.create', [
            'page' => 'pricing-packages'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'is_featured' => 'boolean',
            'order' => 'required|integer',
        ]);

        if (!isset($validated['is_featured'])) {
            $validated['is_featured'] = false;
        }

        PricingPackage::create($validated);
        return redirect()->route('admin.pricing-packages.index')->with('success', 'Pricing package created successfully.');
    }

    public function edit(PricingPackage $pricing_package)
    {
        return view('admin.pricing_packages.edit', [
            'package' => $pricing_package,
            'page' => 'pricing-packages'
        ]);
    }

    public function update(Request $request, PricingPackage $pricing_package)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|string|max:255',
            'features' => 'nullable|array',
            'features.*' => 'nullable|string',
            'is_featured' => 'boolean',
            'order' => 'required|integer',
        ]);

        if (!isset($validated['is_featured'])) {
            $validated['is_featured'] = false;
        }

        $pricing_package->update($validated);
        return redirect()->route('admin.pricing-packages.index')->with('success', 'Pricing package updated successfully.');
    }

    public function destroy(PricingPackage $pricing_package)
    {
        $pricing_package->delete();
        return redirect()->route('admin.pricing-packages.index')->with('success', 'Pricing package deleted successfully.');
    }
}
