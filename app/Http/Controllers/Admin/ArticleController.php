<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index()
    {
        $page = 'articles';
        $articles = Article::orderBy('created_at', 'desc')->get();
        return view('admin.article-manager', compact('page', 'articles'));
    }

    public function create()
    {
        $page = 'articles';
        return view('admin.article-form', compact('page'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'markdown_content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        if (isset($validated['is_published']) && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        unset($validated['image']);
        Article::create($validated);
        
        return redirect()->route('admin.articles.index')->with('success', 'Article created successfully');
    }

    public function edit($id)
    {
        $page = 'articles';
        $article = Article::findOrFail($id);
        return view('admin.article-form', compact('page', 'article'));
    }

    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'markdown_content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean'
        ]);

        if ($request->hasFile('image')) {
            if ($article->image_url && str_starts_with($article->image_url, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $article->image_url));
            }
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Handle publishing logic
        if (isset($validated['is_published']) && $validated['is_published']) {
            if (!$article->published_at) {
                $validated['published_at'] = now();
            }
        } else {
            $validated['is_published'] = false;
        }

        unset($validated['image']);
        $article->update($validated);
        
        return redirect()->route('admin.articles.index')->with('success', 'Article updated successfully');
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if ($article->image_url && str_starts_with($article->image_url, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $article->image_url));
        }
        $article->delete();
        return response()->json(['success' => true]);
    }
}
