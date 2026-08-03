@extends("admin.layout")
@section("content")
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h1 style="margin: 0;" class="i18n" data-en="{{ isset($project) ? 'Edit Project' : 'Add New Project' }}" data-ar="{{ isset($project) ? 'تعديل المشروع' : 'إضافة مشروع جديد' }}">{{ isset($project) ? 'Edit Project' : 'Add New Project' }}</h1>
    <a href="{{ route('admin.projects.index') }}" class="btn i18n" data-en="Back to Projects" data-ar="العودة للمشاريع" style="background: #6c757d; margin: 0;">Back to Projects</a>
</div>

<div class="stat-card" style="max-width: 900px; padding: 30px;">
    <form method="POST" action="{{ isset($project) ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" class="cv-form" enctype="multipart/form-data">
        @csrf
        @if(isset($project))
            @method('PUT')
        @endif
        
        @if ($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid #ef4444; color: #ef4444; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- General Info Row -->
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="flex: 2; min-width: 250px;">
                <label class="i18n" data-en="Project Title *" data-ar="عنوان المشروع *">Project Title *</label>
                <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" class="form-control" required style="max-width: 100%;">
            </div>
            <div style="flex: 1; min-width: 200px;">
                <label class="i18n" data-en="Category *" data-ar="الفئة *">Category *</label>
                <input type="text" name="category" value="{{ old('category', $project->category ?? '') }}" class="form-control" placeholder="e.g. aws, k8s, cicd" required style="max-width: 100%;">
            </div>
        </div>

        <!-- Technical Details Row -->
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="flex: 1; min-width: 200px;">
                <label class="i18n" data-en="Your Role" data-ar="الدور الوظيفي">Your Role</label>
                <input type="text" name="role" value="{{ old('role', $project->role ?? '') }}" class="form-control" placeholder="e.g. Cloud Architect" style="max-width: 100%;">
            </div>
            <div style="flex: 2; min-width: 250px;">
                <label class="i18n" data-en="Tech Stack (Comma Separated)" data-ar="الأدوات المستخدمة (مفصولة بفاصلة)">Tech Stack (Comma Separated)</label>
                <input type="text" name="tech_stack" value="{{ old('tech_stack', isset($project) && is_array($project->tech_stack) ? implode(', ', $project->tech_stack) : '') }}" class="form-control" placeholder="AWS, Docker, Terraform..." style="max-width: 100%;">
            </div>
        </div>

        <!-- Thumbnail Image -->
        <div style="margin-bottom: 15px;">
            <label class="i18n" data-en="Project Thumbnail" data-ar="صورة المشروع">Project Thumbnail</label>
            @if(isset($project) && $project->image_url)
                <div style="margin-bottom: 10px;">
                    <img src="{{ $project->image_url }}" alt="Thumbnail" style="height: 100px; border-radius: 6px; border: 1px solid #ccc; object-fit: cover;">
                </div>
            @endif
            <input type="file" name="image" class="form-control" accept="image/*" style="max-width: 100%; background: transparent;">
            <small style="color: #666;" class="i18n" data-en="Leave empty to keep current image." data-ar="اتركه فارغاً للاحتفاظ بالصورة الحالية.">Leave empty to keep current image.</small>
        </div>

        <!-- Description -->
        <div style="margin-bottom: 15px;">
            <label class="i18n" data-en="Description *" data-ar="الوصف *">Description *</label>
            <textarea name="description" rows="5" class="form-control" required style="max-width: 100%;">{{ old('description', $project->description ?? '') }}</textarea>
        </div>

        <div style="height: 1px; background: #888; margin: 30px 0; opacity: 0.2;"></div>
        <h3 style="margin-top: 0; margin-bottom: 15px; color: #007bff;" class="i18n" data-en="🔗 Architecture & Integration" data-ar="🔗 البنية الهندسية">🔗 Architecture & Integration</h3>
        
        <!-- Architecture Image and Diagram -->
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="flex: 1; min-width: 250px;">
                <label class="i18n" data-en="Architecture Image (Upload)" data-ar="صورة البنية الهندسية">Architecture Image (Upload)</label>
                @if(isset($project) && $project->architecture_image_url)
                    <div style="margin-bottom: 10px;">
                        <img src="{{ $project->architecture_image_url }}" alt="Architecture" style="height: 100px; border-radius: 6px; border: 1px solid #ccc; object-fit: contain;">
                    </div>
                @endif
                <input type="file" name="architecture_image" class="form-control" accept="image/*" style="max-width: 100%; background: transparent;">
            </div>
            <div style="flex: 2; min-width: 300px;">
                <label class="i18n" data-en="Architecture Diagram (Mermaid.js code)" data-ar="مخطط البنية (كود Mermaid.js)">Architecture Diagram (Mermaid.js code)</label>
                <textarea name="architecture_diagram" rows="4" class="form-control" placeholder="graph TD;\n  A-->B;" style="max-width: 100%; font-family: monospace;">{{ old('architecture_diagram', $project->architecture_diagram ?? '') }}</textarea>
                <small style="color: #666;">Write valid Mermaid.js syntax to render dynamic cloud architectures.</small>
            </div>
        </div>

        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
            <div style="flex: 1; min-width: 250px;">
                <label class="i18n" data-en="GitHub Actions Status Badge URL" data-ar="رابط حالة GitHub Actions">GitHub Actions Status Badge URL</label>
                <input type="text" name="github_actions_status" value="{{ old('github_actions_status', $project->github_actions_status ?? '') }}" class="form-control" placeholder="https://github.com/.../badge.svg" style="max-width: 100%;">
            </div>
            <div style="flex: 1; min-width: 250px;">
                <label>Display Order</label>
                <input type="number" name="display_order" value="{{ old('display_order', $project->display_order ?? 99) }}" class="form-control" style="max-width: 100%;">
            </div>
        </div>

        <div style="height: 1px; background: #888; margin: 30px 0; opacity: 0.2;"></div>
        <h3 style="margin-top: 0; margin-bottom: 15px; color: #007bff;" class="i18n" data-en="🔗 Project Links" data-ar="🔗 روابط المشروع">🔗 Project Links</h3>
        
        <!-- Links Row -->
        <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="flex: 1; min-width: 250px;">
                <label class="i18n" data-en="Repository URL" data-ar="رابط الكود المصدري">Repository URL</label>
                <input type="text" name="repository_url" value="{{ old('repository_url', $project->repository_url ?? '') }}" class="form-control" placeholder="https://github.com/..." style="max-width: 100%;">
            </div>
            <div style="flex: 1; min-width: 250px;">
                <label class="i18n" data-en="Live Demo URL" data-ar="رابط المعاينة الحية">Live Demo URL</label>
                <input type="text" name="live_url" value="{{ old('live_url', $project->live_url ?? '') }}" class="form-control" placeholder="https://..." style="max-width: 100%;">
            </div>
        </div>
        <div style="margin-bottom: 30px;">
            <label class="i18n" data-en="Demo Video (Upload MP4, WebM)" data-ar="فيديو العرض (رفع ملف)">Demo Video (Upload MP4, WebM)</label>
            @if(isset($project) && $project->video_url && str_starts_with($project->video_url, '/storage/'))
                <div style="margin-bottom: 10px;">
                    <video controls style="max-height: 150px; border-radius: 6px; border: 1px solid #ccc;">
                        <source src="{{ $project->video_url }}" type="video/mp4">
                    </video>
                </div>
            @endif
            <input type="file" name="video" class="form-control" accept="video/mp4,video/webm,video/ogg,video/quicktime" style="max-width: 100%; background: transparent;">
        </div>

        <!-- Actions -->
        <div style="display: flex; gap: 15px; align-items: center; border-top: 1px solid rgba(136, 136, 136, 0.2); padding-top: 20px;">
            <button type="submit" class="btn btn-primary i18n" data-en="Save Project" data-ar="حفظ المشروع" style="margin: 0; padding: 12px 30px; font-size: 1.1em;">Save Project</button>
            <a href="{{ route('admin.projects.index') }}" class="btn i18n" data-en="Cancel" data-ar="إلغاء" style="background: #6c757d; margin: 0; padding: 12px 30px; font-size: 1.1em;">Cancel</a>
        </div>
    </form>
</div>
@endsection
