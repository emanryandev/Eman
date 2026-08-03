@extends("admin.layout")
@section("content")
<h1 class="i18n" data-en="Dashboard" data-ar="الرئيسية">Dashboard</h1>
<p class="i18n" data-en="Welcome to the Cloud Portfolio Admin Panel." data-ar="مرحباً بك في لوحة تحكم محفظة الأعمال السحابية.">Welcome to the Cloud Portfolio Admin Panel.</p>
<div class="stats-grid">
    <div class="stat-card" style="border-left: 5px solid #007bff;">
        <h3 class="i18n" data-en="Total Projects" data-ar="إجمالي المشاريع">Total Projects</h3>
        <p style="font-size: 2.5em; font-weight: bold; margin: 10px 0; color: #007bff;"><?= $projectCount ?? 0 ?></p>
        <p class="i18n" data-en="Manage your deployed applications and their terminal animations." data-ar="إدارة تطبيقاتك المنشورة والتأثيرات الحركية الخاصة بها.">Manage your deployed applications and their terminal animations.</p>
        <a href="/admin/projects" class="btn i18n" data-en="Go to Projects" data-ar="الذهاب للمشاريع">Go to Projects</a>
    </div>
    <div class="stat-card" style="border-left: 5px solid #3fb950;">
        <h3 class="i18n" data-en="CV Configurations" data-ar="إعدادات السيرة الذاتية">CV Configurations</h3>
        <p style="font-size: 2.5em; font-weight: bold; margin: 10px 0; color: #3fb950;"><?= $totalDownloads ?? 0 ?> <span style="font-size: 0.4em; color: #888;" class="i18n" data-en="Downloads" data-ar="تحميل">Downloads</span></p>
        <p class="i18n" data-en="Update your ATS-friendly resume data." data-ar="تحديث بيانات سيرتك الذاتية المتوافقة مع الـ ATS.">Update your ATS-friendly resume data.</p>
        <a href="/admin/cv-builder" class="btn i18n" data-en="Go to CV Builder" data-ar="الذهاب لبناء السيرة">Go to CV Builder</a>
    </div>
    <div class="stat-card" style="border-left: 5px solid #8b5cf6;">
        <h3 class="i18n" data-en="Subscribers" data-ar="المشتركين">Subscribers</h3>
        <p style="font-size: 2.5em; font-weight: bold; margin: 10px 0; color: #8b5cf6;"><?= $subscribersCount ?? 0 ?></p>
        <p class="i18n" data-en="People subscribed to your DevOps Tips." data-ar="الأشخاص المشتركين في نصائح DevOps الخاصة بك.">People subscribed to your DevOps Tips.</p>
        <a href="/admin/messages" class="btn i18n" data-en="View Messages" data-ar="عرض الرسائل" style="background: #8b5cf6;">View Messages</a>
    </div>
</div>

<!-- Chart Section -->
<div class="stat-card" style="margin-top: 40px; padding: 20px; border-left: none;">
    <h3 class="i18n" data-en="CV Downloads (Last 7 Days)" data-ar="تحميلات السيرة الذاتية (آخر 7 أيام)" style="margin-top: 0; margin-bottom: 20px;">CV Downloads (Last 7 Days)</h3>
    <canvas id="downloadsChart" height="80"></canvas>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('downloadsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?= $chartLabelsJson ?? '[]' ?>,
            datasets: [{
                label: document.documentElement.lang === 'ar' ? 'التحميلات' : 'Downloads',
                data: <?= $chartDataJson ?? '[]' ?>,
                borderColor: '#3fb950',
                backgroundColor: 'rgba(63, 185, 80, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#007bff'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } } }
    });
});
</script>
@endsection
