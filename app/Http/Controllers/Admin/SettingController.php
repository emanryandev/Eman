<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SettingController extends Controller
{
    public function index()
    {
        $page = 'settings';
        $siteSettings = SiteSetting::first() ?? new SiteSetting();
        return view('admin.settings', compact('page', 'siteSettings'));
    }

    public function update(Request $request)
    {
        $settings = SiteSetting::first() ?? new SiteSetting();

        // 1. Handle regular fields
        $settings->years_experience = $request->input('years_experience');
        $settings->uptime_percentage = $request->input('uptime_percentage');
        $settings->whatsapp_number = $request->input('whatsapp_number');
        $settings->map_url = $request->input('map_url');
        $settings->hero_title_en = $request->input('hero_title_en');
        $settings->about_en = $request->input('about_en');
        $settings->currently_learning_name = $request->input('currently_learning_name');
        $settings->currently_learning_icon = $request->input('currently_learning_icon');

        // 2. Profile Pic
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/images'), $filename);
            $settings->profile_pic = '/assets/images/' . $filename;
        }

        // 3. Process Arrays
        // Core Skills
        $core_skills = [];
        if (is_array($request->input('core_skills.name'))) {
            foreach ($request->input('core_skills.name') as $i => $name) {
                if (!empty(trim($name))) {
                    $core_skills[] = [
                        'name' => trim($name),
                        'icon' => trim($request->input('core_skills.icon')[$i] ?? ''),
                        'percent' => (int)($request->input('core_skills.percent')[$i] ?? 0),
                    ];
                }
            }
        }
        $settings->core_skills = $core_skills;

        // Hobbies
        $hobbies = [];
        if (is_array($request->input('hobbies.name'))) {
            foreach ($request->input('hobbies.name') as $i => $name) {
                if (!empty(trim($name))) {
                    $hobbies[] = [
                        'name' => trim($name),
                        'icon' => trim($request->input('hobbies.icon')[$i] ?? ''),
                    ];
                }
            }
        }
        $settings->hobbies = $hobbies;

        // Experience Journey
        $experience_journey = [];
        if (is_array($request->input('experience_journey.title'))) {
            foreach ($request->input('experience_journey.title') as $i => $title) {
                if (!empty(trim($title))) {
                    $experience_journey[] = [
                        'title' => trim($title),
                        'company' => trim($request->input('experience_journey.company')[$i] ?? ''),
                        'duration' => trim($request->input('experience_journey.duration')[$i] ?? ''),
                        'description' => trim($request->input('experience_journey.description')[$i] ?? ''),
                    ];
                }
            }
        }
        $settings->experience_journey = $experience_journey;

        // Certifications
        $certifications = [];
        if (is_array($request->input('certifications.name'))) {
            foreach ($request->input('certifications.name') as $i => $name) {
                if (!empty(trim($name))) {
                    $certifications[] = [
                        'name' => trim($name),
                        'issuer' => trim($request->input('certifications.issuer')[$i] ?? ''),
                        'url' => trim($request->input('certifications.url')[$i] ?? ''),
                        'icon' => trim($request->input('certifications.icon')[$i] ?? 'fa-solid fa-certificate'),
                    ];
                }
            }
        }
        $settings->certifications = $certifications;

        // Tech Categories
        $tech_categories = [];
        if (is_array($request->input('tech_categories.name'))) {
            foreach ($request->input('tech_categories.name') as $i => $name) {
                if (!empty(trim($name))) {
                    $skillsRaw = trim($request->input('tech_categories.skills')[$i] ?? '');
                    $skills = array_filter(array_map('trim', explode(',', $skillsRaw)));
                    $tech_categories[] = [
                        'name' => trim($name),
                        'icon' => trim($request->input('tech_categories.icon')[$i] ?? 'fa-solid fa-layer-group'),
                        'skills' => array_values($skills),
                    ];
                }
            }
        }
        $settings->tech_categories = $tech_categories;

        // Testimonials
        $testimonials = [];
        if (is_array($request->input('testimonials.client_name'))) {
            foreach ($request->input('testimonials.client_name') as $i => $name) {
                if (!empty(trim($name))) {
                    $testimonials[] = [
                        'client_name' => trim($name),
                        'client_role' => trim($request->input('testimonials.client_role')[$i] ?? ''),
                        'feedback' => trim($request->input('testimonials.feedback')[$i] ?? ''),
                    ];
                }
            }
        }
        $settings->testimonials = $testimonials;

        // Services
        $services = [];
        if (is_array($request->input('services.title_en'))) {
            foreach ($request->input('services.title_en') as $i => $title_en) {
                if (!empty(trim($title_en))) {
                    $services[] = [
                        'title_en' => trim($title_en),
                        'description_en' => trim($request->input('services.description_en')[$i] ?? ''),
                        'icon' => trim($request->input('services.icon')[$i] ?? 'fa-solid fa-cloud'),
                    ];
                }
            }
        }
        $settings->services = $services;

        // B2B Brochure
        if ($request->hasFile('b2b_brochure')) {
            $file = $request->file('b2b_brochure');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('assets/docs'), $filename);
            $settings->b2b_brochure = '/assets/docs/' . $filename;
        }

        $settings->save();

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
    }
}
