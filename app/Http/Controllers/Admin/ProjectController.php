<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax() || $request->has('ajax')) {
            return response()->json(Project::orderBy('display_order')->get());
        }

        if ($request->has('action')) {
            $action = $request->query('action');
            $id = $request->query('id');

            if ($action === 'add') {
                return redirect()->route('admin.projects.create');
            } elseif ($action === 'edit' && $id) {
                return redirect()->route('admin.projects.edit', $id);
            } elseif ($action === 'delete' && $id) {
                $project = Project::find($id);
                if ($project) {
                    $project->delete();
                }
                return redirect()->route('admin.projects.index')->with('success', 'Project deleted');
            } elseif ($action === 'toggle_status' && $id) {
                $project = Project::find($id);
                if ($project) {
                    $project->status = $project->status === 'published' ? 'draft' : 'published';
                    $project->save();
                }
                return redirect()->route('admin.projects.index')->with('success', 'Status updated');
            }
        }

        $page = 'project-manager';
        return view('admin.project-manager', compact('page'));
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');
        if (is_array($order)) {
            foreach ($order as $index => $id) {
                Project::where('_id', $id)->orWhere('id', $id)->update(['display_order' => $index]);
            }
        }
        return response()->json(['success' => true]);
    }

    public function create()
    {
        $page = 'project-manager';
        return view('admin.project-form', compact('page'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'role' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'repository_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'integer',
            'status' => 'string',
            'architecture_diagram' => 'nullable|string',
            'architecture_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg,mov,qt|max:51200',
            'github_actions_status' => 'nullable|string'
        ]);

        if (isset($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        } else {
            $validated['tech_stack'] = [];
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        
        if ($request->hasFile('architecture_image')) {
            $path = $request->file('architecture_image')->store('projects/architecture', 'public');
            $validated['architecture_image_url'] = '/storage/' . $path;
        }
        
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('projects/videos', 'public');
            $validated['video_url'] = '/storage/' . $path;
        }
        
        // Remove uploaded file instances from validated data since they don't exist in DB as columns
        unset($validated['image'], $validated['architecture_image'], $validated['video']);

        Project::create($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
    }

    public function edit($id)
    {
        $page = 'project-manager';
        $project = Project::findOrFail($id);
        return view('admin.project-form', compact('page', 'project'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string',
            'role' => 'nullable|string',
            'tech_stack' => 'nullable|string',
            'repository_url' => 'nullable|url',
            'live_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'display_order' => 'integer',
            'status' => 'string',
            'architecture_diagram' => 'nullable|string',
            'architecture_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video' => 'nullable|file|mimes:mp4,webm,ogg,mov,qt|max:51200',
            'github_actions_status' => 'nullable|string'
        ]);

        if (isset($validated['tech_stack'])) {
            $validated['tech_stack'] = array_map('trim', explode(',', $validated['tech_stack']));
        } else {
            $validated['tech_stack'] = [];
        }

        if ($request->hasFile('image')) {
            if ($project->image_url && str_starts_with($project->image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $project->image_url));
            }
            $path = $request->file('image')->store('projects', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        
        if ($request->hasFile('architecture_image')) {
            if ($project->architecture_image_url && str_starts_with($project->architecture_image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $project->architecture_image_url));
            }
            $path = $request->file('architecture_image')->store('projects/architecture', 'public');
            $validated['architecture_image_url'] = '/storage/' . $path;
        }
        
        if ($request->hasFile('video')) {
            if ($project->video_url && str_starts_with($project->video_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $project->video_url));
            }
            $path = $request->file('video')->store('projects/videos', 'public');
            $validated['video_url'] = '/storage/' . $path;
        }

        // Remove uploaded file instances from validated data
        unset($validated['image'], $validated['architecture_image'], $validated['video']);

        $project->update($validated);
        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully');
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        if ($project->image_url && str_starts_with($project->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $project->image_url));
        }
        $project->delete();
        return response()->json(['success' => true]);
    }
}
