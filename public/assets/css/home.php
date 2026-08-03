<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eman Alaa</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/terminal-mode.css">
</head>
<body class="dark-theme">

    <!-- Top Navigation -->
    <header class="app-header">
        <div class="logo">Eman-Alaa</div>
        <nav class="main-nav">
            <button class="nav-btn active" data-target="section-home">الرئيسية</button>
            <button class="nav-btn" data-target="section-about">عن المهندسة</button>
            <button class="nav-btn" data-target="section-services">الخدمات</button>
            <button class="nav-btn" data-target="section-projects">المشاريع</button>
            <button class="nav-btn" data-target="section-contact">اتصل بنا</button>
        </nav>
        <div class="nav-actions">
            <button id="btn-download-cv" onclick="window.location.href='/cv/download/YOUR_CV_ID_HERE'">Download CV</button>
            <button id="btn-toggle-terminal">_CLI Mode</button>
        </div>
    </header>

    <!-- Standard UI View -->
    <main id="view-standard" class="view-active">
        
        <!-- Home Section -->
        <section id="section-home" class="page-section active">
            <div class="hero">
                <h1>Architecting Scalable Cloud Infrastructure</h1>
                <p>Welcome to my portfolio. Deployments, pipelines, and distributed systems.</p>
            </div>
        </section>

        <!-- About Section -->
        <section id="section-about" class="page-section">
            <div class="about-container">
                <!-- ضع صورتك هنا -->
                <img src="https://via.placeholder.com/250" alt="Eman Profile" class="profile-pic">
                <div class="profile-info">
                    <h2>Eman</h2>
                    <p class="title">Senior Cloud & DevOps Engineer</p>
                    <p>مهندسة سحابية متخصصة في تصميم وبناء بيئات عمل آمنة، قابلة للتوسع، وعالية التوافر (Highly Available). لدي خبرة قوية في أتمتة العمليات (CI/CD) وإدارة البنية التحتية كأكواد (IaC) باستخدام أحدث الأدوات.</p>
                    
                    <ul class="contact-list">
                        <li>📧 <strong>Email:</strong> eman@example.com</li>
                        <li>🔗 <strong>LinkedIn:</strong> linkedin.com/in/eman-cloud</li>
                        <li>🐙 <strong>GitHub:</strong> github.com/eman-devops</li>
                        <li>📍 <strong>Location:</strong> Remote</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="section-services" class="page-section">
            <h2 class="section-title">الخدمات السحابية</h2>
            <div class="services-grid">
                <div class="service-card">
                    <h3>☁️ Cloud Architecture</h3>
                    <p>تصميم بنية تحتية سحابية متكاملة وقابلة للتوسع (AWS/GCP/Azure) تتحمل الضغط العالي مع ضمان أفضل أداء بأقل تكلفة.</p>
                </div>
                <div class="service-card">
                    <h3>🚀 CI/CD Automation</h3>
                    <p>أتمتة دورة حياة تطوير البرمجيات بالكامل (Pipelines) باستخدام Jenkins و GitHub Actions و GitLab لتسريع عمليات النشر.</p>
                </div>
                <div class="service-card">
                    <h3>🔒 DevSecOps & Security</h3>
                    <p>تأمين البيئات السحابية وتطبيق سياسات الأمان والحماية المتقدمة (Zero-Trust) لحماية البيانات الحساسة من الاختراق.</p>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="section-projects" class="page-section">
            <h2 class="section-title">أحدث المشاريع</h2>
            <div id="project-grid" class="grid-container">
                <!-- Projects will be injected here via JavaScript -->
            </div>
        </section>

        <!-- Contact Section -->
        <section id="section-contact" class="page-section">
            <h2 class="section-title">تواصل معي</h2>
            <div class="contact-form-container">
                <form class="contact-form" onsubmit="event.preventDefault(); alert('تم إرسال رسالتك بنجاح!');">
                    <input type="text" placeholder="الاسم" required>
                    <input type="email" placeholder="البريد الإلكتروني" required>
                    <textarea rows="5" placeholder="رسالتك" required></textarea>
                    <button type="submit" class="btn-primary">إرسال الرسالة</button>
                </form>
            </div>
        </section>

    </main>

    <!-- Terminal/CLI Overlay View -->
    <div id="view-terminal" class="view-hidden">
        <div class="terminal-window">
            <div class="terminal-header">
                <span class="dot red"></span><span class="dot yellow"></span><span class="dot green"></span>
                bash - root@cloud-portfolio:~
            </div>
            <div class="terminal-body" id="terminal-output">
                <div>Type <span class="cmd-highlight">help</span> to see available commands.</div>
            </div>
            <div class="terminal-input-line">
                <span class="prompt">visitor@cloud:~$</span>
                <input type="text" id="terminal-input" autocomplete="off" spellcheck="false">
            </div>
        </div>
    </div>
    
    <!-- Infrastructure Health Widget -->
    <div id="infra-widget" class="widget-container">
        <div class="widget-header">System Status</div>
        <div class="widget-body">
            <div class="metric">
                <span>API Latency:</span> <span id="metric-latency" class="value ok">12ms</span>
            </div>
            <div class="metric">
                <span>Uptime:</span> <span id="metric-uptime" class="value">99.99%</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/terminal-ui.js"></script>
    <script src="/assets/js/mock-server.js"></script>
</body>
</html>