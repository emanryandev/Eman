<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CostEstimator;
use Illuminate\Http\Request;

class CostEstimatorController extends Controller
{
    public function index()
    {
        $estimators = CostEstimator::orderBy('order', 'asc')->get();
        return view('admin.cost_estimators.index', [
            'estimators' => $estimators,
            'page' => 'cost-estimators'
        ]);
    }

    public function create()
    {
        return view('admin.cost_estimators.create', [
            'page' => 'cost-estimators'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'min_value' => 'required|integer',
            'max_value' => 'required|integer',
            'step_value' => 'required|integer',
            'price_per_unit' => 'required|numeric',
            'order' => 'required|integer',
        ]);

        CostEstimator::create($validated);
        return redirect()->route('admin.cost-estimators.index')->with('success', 'Cost estimator created successfully.');
    }

    public function edit(CostEstimator $cost_estimator)
    {
        return view('admin.cost_estimators.edit', [
            'estimator' => $cost_estimator,
            'page' => 'cost-estimators'
        ]);
    }

    public function update(Request $request, CostEstimator $cost_estimator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'min_value' => 'required|integer',
            'max_value' => 'required|integer',
            'step_value' => 'required|integer',
            'price_per_unit' => 'required|numeric',
            'order' => 'required|integer',
        ]);

        $cost_estimator->update($validated);
        return redirect()->route('admin.cost-estimators.index')->with('success', 'Cost estimator updated successfully.');
    }

    public function destroy(CostEstimator $cost_estimator)
    {
        $cost_estimator->delete();
        return redirect()->route('admin.cost-estimators.index')->with('success', 'Cost estimator deleted successfully.');
    }
}
