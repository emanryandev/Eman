@extends("admin.layout")
@section("content")
<div style="display: flex; justify-content: space-between; align-items: center;">
    <h1 class="i18n" data-en="Project Manager" data-ar="إدارة المشاريع">Project Manager</h1>
    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary i18n" data-en="+ Add New Project" data-ar="+ إضافة مشروع جديد" style="margin-top: 0;">+ Add New Project</a>
</div>

<p class="i18n" data-en="Drag and drop to reorder projects. Use the buttons to edit or delete." data-ar="اسحب وأفلت لترتيب المشاريع. استخدم الأزرار للتعديل أو الحذف.">Drag and drop to reorder projects. Use the buttons to edit or delete.</p>

<!-- Search & Filter Bar -->
<div style="display: flex; gap: 15px; margin-bottom: 20px;">
    <input type="text" id="search-project" class="form-control i18n-placeholder" data-en="🔍 Search projects..." data-ar="🔍 ابحث عن مشروع..." placeholder="🔍 Search projects..." style="flex: 2;">
    <select id="filter-category" class="form-control" style="flex: 1;">
        <option value="all" class="i18n" data-en="All Categories" data-ar="جميع الفئات">All Categories</option>
    </select>
</div>

<div class="project-list" id="sortable-projects">
    <p style="color: #666;" class="i18n" data-en="Loading projects..." data-ar="جاري تحميل المشاريع...">Loading projects...</p>
</div>

<!-- Quick Preview Modal -->
<div id="preview-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <img id="modal-img" style="display: none; width: calc(100% + 60px); height: 200px; object-fit: cover; border-radius: 8px 8px 0 0; margin: -30px -30px 20px -30px; border-bottom: 1px solid #ddd;">
        <h2 id="modal-title" style="margin-top:0; color:#333;">Title</h2>
        <div id="modal-badges" style="margin-bottom: 15px;"></div>
        <p id="modal-desc" style="color:#555; line-height:1.5;">Description</p>
        <a id="modal-link" href="#" target="_blank" class="btn btn-primary">Live Demo</a>
    </div>
</div>
@endsection
