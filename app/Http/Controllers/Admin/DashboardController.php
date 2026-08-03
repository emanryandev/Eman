<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\CvConfig;
use App\Models\Message;
use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $page = 'dashboard';
        $projectCount = Project::count();
        $activeCv = CvConfig::where('is_active', true)->first();
        $totalDownloads = $activeCv->downloads ?? 0;
        $unreadCount = Message::where('is_read', false)->count();

        $history = $activeCv->downloads_history ?? [];
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $dString = date('Y-m-d', strtotime("-$i days"));
            $chartLabels[] = date('M d', strtotime($dString));
            $chartData[] = $history[$dString] ?? 0;
        }
        $chartLabelsJson = json_encode($chartLabels);
        $chartDataJson = json_encode($chartData);
        
        $subscribersCount = Subscriber::count();

        return view('admin.dashboard', compact(
            'page', 'projectCount', 'activeCv', 'totalDownloads', 
            'unreadCount', 'chartLabelsJson', 'chartDataJson', 'subscribersCount'
        ));
    }
}
