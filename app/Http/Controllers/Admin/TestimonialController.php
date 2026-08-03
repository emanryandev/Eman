<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index()
    {
        $page = 'testimonials';
        $testimonials = Testimonial::orderBy('created_at', 'desc')->get();
        return view('admin.testimonials', compact('page', 'testimonials'));
    }

    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = true;
        $testimonial->save();
        return back()->with('success', 'Testimonial approved successfully!');
    }

    public function unapprove($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->is_approved = false;
        $testimonial->save();
        return back()->with('success', 'Testimonial hidden successfully!');
    }

    public function destroy($id)
    {
        Testimonial::findOrFail($id)->delete();
        return back()->with('success', 'Testimonial deleted successfully!');
    }
}
