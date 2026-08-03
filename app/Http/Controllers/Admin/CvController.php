<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CvConfig;
use Illuminate\Support\Facades\Storage;

class CvController extends Controller
{
    public function index()
    {
        $page = 'cv-builder';
        $activeCv = CvConfig::where('is_active', true)->first() ?? new CvConfig();
        $cvData = $activeCv->toArray();
        return view('admin.cv-builder', compact('page', 'activeCv', 'cvData'));
    }

    public function update(Request $request)
    {
        $cv = CvConfig::where('is_active', true)->first() ?? new CvConfig();
        
        $validated = $request->validate([
            'summary' => 'nullable|string',
            'custom_cv' => 'nullable|mimes:pdf|max:10240'
        ]);

        // Layout Preferences
        $cv->layout_preferences = [
            'primary_color' => $request->primary_color,
            'font_family' => $request->font_family,
            'section_order' => $request->section_order ? explode(',', $request->section_order) : ['summary','skills','experience','education','certifications'],
        ];

        // Personal Info
        $links = [];
        if ($request->has('links') && is_array($request->links['label'] ?? null)) {
            foreach ($request->links['label'] as $index => $label) {
                if (!empty($label) || !empty($request->links['value'][$index])) {
                    $links[] = [
                        'label' => $label,
                        'icon' => $request->links['icon'][$index] ?? '',
                        'value' => $request->links['value'][$index] ?? '',
                    ];
                }
            }
        }
        $cv->personal_info = [
            'full_name' => $request->full_name,
            'title' => $request->title,
            'email' => $request->email,
            'phone' => $request->phone,
            'links' => $links,
        ];

        // Skills
        $skills = [];
        if ($request->has('skills') && is_array($request->skills['category'] ?? null)) {
            foreach ($request->skills['category'] as $index => $category) {
                if (!empty($category)) {
                    $skills[] = [
                        'category' => $category,
                        'keywords' => array_map('trim', explode(',', $request->skills['keywords'][$index] ?? '')),
                    ];
                }
            }
        }
        $cv->skills = $skills;

        // Experience
        $experience = [];
        if ($request->has('exp') && is_array($request->exp['job_title'] ?? null)) {
            foreach ($request->exp['job_title'] as $index => $jobTitle) {
                if (!empty($jobTitle)) {
                    $achievementsText = $request->exp['achievements'][$index] ?? '';
                    $experience[] = [
                        'job_title' => $jobTitle,
                        'company' => $request->exp['company'][$index] ?? '',
                        'start_date' => $request->exp['start_date'][$index] ?? '',
                        'end_date' => $request->exp['end_date'][$index] ?? '',
                        'location' => $request->exp['location'][$index] ?? '',
                        'achievements' => array_values(array_filter(array_map('trim', explode("\n", $achievementsText)))),
                    ];
                }
            }
        }
        $cv->experience = $experience;

        // Education
        $education = [];
        if ($request->has('edu') && is_array($request->edu['institution'] ?? null)) {
            foreach ($request->edu['institution'] as $index => $institution) {
                if (!empty($institution)) {
                    $education[] = [
                        'institution' => $institution,
                        'degree' => $request->edu['degree'][$index] ?? '',
                        'graduation_year' => $request->edu['graduation_year'][$index] ?? '',
                    ];
                }
            }
        }
        $cv->education = $education;

        // Certifications
        $certifications = [];
        if ($request->has('cert') && is_array($request->cert['name'] ?? null)) {
            foreach ($request->cert['name'] as $index => $name) {
                if (!empty($name)) {
                    $imagePath = $request->cert_existing_image[$index] ?? '';
                    if ($request->hasFile("cert_image.{$index}")) {
                        if ($imagePath && str_starts_with($imagePath, '/storage/')) {
                            Storage::disk('public')->delete(str_replace('/storage/', '', $imagePath));
                        }
                        $path = $request->file("cert_image.{$index}")->store('certs', 'public');
                        $imagePath = '/storage/' . $path;
                    }

                    $certifications[] = [
                        'name' => $name,
                        'issuer' => $request->cert['issuer'][$index] ?? '',
                        'date' => $request->cert['date'][$index] ?? '',
                        'image' => $imagePath,
                    ];
                }
            }
        }
        $cv->certifications = $certifications;

        $cv->summary = $validated['summary'] ?? $cv->summary;

        if ($request->hasFile('custom_cv')) {
            if ($cv->custom_cv_url && str_starts_with($cv->custom_cv_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $cv->custom_cv_url));
            }
            $path = $request->file('custom_cv')->store('cvs', 'public');
            $cv->custom_cv_url = '/storage/' . $path;
        }

        $cv->is_active = true;
        $cv->save();

        return redirect()->route('admin.cv.index')->with('success', 'CV updated successfully');
    }
}
