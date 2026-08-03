<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'feedback' => 'required|string',
        ]);

        Testimonial::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'feedback' => $validated['feedback'],
            'is_approved' => false
        ]);

        return response()->json(['success' => true, 'message' => 'Testimonial submitted successfully and is awaiting review.']);
    }
}
