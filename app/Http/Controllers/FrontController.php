<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CvConfig;
use App\Models\SiteSetting;
use App\Models\Project;
use App\Models\Testimonial;
use App\Models\CostEstimator;
use App\Models\PricingPackage;

class FrontController extends Controller
{
    public function index()
    {
        $siteSettings = SiteSetting::first() ?? new SiteSetting();
        $activeCv = CvConfig::where('is_active', true)->first() ?? new CvConfig();
        $projectsCount = Project::where('status', 'published')->count();
        $projects = Project::where('status', 'published')->orderBy('display_order')->get();
        $testimonials = Testimonial::where('is_approved', true)->get();
        $costEstimators = CostEstimator::orderBy('order', 'asc')->get();
        $pricingPackages = PricingPackage::orderBy('order', 'asc')->get();

        $cvUrl = !empty($activeCv->custom_cv_url) ? $activeCv->custom_cv_url : "/cv/download/{$activeCv->id}";

        $vName = addslashes($activeCv->personal_info['full_name'] ?? 'Eman Alaa');
        $vTitle = addslashes($activeCv->personal_info['title'] ?? 'Cloud Engineer');
        $vEmail = 'emanlaryan27@gmail.com';
        $vPhone = '+20 10 06619439';
        
        $links = $activeCv->personal_info['links'] ?? [];
        $vLink = 'https://www.linkedin.com/in/eman-alaa-685207398/';
        $vGithub = 'https://github.com/emanryandev';

        $coreSkills = $siteSettings->core_skills ?? [];
        $hobbies = $siteSettings->hobbies ?? [];
        $radarSkills = $siteSettings->radar_skills ?? [];
        $experienceJourney = $siteSettings->experience_journey ?? [];
        $learningName = $siteSettings->currently_learning_name ?? 'Rust 🦀';
        $learningIcon = $siteSettings->currently_learning_icon ?? 'fa-brands fa-rust';
        $profilePic = $siteSettings->profile_pic ?? '/assets/images/profile.png';
        
        $waNumber = '+201006619439';
        $cleanWaNumber = '201006619439';

        return view('front.home', compact(
            'siteSettings', 'activeCv', 'projectsCount', 'projects',
            'cvUrl', 'vName', 'vTitle', 'vEmail', 'vPhone', 'vLink', 'vGithub',
            'coreSkills', 'hobbies', 'radarSkills', 'testimonials', 'experienceJourney',
            'learningName', 'learningIcon', 'profilePic', 'cleanWaNumber', 'costEstimators', 'pricingPackages'
        ));
    }

    public function blog()
    {
        $articles = \App\Models\Article::where('is_published', true)->orderBy('published_at', 'desc')->get();
        return view('front.blog', compact('articles'));
    }

    public function article($slug)
    {
        $article = \App\Models\Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('front.article', compact('article'));
    }

    public function downloadCv($id)
    {
        $cv = \App\Models\CvConfig::findOrFail($id);
        
        if (!empty($cv->custom_cv_url)) {
            return redirect($cv->custom_cv_url);
        }
        
        $cvData = $cv->toArray();
        return view('front.cv-print', compact('cvData'));
    }
}
