@extends('admin.layout')

@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <h1>Pricing Packages</h1>
    <a href="{{ route('admin.pricing-packages.create') }}" class="btn btn-primary" style="text-decoration:none; margin-top: 0;"><i class="fa-solid fa-plus"></i> Add Package</a>
</div>

@if(session('success'))
<div style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
    {{ session('success') }}
</div>
@endif

<div class="stat-card" style="padding: 0; overflow: hidden;">
    <table style="width: 100%; text-align: left; border-collapse: collapse;">
        <thead style="background: rgba(0,0,0,0.03);">
            <tr>
                <th style="padding: 15px 20px; border-bottom: 1px solid #eee;">Order</th>
                <th style="padding: 15px 20px; border-bottom: 1px solid #eee;">Name</th>
                <th style="padding: 15px 20px; border-bottom: 1px solid #eee;">Price</th>
                <th style="padding: 15px 20px; border-bottom: 1px solid #eee;">Featured?</th>
                <th style="padding: 15px 20px; border-bottom: 1px solid #eee;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($packages as $package)
            <tr>
                <td style="padding: 15px 20px; border-bottom: 1px solid #eee;">{{ $package->order }}</td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #eee; font-weight:600;">{{ $package->name }}</td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #eee;">{{ $package->price }}</td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #eee;">
                    @if($package->is_featured)
                        <span class="status-badge status-published">Yes</span>
                    @else
                        <span style="color: #888;">No</span>
                    @endif
                </td>
                <td style="padding: 15px 20px; border-bottom: 1px solid #eee; display:flex; gap:15px; align-items: center;">
                    <a href="{{ route('admin.pricing-packages.edit', $package->id) }}" style="color: #3b82f6; text-decoration: none; font-weight: 500;"><i class="fa-solid fa-pen"></i> Edit</a>
                    <form action="{{ route('admin.pricing-packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Delete this package?');" style="margin: 0;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background:none; border:none; color:#ef4444; cursor:pointer; font-weight: 500; font-family: inherit;"><i class="fa-solid fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
            @if($packages->isEmpty())
            <tr>
                <td colspan="5" style="padding: 30px; text-align: center; color: #888;">No pricing packages found.</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>

<style>
body.dark-mode th, body.dark-mode td {
    border-bottom: 1px solid #334155 !important;
}
body.dark-mode thead {
    background: rgba(255,255,255,0.02) !important;
}
</style>
@endsection
