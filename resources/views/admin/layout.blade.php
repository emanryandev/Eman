<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Cloud Portfolio - Admin</title>
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="/assets/css/admin.css">
    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SortableJS for Drag and Drop -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <!-- SweetAlert2 for beautiful alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>
<body class="dark-mode">
    <!-- Background Canvas -->
    <canvas id="admin-bg-canvas" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; z-index: -1; pointer-events: none; opacity: 0.4;"></canvas>

    <!-- Admin Mobile Sidebar Toggle (Mobile Only) -->
    <button class="admin-mobile-toggle" id="admin-mobile-toggle" aria-label="Toggle Sidebar">
        <span></span><span></span><span></span>
    </button>
    <!-- Sidebar Overlay -->
    <div class="admin-sidebar-overlay" id="admin-sidebar-overlay"></div>

    <div class="admin-sidebar" id="admin-sidebar">
        <h2 class="i18n"><i class="fa-solid fa-cloud" style="color: var(--accent-color);"></i> Cloud Admin</h2>
        <?php $badge = (isset($unreadCount) && $unreadCount > 0) ? "<span class='nav-badge'>{$unreadCount}</span>" : ''; ?>
        
        <nav>
            <a href="/admin/dashboard" class="<?= $page === 'dashboard' ? 'active' : '' ?>"><i class="fa-solid fa-chart-pie"></i> Dashboard</a>
            <a href="/admin/projects" class="<?= $page === 'project-manager' ? 'active' : '' ?>"><i class="fa-solid fa-layer-group"></i> Projects Manager</a>
            <a href="/admin/cv-builder" class="<?= $page === 'cv-builder' ? 'active' : '' ?>"><i class="fa-solid fa-file-signature"></i> CV Builder</a>
            <a href="/admin/messages" class="<?= $page === 'messages' ? 'active' : '' ?>"><i class="fa-solid fa-envelope"></i> Messages <?= $badge ?></a>
            <a href="/admin/testimonials" class="<?= $page === 'testimonials' ? 'active' : '' ?>"><i class="fa-solid fa-comment-dots"></i> Testimonials</a>
            <a href="/admin/pricing-packages" class="<?= $page === 'pricing-packages' ? 'active' : '' ?>"><i class="fa-solid fa-tags"></i> Pricing Packages</a>
            <a href="/admin/cost-estimators" class="<?= $page === 'cost-estimators' ? 'active' : '' ?>"><i class="fa-solid fa-calculator"></i> Cost Estimators</a>
            <a href="/admin/settings" class="<?= $page === 'settings' ? 'active' : '' ?>"><i class="fa-solid fa-gear"></i> Settings</a>
            <a href="/" target="_blank" class="view-site-link"><i class="fa-solid fa-globe"></i> View Site</a>
            
            <form method="POST" action="{{ route('logout') }}" style="display: block; margin-top: 30px; padding: 0 25px;">
                @csrf
                <a href="{{ route('logout') }}" class="logout-btn" onclick="event.preventDefault(); this.closest('form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </form>
        </nav>
    </div>
    <div class="admin-content">
        @yield('content')
    </div>
    
    <?php if($page === 'project-manager'): ?>
        <script src="/assets/js/admin-drag-drop.js"></script>
    <?php endif; ?>

    <script>
        // Simple Constellation Background for Admin
        const canvas = document.getElementById('admin-bg-canvas');
        const ctx = canvas.getContext('2d');
        let width, height;
        let particles = [];

        function resize() {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        }

        window.addEventListener('resize', resize);
        resize();

        class Particle {
            constructor() {
                this.x = Math.random() * width;
                this.y = Math.random() * height;
                this.vx = (Math.random() - 0.5) * 0.5;
                this.vy = (Math.random() - 0.5) * 0.5;
                this.radius = Math.random() * 1.5 + 0.5;
            }
            update() {
                this.x += this.vx;
                this.y += this.vy;
                if (this.x < 0 || this.x > width) this.vx *= -1;
                if (this.y < 0 || this.y > height) this.vy *= -1;
            }
            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(16, 185, 129, 0.5)';
                ctx.fill();
            }
        }

        for (let i = 0; i < 50; i++) particles.push(new Particle());

        function animate() {
            ctx.clearRect(0, 0, width, height);
            for (let i = 0; i < particles.length; i++) {
                particles[i].update();
                particles[i].draw();
                for (let j = i + 1; j < particles.length; j++) {
                    let dx = particles[i].x - particles[j].x;
                    let dy = particles[i].y - particles[j].y;
                    let dist = Math.sqrt(dx * dx + dy * dy);
                    if (dist < 100) {
                        ctx.beginPath();
                        ctx.moveTo(particles[i].x, particles[i].y);
                        ctx.lineTo(particles[j].x, particles[j].y);
                        ctx.strokeStyle = `rgba(16, 185, 129, ${1 - dist/100})`;
                        ctx.lineWidth = 0.5;
                        ctx.stroke();
                    }
                }
            }
            requestAnimationFrame(animate);
        }
        animate();

        // Beautiful SweetAlert Delete Confirmation
        function confirmDelete(event, formOrUrl, message) {
            event.preventDefault();
            Swal.fire({
                title: document.documentElement.lang === 'ar' ? 'هل أنت متأكد؟' : 'Are you sure?',
                text: message || (document.documentElement.lang === 'ar' ? "لن تتمكن من التراجع عن هذا الإجراء!" : "You won't be able to revert this!"),
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3b82f6',
                background: '#1e293b',
                color: '#f8fafc',
                confirmButtonText: document.documentElement.lang === 'ar' ? 'نعم، احذف!' : 'Yes, delete it!',
                cancelButtonText: document.documentElement.lang === 'ar' ? 'إلغاء' : 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    if (typeof formOrUrl === 'string') {
                        window.location.href = formOrUrl;
                    } else {
                        formOrUrl.submit();
                    }
                }
            });
        }
        // ---- Admin Mobile Sidebar Toggle ----
        (function() {
            const toggleBtn = document.getElementById('admin-mobile-toggle');
            const sidebar   = document.getElementById('admin-sidebar');
            const overlay   = document.getElementById('admin-sidebar-overlay');

            function openSidebar() {
                sidebar.classList.add('open');
                overlay.classList.add('active');
                toggleBtn.classList.add('open');
                document.body.style.overflow = 'hidden';
            }
            function closeSidebar() {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
                toggleBtn.classList.remove('open');
                document.body.style.overflow = '';
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (overlay)   overlay.addEventListener('click', closeSidebar);

            // Close when a nav link is clicked (navigates away)
            document.querySelectorAll('.admin-sidebar nav a').forEach(a => {
                a.addEventListener('click', closeSidebar);
            });

            document.addEventListener('keydown', e => {
                if (e.key === 'Escape') closeSidebar();
            });
        })();
    </script>
</body>
</html>