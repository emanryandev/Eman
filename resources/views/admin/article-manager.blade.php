@extends('admin.layout')
@section('content')
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
    <h1 style="margin: 0;" class="i18n" data-en="Technical Blog" data-ar="المدونة التقنية">Technical Blog</h1>
    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary i18n" data-en="+ New Article" data-ar="+ مقال جديد">+ New Article</a>
</div>

@if(session('success'))
    <div style="background: rgba(16,185,129,0.1); color: #10b981; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #10b981;">
        {{ session('success') }}
    </div>
@endif

<div class="stat-card" style="padding: 0; overflow: hidden;">
    <table class="table" style="margin: 0;">
        <thead>
            <tr>
                <th class="i18n" data-en="Title" data-ar="العنوان">Title</th>
                <th class="i18n" data-en="Status" data-ar="الحالة">Status</th>
                <th class="i18n" data-en="Published At" data-ar="تاريخ النشر">Published At</th>
                <th class="i18n" data-en="Actions" data-ar="إجراءات">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($articles as $article)
            <tr id="article-{{ $article->id }}">
                <td>
                    <div style="display: flex; align-items: center; gap: 15px;">
                        @if($article->image_url)
                            <img src="{{ $article->image_url }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                        @else
                            <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.05); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #888;">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                        @endif
                        <div>
                            <strong>{{ $article->title }}</strong>
                        </div>
                    </div>
                </td>
                <td>
                    @if($article->is_published)
                        <span class="tech-badge" style="background: rgba(16,185,129,0.1); color: #10b981; border-color: #10b981;">Published</span>
                    @else
                        <span class="tech-badge" style="background: rgba(245,158,11,0.1); color: #f59e0b; border-color: #f59e0b;">Draft</span>
                    @endif
                </td>
                <td>{{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}</td>
                <td>
                    <a href="{{ route('admin.articles.edit', $article->id) }}" class="btn" style="background: rgba(59,130,246,0.1); color: #3b82f6; border: 1px solid #3b82f6; padding: 5px 10px;">Edit</a>
                    <button onclick="deleteArticle('{{ $article->id }}')" class="btn" style="background: rgba(239,68,68,0.1); color: #ef4444; border: 1px solid #ef4444; padding: 5px 10px;">Delete</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; padding: 30px; color: #888;">No articles found. Start writing!</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<script>
function deleteArticle(id) {
    if(confirm('Are you sure you want to delete this article?')) {
        fetch(`/admin/articles/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        }).then(res => res.json()).then(data => {
            if(data.success) {
                document.getElementById('article-'+id).remove();
            }
        });
    }
}
</script>
@endsection
