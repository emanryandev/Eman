<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::where('status', 'published')->orderBy('display_order');
        
        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category', $request->category);
        }
        
        $projects = $query->get();
        return response()->json($projects);
    }

    public function clap(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['success' => false, 'error' => 'Project not found'], 404);
        }

        if ($request->action === 'remove' && $project->claps > 0) {
            $project->decrement('claps');
        } else {
            $project->increment('claps');
        }
        
        return response()->json(['success' => true, 'claps' => $project->claps]);
    }

    public function star(Request $request, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['success' => false, 'error' => 'Project not found'], 404);
        }

        if ($request->action === 'remove' && $project->stars > 0) {
            $project->decrement('stars');
        } else {
            $project->increment('stars');
        }
        
        return response()->json(['success' => true, 'stars' => $project->stars]);
    }
}
