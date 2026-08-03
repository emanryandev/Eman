@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Edit Pricing Package: {{ $package->name }}</h1>
    <a href="{{ route('admin.pricing-packages.index') }}" class="btn" style="background:#64748b; margin-top: 0;"><i class="fa-solid fa-arrow-left"></i> Back</a>
</div>

<div class="stat-card" style="max-width: 700px;">
    <form action="{{ route('admin.pricing-packages.update', $package->id) }}" method="POST" style="display:flex; flex-direction:column; gap:20px;">
        @csrf
        @method('PUT')
        
        <div class="cv-form">
            <label>Name (e.g., Pro)</label>
            <input type="text" name="name" required value="{{ $package->name }}" class="form-control">
        </div>
        
        <div class="cv-form">
            <label>Price (e.g., $1500 or Custom)</label>
            <input type="text" name="price" required value="{{ $package->price }}" class="form-control">
        </div>

        <div class="cv-form">
            <label>Features (One per line)</label>
            <div id="features-container" style="display:flex; flex-direction:column; gap:15px;">
                @if(is_array($package->features) && count($package->features) > 0)
                    @foreach($package->features as $feature)
                        <input type="text" name="features[]" value="{{ $feature }}" class="form-control">
                    @endforeach
                @else
                    <input type="text" name="features[]" class="form-control" placeholder="e.g. 50 Hours Consulting">
                @endif
            </div>
            <button type="button" onclick="addFeature()" style="margin-top:15px; background:none; border:2px dashed #3b82f6; color:#3b82f6; padding:10px 15px; border-radius:8px; cursor:pointer; font-weight:600; width: 100%;"><i class="fa-solid fa-plus"></i> Add Feature</button>
        </div>

        <div class="cv-form" style="margin-top: 10px;">
            <label style="display:flex; align-items:center; gap:10px; cursor:pointer; font-weight: 500;">
                <input type="checkbox" name="is_featured" value="1" {{ $package->is_featured ? 'checked' : '' }} style="width: 20px; height: 20px; cursor: pointer;">
                <span>Featured Package? (Will be highlighted in UI)</span>
            </label>
        </div>

        <div class="cv-form">
            <label>Sort Order</label>
            <input type="number" name="order" required value="{{ $package->order }}" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary" style="margin-top: 10px; align-self: flex-start;">Update Package</button>
    </form>
</div>

<script>
function addFeature() {
    const container = document.getElementById('features-container');
    const input = document.createElement('input');
    input.type = 'text';
    input.name = 'features[]';
    input.className = 'form-control';
    input.placeholder = 'e.g. New Feature';
    container.appendChild(input);
}
</script>
@endsection
