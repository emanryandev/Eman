@extends('admin.layout')
@section('content')
<!-- Include EasyMDE CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h1 style="margin: 0;" class="i18n" data-en="{{ isset($article) ? 'Edit Article' : 'Write New Article' }}" data-ar="{{ isset($article) ? 'تعديل المقال' : 'كتابة مقال جديد' }}">{{ isset($article) ? 'Edit Article' : 'Write New Article' }}</h1>
    <a href="{{ route('admin.articles.index') }}" class="btn i18n" data-en="Back to Articles" data-ar="العودة للمقالات" style="background: #6c757d; margin: 0;">Back to Articles</a>
</div>

<div class="stat-card" style="max-width: 1000px; padding: 30px;">
    <form method="POST" action="{{ isset($article) ? route('admin.articles.update', $article->id) : route('admin.articles.store') }}" enctype="multipart/form-data">
        @csrf
        @if(isset($article))
            @method('PUT')
        @endif
        
        <div style="margin-bottom: 15px;">
            <label class="i18n" data-en="Article Title *" data-ar="عنوان المقال *">Article Title *</label>
            <input type="text" name="title" value="{{ old('title', $article->title ?? '') }}" class="form-control" required style="max-width: 100%; font-size: 1.2em; font-weight: bold;">
        </div>

        <div style="margin-bottom: 15px;">
            <label class="i18n" data-en="Summary (Short Description)" data-ar="ملخص">Summary (Short Description)</label>
            <textarea name="summary" rows="3" class="form-control" style="max-width: 100%;">{{ old('summary', $article->summary ?? '') }}</textarea>
        </div>

        <!-- Cover Image -->
        <div style="margin-bottom: 20px;">
            <label class="i18n" data-en="Cover Image" data-ar="صورة الغلاف">Cover Image</label>
            @if(isset($article) && $article->image_url)
                <div style="margin-bottom: 10px;">
                    <img src="{{ $article->image_url }}" alt="Cover" style="height: 150px; border-radius: 6px; border: 1px solid #ccc; object-fit: cover;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*" style="max-width: 100%; background: transparent;">
        </div>

        <div style="margin-bottom: 25px;">
            <label class="i18n" data-en="Markdown Content *" data-ar="المحتوى *">Markdown Content *</label>
            <textarea name="markdown_content" id="markdown_content">{{ old('markdown_content', $article->markdown_content ?? '') }}</textarea>
        </div>

        <div style="margin-bottom: 25px; display: flex; align-items: center; gap: 10px;">
            <input type="checkbox" name="is_published" value="1" id="is_published" {{ old('is_published', $article->is_published ?? false) ? 'checked' : '' }} style="width: 20px; height: 20px;">
            <label for="is_published" class="i18n" style="cursor: pointer;" data-en="Publish immediately" data-ar="نشر فوراً">Publish immediately</label>
        </div>

        <div style="display: flex; gap: 15px; align-items: center; border-top: 1px solid rgba(136, 136, 136, 0.2); padding-top: 20px;">
            <button type="submit" class="btn btn-primary i18n" data-en="Save Article" data-ar="حفظ المقال" style="margin: 0; padding: 12px 30px; font-size: 1.1em;">Save Article</button>
        </div>
    </form>
</div>

<style>
/* Override EasyMDE Dark Mode Styles to match our admin panel */
.editor-toolbar { border-color: rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); border-radius: 8px 8px 0 0; }
.editor-toolbar button { color: #94a3b8 !important; }
.editor-toolbar button.active, .editor-toolbar button:hover { background: rgba(255,255,255,0.1) !important; color: #fff !important; }
.CodeMirror { background: rgba(0,0,0,0.1) !important; color: #fff !important; border-color: rgba(255,255,255,0.1) !important; border-radius: 0 0 8px 8px; font-size: 1.1em; }
.CodeMirror-cursor { border-left: 2px solid #10b981 !important; }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var mde = new EasyMDE({ 
            element: document.getElementById('markdown_content'),
            spellChecker: false,
            placeholder: "Write your technical article here...",
            autofocus: true,
            status: ["lines", "words"]
        });
    });
</script>
@endsection
