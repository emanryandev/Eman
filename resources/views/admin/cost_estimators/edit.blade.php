@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Edit Cost Estimator: {{ $estimator->name }}</h1>
    <a href="{{ route('admin.cost-estimators.index') }}" class="btn" style="background:#64748b; margin-top: 0;"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<div class="stat-card" style="max-width: 700px;">
    <form action="{{ route('admin.cost-estimators.update', $estimator->id) }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
        @csrf
        @method('PUT')
        
        <div class="cv-form">
            <label>Name (e.g., Compute (EC2 Instances))</label>
            <input type="text" name="name" required value="{{ $estimator->name }}" class="form-control">
        </div>
        
        <div class="cv-form">
            <label>Unit (e.g., GB, Instances) - optional</label>
            <input type="text" name="unit" value="{{ $estimator->unit }}" class="form-control">
        </div>

        <div style="display:flex; gap:20px;">
            <div class="cv-form" style="flex:1;">
                <label>Min Value</label>
                <input type="number" name="min_value" required value="{{ $estimator->min_value }}" class="form-control">
            </div>
            <div class="cv-form" style="flex:1;">
                <label>Max Value</label>
                <input type="number" name="max_value" required value="{{ $estimator->max_value }}" class="form-control">
            </div>
            <div class="cv-form" style="flex:1;">
                <label>Step Value</label>
                <input type="number" name="step_value" required value="{{ $estimator->step_value }}" class="form-control">
            </div>
        </div>

        <div class="cv-form">
            <label>Price Per Unit (in $)</label>
            <input type="number" step="0.0001" name="price_per_unit" required value="{{ $estimator->price_per_unit }}" class="form-control">
        </div>

        <div class="cv-form">
            <label>Sort Order</label>
            <input type="number" name="order" required value="{{ $estimator->order }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 10px; align-self: flex-start;">Update Estimator</button>
    </form>
</div>
@endsection
