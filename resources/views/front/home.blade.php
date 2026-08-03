<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Professional Cloud Engineer Portfolio - Specializing in Cloud Architecture, DevOps, and Infrastructure Automation">
    <title>Cloud Engineer Portfolio</title>
    <link rel="stylesheet" href="{{ asset('assets/css/style-modern.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/terminal-mode.css') }}">
    <!-- FontAwesome for Real Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha384-iw3OoTErCYJJB9mCa8LNS2hbsQ7M3C0EpIsO/H5+EGAkPGc6rk+V8i04oW/K5xq0" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('assets/css/ux-additions.css') }}">

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
</head>

<body class="dark-theme">
    <!-- Preloader -->
    <div id="site-preloader"
        style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: #0f172a; z-index: 999999; display: flex; flex-direction: column; justify-content: center; align-items: center; transition: opacity 0.8s ease-out, visibility 0.8s ease-out;">
        <h1 id="preloader-title"
            style="min-height: 1.2em; color: #e2e8f0; font-size: clamp(2em, 5vw, 4em); font-weight: bold; letter-spacing: 2px; text-align: center; margin-bottom: 40px; font-family: 'Courier New', Courier, monospace; background: linear-gradient(90deg, #10b981, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
        </h1>
        <div
            style="width: 250px; height: 4px; background: rgba(255,255,255,0.1); border-radius: 4px; overflow: hidden; position: relative; box-shadow: 0 0 10px rgba(16, 185, 129, 0.2);">
            <div id="preloader-bar"
                style="width: 0%; height: 100%; background: linear-gradient(90deg, #10b981, #3b82f6); border-radius: 4px; transition: width 3.5s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 0 15px rgba(16, 185, 129, 0.5);">
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const textToType = "Welcome, In my world";
            const titleElement = document.getElementById('preloader-title');
            let index = 0;

            function typeWriter() {
                if (index < textToType.length) {
                    titleElement.innerHTML += textToType.charAt(index);
                    index++;
                    setTimeout(typeWriter, 100);
                }
            }

            // Start typing after a short delay
            setTimeout(typeWriter, 300);

            setTimeout(() => {
                document.getElementById('preloader-bar').style.width = '100%';
            }, 100);

            // Hide after typing finishes + some delay
            setTimeout(() => {
                const pl = document.getElementById('site-preloader');
                if (pl) {
                    pl.style.opacity = '0';
                    pl.style.visibility = 'hidden';
                    setTimeout(() => pl.remove(), 800);
                }
            }, 3800);
        });
    </script>

    <!-- Aurora Background -->
    <div class="aurora-bg"></div>

    <!-- 💬 Floating Socials & Live Chat -->
    <div class="floating-socials">
        <a href="https://wa.me/{{ $cleanWaNumber }}" target="_blank" class="float-icon whatsapp"
            title="Chat on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
        <a href="{{ $vLink }}" target="_blank" class="float-icon" style="background: #0a66c2;"
            title="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
        <a href="{{ $vGithub }}" target="_blank" class="float-icon" style="background: #333;" title="GitHub"><i
                class="fa-brands fa-github"></i></a>
    </div>

    <!-- Background Audio (Ambient) -->
    <audio id="bg-audio" loop src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=lofi-study-112191.mp3"></audio>

    <!-- 💻 Mini Terminal -->
    <div class="mini-terminal-live" id="mini-terminal-live">
        <div class="mt-header">root@system:~</div>
        <div class="mt-body" id="mt-body"></div>
    </div>

    <!-- Modern Micro-Interactions -->
    <div id="scroll-progress" class="scroll-progress"></div>
    <div id="cursor-glow" class="cursor-glow"></div>

    <!-- FAQ Reading Progress -->
    <div id="faq-progress"></div>

    <!-- Top Navigation -->
    <header class="app-header">
        <div class="logo">user@cloud-env:~$</div>
        <nav class="main-nav" id="main-nav">
            <button class="nav-btn active" data-target="section-home"><span>Home</span></button>
            <button class="nav-btn" data-target="section-about"><span>About Me</span></button>
            <button class="nav-btn" data-target="section-services"><span>Services</span></button>
            <button class="nav-btn" data-target="section-projects"><span>Projects</span></button>
            <button class="nav-btn" data-target="section-contact"><span>Contact</span></button>
        </nav>
        <div class="nav-actions" id="nav-actions">
            <button id="btn-audio-toggle"
                style="background: transparent; color: #d946ef; border: 1px solid #d946ef; padding: 5px 10px; border-radius: 4px; cursor: pointer;"><i
                    class="fa-solid fa-volume-xmark"></i></button>

            <a id="btn-download-cv" class="btn-primary pulse-btn" href="{!! $cvUrl !!}" target="_blank" style="text-decoration: none; padding: 8px 20px; border-radius: 6px; margin-right: 15px; font-weight: bold; display: flex; align-items: center; gap: 8px;"><i class="fa-solid fa-download"></i> <span>Download CV</span></a>
            <button id="btn-toggle-terminal"><span>_CLI Mode</span></button>
        </div>
        <!-- Hamburger Button (Mobile Only) -->
        <button class="hamburger-btn" id="hamburger-btn" aria-label="Toggle Menu" aria-expanded="false">
            <span class="ham-line"></span>
            <span class="ham-line"></span>
            <span class="ham-line"></span>
        </button>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
    <div class="mobile-menu" id="mobile-menu" aria-hidden="true">
        <div class="mobile-menu-header">
            <span class="logo" style="-webkit-text-fill-color: unset; background: var(--gradient-aurora-1); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">user@cloud-env:~$</span>
            <button class="mobile-menu-close" id="mobile-menu-close" aria-label="Close Menu"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <nav class="mobile-nav">
            <button class="mobile-nav-btn" data-target="section-home"><i class="fa-solid fa-house"></i> <span>Home</span></button>
            <button class="mobile-nav-btn" data-target="section-about"><i class="fa-solid fa-user"></i> <span>About Me</span></button>
            <button class="mobile-nav-btn" data-target="section-services"><i class="fa-solid fa-gear"></i> <span>Services</span></button>
            <button class="mobile-nav-btn" data-target="section-projects"><i class="fa-solid fa-code-branch"></i> <span>Projects</span></button>
            <button class="mobile-nav-btn" data-target="section-contact"><i class="fa-solid fa-envelope"></i> <span>Contact</span></button>
        </nav>
        <div class="mobile-menu-actions">
            <a class="btn-primary pulse-btn" href="{!! $cvUrl !!}" target="_blank" style="text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; box-sizing: border-box;"><i class="fa-solid fa-download"></i> Download CV</a>
        </div>
    </div>


    <!-- Standard UI View -->
    <main id="view-standard" class="view-active">

        <!-- Home Section -->
        <section id="section-home" class="page-section active">
            <div id="particles-js"></div>
            <!-- 3D Server Element -->
            <div id="three-container"
                style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; z-index: 0; pointer-events: none; opacity: 0.6;">
            </div>
            <div class="hero">
                <h2 id="smart-greeting" class="reveal-up i18n"
                    style="color: var(--accent-color); font-size: 1.5em; margin-bottom: 10px;"></h2>
                <h1 class="reveal-up glitch-text"><span id="typewriter-text"
                        data-en="{{ $siteSettings['hero_title_en'] ?? 'Architecting Scalable Cloud Infrastructure' }}"
                        data-ar="{{ $siteSettings['hero_title_ar'] ?? 'بناء بنية تحتية سحابية قابلة للتوسع' }}"></span><span
                        class="typing-cursor"></span></h1>
                <p class="i18n reveal-up delay-100"
                    data-en="Welcome to my portfolio. Deployments, pipelines, and distributed systems."
                    data-ar="مرحباً بك في محفظة أعمالي. نشر، خطوط أنابيب، وأنظمة موزعة.">Welcome to my portfolio.
                    Deployments, pipelines, and distributed systems.</p>
            </div>

            <!-- Counters -->
            <div class="stats-row reveal-up delay-200">
                <div class="stat-item"><span class="counter"
                        data-target="{{ $siteSettings['years_experience'] ?? 5 }}">0</span><span>Years Experience</span>
                </div>
                <div class="stat-item"><span class="counter"
                        data-target="{{ $projectsCount ?? 0 }}">0</span><span>Projects Deployed</span></div>
                <div class="stat-item"><span class="counter"
                        data-target="{{ $siteSettings['uptime_percentage'] ?? 99 }}">0</span><span>% Uptime</span>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges reveal-up delay-300">
                <i class="fa-brands fa-aws"></i> <i class="fa-brands fa-docker"></i> <i
                    class="fa-brands fa-linux"></i> <i class="fa-brands fa-google"></i>
            </div>

            <!-- Live Status Dashboard -->
            <div class="live-status-dashboard reveal-up delay-400">
                <div class="lsd-header">
                    <span class="lsd-title"><i class="fa-solid fa-server"></i> <span>Live System Metrics</span></span>
                    <span class="lsd-status"><span class="pulse-dot"></span> <span>All Systems
                            Operational</span></span>
                </div>
                <div class="lsd-body">
                    <div class="lsd-metric">
                        <span class="lsd-label">CPU Usage</span>
                        <div class="lsd-bar-container">
                            <div class="lsd-bar lsd-cpu" style="width: 24%;"></div>
                        </div>
                        <span class="lsd-value" id="lsd-cpu-val">24%</span>
                    </div>
                    <div class="lsd-metric">
                        <span class="lsd-label">Memory Allocation</span>
                        <div class="lsd-bar-container">
                            <div class="lsd-bar lsd-mem" style="width: 45%;"></div>
                        </div>
                        <span class="lsd-value" id="lsd-mem-val">45%</span>
                    </div>
                    <div class="lsd-metric">
                        <span class="lsd-label">Network Latency</span>
                        <div class="lsd-chart" id="lsd-ping-chart">
                            <!-- Small bars generated by JS -->
                        </div>
                        <span class="lsd-value" id="lsd-ping-val">12ms</span>
                    </div>
                </div>
            </div>

            <div class="scroll-indicator" onclick="document.querySelector('[data-target=\'section-about\']').click()">
                <i class="fa-solid fa-chevron-down"></i></div>
        </section>

        <!-- About Section -->
        <section id="section-about" class="page-section">
            <div class="source-code-bg">resource "aws_instance" "web" { ami = "ami-0c55b159cbfafe1f0"
                instance_type = "t2.micro" tags = { Name = "Eman_Server" } }</div>

            <!-- Band A: Bio & Contact (Split) -->
            <div class="about-container reveal-zoom"
                style="margin-bottom: 50px; display: flex; flex-wrap: wrap; gap: 40px; padding: 20px;">
                <div class="reveal-left delay-100" style="flex: 1; min-width: 250px;">
                    <div class="scratch-reveal-container"><img src="{{ $profilePic }}"
                            onerror="this.src='https://placehold.co/250';" alt="Profile"
                            class="profile-pic scratch-pic"></div>
                    <ul class="contact-list" style="margin-top: 25px;">
                        @if (!empty($vEmail))
                            <li class="copy-item" data-clipboard="{{ $vEmail }}"><i
                                    class="fa-solid fa-envelope" style="color: var(--accent-color); width: 25px;"></i>
                                {{ $vEmail }} <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if (!empty($vPhone))
                            <li class="copy-item" data-clipboard="{{ $vPhone }}"><i class="fa-solid fa-phone"
                                    style="color: var(--accent-color); width: 25px;"></i> {{ $vPhone }} <i
                                    class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if (!empty($vLink))
                            <li class="copy-item" data-clipboard="{{ $vLink }}"><i
                                    class="fa-brands fa-linkedin"
                                    style="color: var(--accent-color); width: 25px;"></i> LinkedIn <i
                                    class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if (!empty($vGithub))
                            <li class="copy-item" data-clipboard="{{ $vGithub }}"><i
                                    class="fa-brands fa-github" style="color: var(--accent-color); width: 25px;"></i>
                                GitHub <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                    </ul>
                    <button class="btn-primary i18n" data-en="Download VCard" data-ar="حفظ جهة الاتصال"
                        onclick="downloadVCard('{!! $vName !!}', '{!! $vTitle !!}', '{!! $vEmail !!}', '{!! $vPhone !!}', '{!! $vLink !!}')"
                        style="width:100%; font-size:1em; padding:12px 15px; margin-top: 20px;"><i
                            class="fa-solid fa-address-card"></i> Download VCard</button>
                </div>

                <div class="profile-info reveal-right delay-200" style="flex: 2; min-width: 300px;">
                    <h2>{{ $activeCv['personal_info']['full_name'] ?? 'Eman' }} <span class="availability-dot"
                            title="Available for work"></span> <button
                            onclick="new Audio('https://dictaudio.playphrase.me/eman.mp3').play()"
                            style="background:none;border:none;color:#10b981;cursor:pointer;"><i
                                class="fa-solid fa-volume-high"></i></button></h2>
                    <p class="title" style="margin-top: 5px;">
                        {{ $activeCv['personal_info']['title'] ?? 'Senior Cloud & DevOps Engineer' }}</p>

                    @if (!empty($learningName))
                        <div class="currently-learning" style="margin-bottom: 25px; font-size: 0.95em;">
                            <span>Currently Learning:</span>
                            <span class="tech-badge"
                                style="display: inline-flex; margin-left: 10px; background: rgba(217, 70, 239, 0.1); border-color: #d946ef; color: #d946ef;"><i
                                    class="{{ $learningIcon }}"></i> {{ $learningName }}</span>
                        </div>
                    @endif

                    <div
                        style="font-size: 1.1em; line-height: 1.8; color: var(--text-secondary); margin-bottom: 30px;">
                        <p>{{ $siteSettings['about_en'] ?? '' }}</p>
                    </div>

                    @if (!empty($testimonials) && $testimonials->count() > 0)
                        <div class="testimonials-wrapper"
                            style="position: relative; min-height: 130px; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 20px;">
                            <i class="fa-solid fa-quote-left"
                                style="color: var(--accent-color); font-size: 2em; opacity: 0.1; position: absolute; top: 15px; left: 20px;"></i>
                            @foreach ($testimonials as $index => $test)
                                <div class="testimonial-slide"
                                    style="position: absolute; width: 100%; padding: 0 40px; box-sizing: border-box; text-align: center; opacity: {!! $index === 0 ? '1' : '0' !!}; transition: opacity 0.6s ease-in-out; pointer-events: {!! $index === 0 ? 'auto' : 'none' !!};">
                                    <p
                                        style="font-style: italic; font-size: 0.95em; color: #e2e8f0; margin-bottom: 10px; line-height: 1.6;">
                                        "{{ $test->feedback }}"</p>
                                    <strong
                                        style="color: var(--accent-color); display: block; font-size: 1em;">{{ $test->name }}</strong>
                                    <span style="color: #888; font-size: 0.85em;">{{ $test->role }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Band B: Experience Journey (Full Width) -->
            <div class="experience-band reveal-up" style="margin-bottom: 70px; padding: 0 20px;">
                <h3 class="i18n section-title" data-en="Experience Journey" data-ar="مسار الخبرات"
                    style="text-align: center; margin-bottom: 30px;">Experience Journey</h3>
                <div class="timeline">
                    <?php $delay = 0; foreach($experienceJourney as $exp): ?>
                    <div class="timeline-item reveal-up delay-{!! $delay !!}">
                        <div class="timeline-content">
                            <span class="timeline-date">{{ $exp['duration'] ?? ($exp['date'] ?? '') }}</span>
                            <h4 class="timeline-title" style="margin-top: 10px;">{{ $exp['title'] ?? '' }}</h4>
                            @if (!empty($exp['company']))
                                <div class="timeline-company">
                                    <i class="fa-solid fa-building" style="margin-right: 5px; color: var(--accent-color);"></i> {{ $exp['company'] }}
                                </div>
                            @endif
                            @if (!empty($exp['description']))
                                <p style="font-size: 0.95em; color: var(--text-secondary); margin-bottom: 0; line-height: 1.6;">
                                    {{ $exp['description'] }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <?php $delay += 100; endforeach; ?>
                    @if (empty($experienceJourney))
                        <p style="color: #666; font-size: 0.9em; text-align: center; width: 100%;">Experience details
                            will appear here.</p>
                    @endif
                </div>
            </div>

            <!-- Band C: Skills Ecosystem -->
            <div class="skills-band reveal-up" style="margin-bottom: 70px; padding: 0 20px;">
                <h3 class="i18n section-title" data-en="Skills & Expertise" data-ar="المهارات والخبرات"
                    style="text-align: center; margin-bottom: 30px;">Skills & Expertise</h3>
                <div style="display: flex; gap: 50px; flex-wrap: wrap;">
                    <!-- Left: Core Tech & Radar -->
                    <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 30px;">
                        <div>
                            <h4
                                style="margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                                Core Technologies</h4>
                            @foreach ($coreSkills as $skill)
                                <div class="skill-item">
                                    <div class="skill-header"><span><i class="{{ $skill['icon'] ?? '' }}"
                                                style="color: var(--accent-color); width: 25px;"></i>
                                            {{ $skill['name'] ?? '' }}</span><span>{{ $skill['percent'] ?? 0 }}%</span>
                                    </div>
                                    <div class="skill-bar">
                                        <div class="skill-fill" data-width="{{ $skill['percent'] ?? 0 }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div>
                            <h4
                                style="margin-bottom: 20px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">
                                Skills Radar</h4>
                            <div class="radar-chart-container" style="max-width: 320px; margin: 0 auto;">
                                <canvas id="skillsRadarChart"></canvas>
                            </div>
                        </div>

                        <!-- Live GitHub Stats -->
                        <div class="live-github-stats"
                            style="margin-top: 10px; border: 1px solid rgba(16,185,129,0.2); background: rgba(16,185,129,0.05); border-radius: 8px; padding: 15px; text-align: center;">
                            <span>Live GitHub Commits:</span> <strong id="gh-commits-count"
                                style="color: var(--accent-color);">Loading...</strong>
                        </div>
                    </div>

                    <!-- Right: Tech Stack Categories -->
                    <div style="flex: 1.5; min-width: 300px;">
                        @if (!empty($siteSettings['tech_categories']) && is_array($siteSettings['tech_categories']))
                            <div class="tech-category-grid"
                                style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px; display: grid;">
                                @foreach ($siteSettings['tech_categories'] as $cat)
                                    <div class="tech-category-card"
                                        style="background: rgba(15,23,42,0.5); padding: 20px;">
                                        <div class="tech-cat-header" style="margin-bottom: 15px;">
                                            <i class="{{ $cat['icon'] ?? 'fa-solid fa-layer-group' }} tech-cat-icon"
                                                style="font-size: 1.5em; color: var(--accent-color);"></i>
                                            <span class="tech-cat-title"
                                                style="font-size: 1.1em; font-weight: bold; margin-left: 10px;">{{ $cat['name'] ?? '' }}</span>
                                        </div>
                                        <div class="tech-cat-skills">
                                            @if (!empty($cat['skills']) && is_array($cat['skills']))
                                                @foreach ($cat['skills'] as $skill)
                                                    <span class="tech-badge"
                                                        style="margin-bottom: 8px; display: inline-flex; align-items: center; gap: 5px;"><i
                                                            class="fa-solid fa-check"
                                                            style="color:var(--accent-primary); font-size:0.8em;"></i>
                                                        {{ $skill }}</span>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Band D: Achievements & Personal -->
            <div class="personal-band reveal-up" style="padding: 0 20px;">
                <div style="display: flex; gap: 50px; flex-wrap: wrap;">
                    <div style="flex: 2; min-width: 300px;">
                        @if (!empty($activeCv['certifications']))
                            <h3 class="i18n section-title" data-en="Certifications" data-ar="الشهادات المعتمدة"
                                style="margin-bottom: 25px;">Certifications</h3>
                            <div class="certifications-grid"
                                style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 15px;">
                                <?php $delay = 0; foreach($activeCv['certifications'] as $cert): ?>
                                <div class="cert-card reveal-up delay-{!! $delay !!}"
                                    style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; display: flex; align-items: center; gap: 15px;">
                                    @if (!empty($cert['image']))
                                        <div
                                            style="background: #fff; padding: 5px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ $cert['image'] }}" alt="{{ $cert['name'] }}"
                                                style="width: 45px; height: 45px; object-fit: contain;">
                                        </div>
                                    @else
                                        <div
                                            style="width: 45px; height: 45px; background: rgba(16,185,129,0.1); color: var(--accent-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.3em; flex-shrink: 0;">
                                            <i class="fa-solid fa-award"></i></div>
                                    @endif
                                    <div>
                                        <strong
                                            style="display: block; color: var(--text-color); font-size: 1em; line-height: 1.2; margin-bottom: 5px;">{{ $cert['name'] }}</strong>
                                        <span style="color: #888; font-size: 0.85em;">{{ $cert['issuer'] }}
                                            {!! !empty($cert['date']) ? ' (' . htmlspecialchars($cert['date']) . ')' : '' !!}</span>
                                    </div>
                                </div>
                                <?php $delay += 100; endforeach; ?>
                            </div>
                        @endif
                    </div>

                    <div style="flex: 1; min-width: 200px;">
                        <h3 class="i18n section-title" data-en="Hobbies" data-ar="الاهتمامات"
                            style="margin-bottom: 25px;">Hobbies</h3>
                        <div class="hobbies-icons" style="justify-content: flex-start; gap: 15px;">
                            @foreach ($hobbies as $hobby)
                                <span title="{{ $hobby['name'] ?? '' }}"
                                    style="width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; background: rgba(255,255,255,0.05); border-radius: 50%; font-size: 1.5em;"><i
                                        class="{{ $hobby['icon'] ?? '' }}"></i></span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="section-services" class="page-section">
            <h2 class="section-title i18n reveal-down" data-en="Cloud Services" data-ar="الخدمات السحابية">Cloud
                Services</h2>

            <!-- Process Path -->
            <div class="process-path reveal-up" style="margin-bottom: 40px;">
                <div class="step">1. Analyze</div>
                <div class="step">2. Architect</div>
                <div class="step">3. Automate</div>
                <div class="step">4. Monitor</div>
            </div>

            <!-- CI/CD Visual Pipeline Representation -->
            <div class="cicd-pipeline-visual reveal-up delay-200"
                style="background: rgba(15,23,42,0.8); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-bottom: 50px; text-align: center; overflow-x: auto;">
                <h3 style="color: #94a3b8; font-size: 1rem; margin-top: 0; margin-bottom: 20px;">Typical Deployment
                    Pipeline</h3>
                <div
                    style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px; padding: 10px 20px;">
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <i class="fa-brands fa-github" style="font-size: 2.5em; color: #fff;"></i>
                        <span style="font-size: 0.8em; font-weight: bold;">1. Commit</span>
                    </div>
                    <div
                        style="flex: 1; height: 2px; background: linear-gradient(90deg, #3b82f6, #10b981); margin: 0 15px; position: relative;">
                        <i class="fa-solid fa-chevron-right"
                            style="position: absolute; right: -5px; top: -6px; color: #10b981;"></i>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <i class="fa-solid fa-gear fa-spin" style="font-size: 2.5em; color: #3b82f6;"></i>
                        <span style="font-size: 0.8em; font-weight: bold;">2. Build (Actions)</span>
                    </div>
                    <div
                        style="flex: 1; height: 2px; background: linear-gradient(90deg, #3b82f6, #f59e0b); margin: 0 15px; position: relative;">
                        <i class="fa-solid fa-chevron-right"
                            style="position: absolute; right: -5px; top: -6px; color: #f59e0b;"></i>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <i class="fa-brands fa-docker" style="font-size: 2.5em; color: #2496ed;"></i>
                        <span style="font-size: 0.8em; font-weight: bold;">3. Containerize</span>
                    </div>
                    <div
                        style="flex: 1; height: 2px; background: linear-gradient(90deg, #f59e0b, #10b981); margin: 0 15px; position: relative;">
                        <i class="fa-solid fa-chevron-right"
                            style="position: absolute; right: -5px; top: -6px; color: #10b981;"></i>
                    </div>
                    <div style="display: flex; flex-direction: column; align-items: center; gap: 10px;">
                        <i class="fa-brands fa-aws" style="font-size: 2.5em; color: #ff9900;"></i>
                        <span style="font-size: 0.8em; font-weight: bold;">4. Deploy (ECS/EKS)</span>
                    </div>
                </div>
            </div>

            <div class="services-grid">
                <?php $services = $siteSettings['services'] ?? []; ?>
                <?php if(empty($services)): ?>
                <!-- Default Services if none exist -->
                <div class="service-card reveal-up delay-100">
                    <span class="floating-icon"><i class="fa-solid fa-cloud"
                            style="color: var(--accent-color);"></i></span>
                    <h3 class="i18n" data-en="Cloud Architecture" data-ar="البنية التحتية السحابية">Cloud
                        Architecture</h3>
                    <p class="i18n"
                        data-en="Designing scalable integrated cloud architecture (AWS/GCP/Azure) to handle high traffic with optimal performance and lowest cost."
                        data-ar="تصميم بنية تحتية سحابية متكاملة وقابلة للتوسع (AWS/GCP/Azure) تتحمل الضغط العالي مع ضمان أفضل أداء بأقل تكلفة.">
                        Designing scalable integrated cloud architecture (AWS/GCP/Azure) to handle high traffic with
                        optimal performance and lowest cost.</p>
                    <button class="btn-service-cta i18n" data-en="Request Service" data-ar="طلب الخدمة"
                        onclick="document.querySelector('.nav-btn[data-target=\'section-contact\']').click(); document.getElementById('contact-subject').value='Cloud Architecture';">Request
                        Service</button>
                </div>
                <?php else: ?>
                <?php foreach($services as $index => $srv): ?>
                <div class="service-card reveal-up" style="animation-delay: <?= $index * 100 ?>ms;">
                    <span class="floating-icon"><i class="<?= htmlspecialchars($srv['icon']) ?>"
                            style="color: var(--accent-color);"></i></span>
                    <h3><?= htmlspecialchars($srv['title_en']) ?></h3>
                    <p><?= htmlspecialchars($srv['description_en']) ?></p>
                    <button class="btn-service-cta"
                        onclick="document.querySelector('.nav-btn[data-target=\'section-contact\']').click(); document.getElementById('contact-subject').value='<?= htmlspecialchars(addslashes($srv['title_en'])) ?>';">Request
                        Service</button>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Interactive Architecture & Brochure Download -->
            <div style="margin-top: 50px; text-align: center;" class="reveal-up">
                <h3>Interactive Cloud Architecture</h3>
                <div class="interactive-architecture"
                    style="position: relative; display: inline-block; max-width: 100%; border: 1px solid var(--border-color); border-radius: 8px; overflow: hidden;">
                    <!-- صورة وهمية لبنية سحابية (استبدلها بصورتك الحقيقية) -->
                    <img src="https://placehold.co/800x400/1e293b/10b981?text=Cloud+Architecture+Diagram"
                        alt="Architecture" style="display: block; width: 100%;">
                    <!-- Hotspots -->
                    <div class="hotspot" style="top: 30%; left: 20%;"
                        title="Load Balancer: يوزع الضغط على السيرفرات"><i class="fa-solid fa-network-wired"></i>
                    </div>
                    <div class="hotspot" style="top: 50%; left: 50%;" title="Auto Scaling Group: السيرفرات الأساسية">
                        <i class="fa-solid fa-server"></i></div>
                    <div class="hotspot" style="top: 70%; left: 80%;" title="RDS Database: قاعدة بيانات مشفرة"><i
                            class="fa-solid fa-database"></i></div>
                </div>

                <?php if(!empty($siteSettings['b2b_brochure'])): ?>
                <div style="margin-top: 30px;">
                    <a href="<?= htmlspecialchars($siteSettings['b2b_brochure']) ?>" download class="btn-primary"
                        style="text-decoration: none; padding: 12px 25px;">📄 Download B2B Brochure</a>
                </div>
                <?php endif; ?>
            </div>

            <!-- Before & After Slider, ROI Calc & Cloud Cost Estimator -->
            <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; margin-top: 50px;">
                <div class="roi-calculator stat-card">
                    <h3>ROI Calculator</h3>
                    <input type="number" id="roi-input" placeholder="Current Monthly Infra Cost ($)"
                        style="width:100%; padding:10px; margin-bottom:10px; border-radius:4px;">
                    <button onclick="calculateROI()" class="btn-primary" style="width:100%">Calculate
                        Savings</button>
                    <p id="roi-result" style="margin-top:15px; color:var(--accent-color); font-weight:bold;"></p>
                </div>
                <div class="before-after-container">
                    <div class="ba-layer after-layer">
                        <div class="ba-label">Cloud (Automated)</div>
                    </div>
                    <div class="ba-layer before-layer">
                        <div class="ba-label">Legacy (Manual)</div>
                    </div>
                    <input type="range" min="0" max="100" value="50" class="ba-slider"
                        id="ba-slider">
                </div>

                <!-- FinOps Cloud Cost Estimator Moved Here -->
                <div style="width: 100%; max-width: 800px; margin-top: 30px;">
                    <h3 style="margin-bottom: 20px; text-align: center;">FinOps: Cloud Cost Estimator</h3>
                    <div class="cost-calculator reveal-up delay-200"
                        style="background: rgba(15,23,42,0.6); padding: 25px; border-radius: 8px; border: 1px solid var(--border-color);">
                        <div id="dynamic-cost-calculators" style="display: flex; flex-direction: column; gap: 20px;">
                            @foreach($costEstimators as $estimator)
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                    <span>{{ $estimator->name }}</span> 
                                    <span id="calc-estimator-val-{{ $estimator->id }}" style="color:var(--accent-color); font-weight:bold; font-size: 1.1em;">{{ $estimator->min_value }} {{ $estimator->unit }}</span>
                                </label>
                                <input type="range" class="dynamic-calc-input" data-id="{{ $estimator->id }}" data-price="{{ $estimator->price_per_unit }}" data-unit="{{ $estimator->unit }}" id="calc-estimator-{{ $estimator->id }}" min="{{ $estimator->min_value }}" max="{{ $estimator->max_value }}" value="{{ $estimator->min_value }}" step="{{ $estimator->step_value }}" style="width: 100%; accent-color: var(--accent-color); position: relative; z-index: 10;">
                            </div>
                            @endforeach
                            
                            @if($costEstimators->isEmpty())
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span>Compute (EC2 Instances)</span> <span id="calc-compute-val" style="color:var(--accent-color); font-weight:bold; font-size: 1.1em;">2</span></label>
                                <input type="range" id="calc-compute" min="1" max="50" value="2" style="width: 100%; accent-color: var(--accent-color); position: relative; z-index: 10;">
                            </div>
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span>Database Storage (GB)</span> <span id="calc-db-val" style="color:var(--accent-color); font-weight:bold; font-size: 1.1em;">100 GB</span></label>
                                <input type="range" id="calc-db" min="10" max="2000" value="100" step="10" style="width: 100%; accent-color: var(--accent-color); position: relative; z-index: 10;">
                            </div>
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 8px;"><span>Object Storage (S3 - GB)</span> <span id="calc-s3-val" style="color:var(--accent-color); font-weight:bold; font-size: 1.1em;">500 GB</span></label>
                                <input type="range" id="calc-s3" min="50" max="10000" value="500" step="50" style="width: 100%; accent-color: var(--accent-color); position: relative; z-index: 10;">
                            </div>
                            @endif

                            <div style="margin-top: 20px; padding-top: 20px; border-top: 1px dashed rgba(255,255,255,0.1); text-align: center;">
                                <span style="color:var(--text-secondary); font-size: 1.1em;">Estimated Monthly Cost:</span>
                                <h2 style="color: #fff; font-size: 2.5em; margin: 10px 0;"><span style="color:var(--accent-color);">$</span><span id="calc-total">0</span> <span style="font-size:0.4em; color:#888;">/mo</span></h2>
                                <p style="font-size: 0.9em; color: #666; margin: 0;">*Estimates based on standard AWS pricing</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Tiers -->
            <div class="pricing-tiers">
                @foreach($pricingPackages as $package)
                <div class="tier {{ $package->is_featured ? 'featured' : '' }}">
                    <h4>{{ $package->name }}</h4>
                    <p>{{ $package->price }}</p>
                    @if(is_array($package->features) && count($package->features) > 0)
                    <ul>
                        @foreach($package->features as $feature)
                            <li>{{ $feature }}</li>
                        @endforeach
                    </ul>
                    @endif
                </div>
                @endforeach
                
                @if($pricingPackages->isEmpty())
                <div class="tier">
                    <h4>Basic</h4>
                    <p>$500</p>
                    <ul>
                        <li>Architecture Review</li>
                        <li>Basic CI/CD</li>
                    </ul>
                </div>
                <div class="tier featured">
                    <h4>Pro</h4>
                    <p>$1500</p>
                    <ul>
                        <li>Full Migration</li>
                        <li>Advanced Security</li>
                        <li>24/7 Support</li>
                    </ul>
                </div>
                <div class="tier">
                    <h4>Enterprise</h4>
                    <p>Custom</p>
                    <ul>
                        <li>Multi-Cloud</li>
                        <li>K8s Cluster</li>
                    </ul>
                </div>
                @endif
            </div>

            <!-- FAQ -->
            <div class="faq-container reveal-up delay-400">
                <h3 style="text-align: center; margin-bottom: 20px;" class="i18n"
                    data-en="Frequently Asked Questions" data-ar="الأسئلة الشائعة">Frequently Asked Questions</h3>
                <div class="faq-item">
                    <div class="faq-question"><span class="i18n" data-en="Do you work with startups?"
                            data-ar="هل تعملين مع الشركات الناشئة؟">Do you work with startups?</span> <span
                            style="color: var(--accent-color);">+</span></div>
                    <div class="faq-answer i18n"
                        data-en="Yes, I build infrastructure from scratch ensuring it's cost-effective and ready to scale as your startup grows."
                        data-ar="نعم، أقوم ببناء البنية التحتية من الصفر لضمان فعاليتها من حيث التكلفة وقابليتها للتوسع مع نمو شركتك.">
                        Yes, I build infrastructure from scratch ensuring it's cost-effective and ready to scale as your
                        startup grows.</div>
                </div>
                <div class="faq-item">
                    <div class="faq-question"><span class="i18n" data-en="Which Cloud Provider is the best?"
                            data-ar="ما هو أفضل مزود سحابي؟">Which Cloud Provider is the best?</span> <span
                            style="color: var(--accent-color);">+</span></div>
                    <div class="faq-answer i18n"
                        data-en="It depends on your business needs. AWS offers immense services, GCP is great for data, and Azure integrates well with MS ecosystems."
                        data-ar="يعتمد ذلك على احتياجات عملك. AWS تقدم خدمات ضخمة، GCP ممتاز للبيانات، و Azure يتكامل جيدًا مع أنظمة مايكروسوفت.">
                        It depends on your business needs. AWS offers immense services, GCP is great for data, and Azure
                        integrates well with MS ecosystems.</div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="section-projects" class="page-section">
            <h2 class="section-title i18n reveal-down" data-en="Latest Projects" data-ar="أحدث المشاريع">Latest
                Projects</h2>

            <div class="project-controls reveal-up"
                style="display: flex; gap: 15px; margin-bottom: 30px; justify-content: center; flex-wrap: wrap;">
                <input type="text" id="project-search" class="i18n-placeholder" data-en="Search projects..."
                    data-ar="ابحث عن مشروع..." placeholder="Search projects..." style="flex: 1; max-width: 300px;">
                <select id="project-filter" style="flex: 1; max-width: 200px;">
                    <option value="all">All Categories</option>
                    <option value="aws">AWS</option>
                    <option value="k8s">Kubernetes</option>
                    <option value="cicd">CI/CD</option>
                    <option value="security">Security</option>
                </select>
            </div>

            <div id="project-grid" class="grid-container">
                <!-- Projects will be injected here via JavaScript -->
            </div>

            <!-- Testimonials Section -->
            <div id="testimonials" class="testimonials-section" style="margin-top: 80px; margin-bottom: 40px;">
                <h2 class="section-title reveal-up i18n" data-en="Client & Colleague Testimonials"
                    data-ar="أراء العملاء وزملاء العمل" style="text-align: center;">Client & Colleague Testimonials
                </h2>

                <div style="text-align: center; margin-bottom: 30px;" class="reveal-up">
                    <button onclick="document.getElementById('testimonial-modal').style.display='flex'"
                        class="btn-primary" style="padding: 10px 20px; border-radius: 6px; font-size: 0.95em;">
                        <i class="fa-solid fa-pen-nib"></i> Leave a Testimonial
                    </button>
                </div>

                @if (!empty($testimonials) && $testimonials->count() > 0)
                    <style>
                        @keyframes scroll-left {
                            0% {
                                transform: translateX(0);
                            }

                            100% {
                                transform: translateX(-50%);
                            }
                        }

                        .marquee-track:hover {
                            animation-play-state: paused;
                        }
                    </style>
                    <div class="marquee-container reveal-up"
                        style="overflow: hidden; width: 100%; padding: 20px 0; position: relative; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px solid var(--border-color);">
                        <div class="marquee-track"
                            style="display: flex; width: max-content; animation: scroll-left 30s linear infinite;">
                            @foreach ($testimonials as $testi)
                                <div class="testimonial-card"
                                    style="width: 400px; max-width: 90vw; flex-shrink: 0; margin-right: 30px; background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(10px); padding: 35px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.05); text-align: left; position: relative; overflow: hidden; box-shadow: 0 10px 30px -15px rgba(0,0,0,0.5); transition: transform 0.3s, border-color 0.3s;">
                                    <div
                                        style="position: absolute; top: -20px; right: -20px; font-size: 8em; color: rgba(16, 185, 129, 0.03); transform: rotate(10deg);">
                                        <i class="fa-solid fa-quote-right"></i></div>
                                    <div
                                        style="display: flex; gap: 5px; color: #f59e0b; margin-bottom: 15px; font-size: 0.9em;">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i>
                                    </div>
                                    <p class="testimonial-text"
                                        style="font-style: italic; color: #e2e8f0; line-height: 1.7; margin-bottom: 25px; font-size: 1.05em; position: relative; z-index: 1;">
                                        "{{ $testi->feedback }}"</p>
                                    <div class="testimonial-author"
                                        style="display: flex; align-items: center; gap: 15px; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; position: relative; z-index: 1;">
                                        <div class="author-avatar"
                                            style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(59, 130, 246, 0.2)); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 50%; color: var(--accent-color); display: flex; align-items: center; justify-content: center; font-size: 1.2em;">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                        <div class="author-info" style="text-align: left;">
                                            <h4 style="color: #fff; margin: 0; font-size: 1.1em; font-weight: 600;">
                                                {{ $testi->name }}</h4>
                                            <p style="color: #94a3b8; font-size: 0.85em; margin: 3px 0 0 0;">
                                                {{ $testi->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Duplicate for infinite scroll loop -->
                            @foreach ($testimonials as $testi)
                                <div class="testimonial-card"
                                    style="width: 400px; max-width: 90vw; flex-shrink: 0; margin-right: 30px; background: rgba(30, 41, 59, 0.5); backdrop-filter: blur(10px); padding: 35px; border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.05); text-align: left; position: relative; overflow: hidden; box-shadow: 0 10px 30px -15px rgba(0,0,0,0.5); transition: transform 0.3s, border-color 0.3s;">
                                    <div
                                        style="position: absolute; top: -20px; right: -20px; font-size: 8em; color: rgba(16, 185, 129, 0.03); transform: rotate(10deg);">
                                        <i class="fa-solid fa-quote-right"></i></div>
                                    <div
                                        style="display: flex; gap: 5px; color: #f59e0b; margin-bottom: 15px; font-size: 0.9em;">
                                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                                            class="fa-solid fa-star"></i>
                                    </div>
                                    <p class="testimonial-text"
                                        style="font-style: italic; color: #e2e8f0; line-height: 1.7; margin-bottom: 25px; font-size: 1.05em; position: relative; z-index: 1;">
                                        "{{ $testi->feedback }}"</p>
                                    <div class="testimonial-author"
                                        style="display: flex; align-items: center; gap: 15px; border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 20px; position: relative; z-index: 1;">
                                        <div class="author-avatar"
                                            style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(16, 185, 129, 0.2), rgba(59, 130, 246, 0.2)); border: 1px solid rgba(16, 185, 129, 0.3); border-radius: 50%; color: var(--accent-color); display: flex; align-items: center; justify-content: center; font-size: 1.2em;">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                        <div class="author-info" style="text-align: left;">
                                            <h4 style="color: #fff; margin: 0; font-size: 1.1em; font-weight: 600;">
                                                {{ $testi->name }}</h4>
                                            <p style="color: #94a3b8; font-size: 0.85em; margin: 3px 0 0 0;">
                                                {{ $testi->role }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div style="text-align: center; color: #888; font-style: italic; margin-top: 20px;"
                        class="reveal-up">
                        Be the first to leave a testimonial!
                    </div>
                @endif
            </div>

            <!-- Add Testimonial Modal -->
            <div id="testimonial-modal" class="modal"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;"
                onclick="if(event.target === this) this.style.display='none'">
                <div class="modal-content"
                    style="background: var(--card-bg); max-width: 500px; width: 90%; position: relative; padding: 30px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
                    <span class="close-modal"
                        onclick="document.getElementById('testimonial-modal').style.display='none'"
                        style="position: absolute; top: 15px; right: 20px; font-size: 25px; cursor: pointer; color: #a1a1aa;">&times;</span>
                    <h3 style="color: var(--accent-color); margin-top: 0; margin-bottom: 20px;">Submit a Testimonial
                    </h3>
                    <form id="testimonial-form">
                        <div style="margin-bottom: 15px;">
                            <input type="text" id="test-name" required placeholder="Your Name"
                                style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: #fff; border-radius: 6px; outline: none;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <input type="text" id="test-role" required placeholder="Your Role / Company"
                                style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: #fff; border-radius: 6px; outline: none;">
                        </div>
                        <div style="margin-bottom: 15px;">
                            <label style="color: #a1a1aa; display: block; margin-bottom: 5px;">Your Rating:</label>
                            <div style="color: #f59e0b; font-size: 1.5em; cursor: pointer;" id="rating-stars">
                                <i class="fa-solid fa-star" onclick="setRating(1)"></i>
                                <i class="fa-solid fa-star" onclick="setRating(2)"></i>
                                <i class="fa-solid fa-star" onclick="setRating(3)"></i>
                                <i class="fa-solid fa-star" onclick="setRating(4)"></i>
                                <i class="fa-solid fa-star" onclick="setRating(5)"></i>
                            </div>
                            <input type="hidden" id="test-rating" value="5">
                        </div>
                        <script>
                            function setRating(val) {
                                document.getElementById('test-rating').value = val;
                                let stars = document.getElementById('rating-stars').children;
                                for (let i = 0; i < 5; i++) {
                                    if (i < val) {
                                        stars[i].classList.remove('fa-regular');
                                        stars[i].classList.add('fa-solid');
                                    } else {
                                        stars[i].classList.remove('fa-solid');
                                        stars[i].classList.add('fa-regular');
                                    }
                                }
                            }
                        </script>
                        <div style="margin-bottom: 20px;">
                            <textarea id="test-feedback" required placeholder="Your feedback..." rows="4"
                                style="width: 100%; padding: 12px; background: rgba(255,255,255,0.05); border: 1px solid var(--border-color); color: #fff; border-radius: 6px; outline: none;"></textarea>
                        </div>
                        <button type="submit" class="btn-primary"
                            style="width: 100%; padding: 12px; border-radius: 6px;">Submit Review</button>
                    </form>
                </div>
            </div>

            <!-- GitHub Graph -->
            <div class="github-graph reveal-up">
                <h3 style="margin-top: 0;">GitHub Contributions</h3>
                <img src="https://ghchart.rshah.org/10b981/emanryandev" alt="GitHub Contributions"
                    style="width: 100%; max-width: 800px; margin: 0 auto; display: block;">
            </div>

            <!-- Single Project Modal & Code Snippet Modal (Hidden) -->
            <div id="code-snippet-modal" class="modal" style="display: none;">
                <div class="modal-content" style="background: #1e1e1e; max-width: 800px;">
                    <span class="close-modal"
                        onclick="document.getElementById('code-snippet-modal').style.display='none'">&times;</span>
                    <h3 style="color: #58a6ff;">main.tf</h3>
                    <pre><code style="color: #d4d4d4;">module "eks" { source = "terraform-aws-modules/eks/aws" cluster_name = "production-cluster" }</code></pre>
                </div>
            </div>

            <!-- Architecture Diagram Modal -->
            <div id="arch-modal" class="modal"
                style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;"
                onclick="if(event.target === this) this.style.display='none'">
                <div class="modal-content"
                    style="background: var(--card-bg); max-width: 1300px; width: 95%; max-height: 90vh; overflow-y: auto; text-align: center; position: relative; border: 1px solid rgba(255,255,255,0.1); padding: 30px; border-radius: 12px; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);">
                    <span class="close-modal" onclick="document.getElementById('arch-modal').style.display='none'"
                        style="position: absolute; top: 15px; right: 20px; font-size: 30px; cursor: pointer; color: #a1a1aa; transition: color 0.2s;"
                        onmouseover="this.style.color='#ef4444'"
                        onmouseout="this.style.color='#a1a1aa'">&times;</span>
                    <h3 style="color: var(--accent-color); margin-top: 0; margin-bottom: 20px; font-size: 1.5em;"><i
                            class="fa-solid fa-sitemap"></i> <span>System Architecture</span></h3>
                    <div id="arch-diagram-container" style="border-radius: 8px; overflow-x: auto;">
                        <div id="arch-diagram"></div>
                    </div>
                </div>
            </div>

            <!-- Video Explainer Modal (Hidden) -->
            <div id="video-modal" class="modal" style="display: none;">
                <div class="modal-content"
                    style="background: var(--card-bg); max-width: 600px; text-align: center; position: relative; padding-bottom: 20px;">
                    <span class="close-modal" onclick="closeVideoModal()"
                        style="z-index: 20; position: absolute; right: 15px; top: 10px;">&times;</span>
                    <h3 style="margin-top: 0;">Service Explainer</h3>
                    <div
                        style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; background: #000;">
                        <!-- HTML5 Video Auto-playing in background -->
                        <video id="service-video"
                            style="position: absolute; top:0; left: 0; width: 100%; height: 100%; object-fit: cover;"
                            src="https://www.w3schools.com/html/mov_bbb.mp4" playsinline loop></video>
                        <!-- Custom Sound Toggle Button inside video -->
                        <button id="btn-video-sound" onclick="toggleVideoSound()"
                            style="position: absolute; bottom: 15px; right: 15px; background: rgba(0,0,0,0.7); color: #10b981; border: 1px solid rgba(16,185,129,0.5); padding: 10px 15px; border-radius: 30px; cursor: pointer; z-index: 10; font-size: 0.9em; backdrop-filter: blur(5px); transition: 0.3s; font-weight: bold;">
                            <i class="fa-solid fa-volume-high"></i> <span style="margin-left: 5px;">Sound ON</span>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="section-contact" class="page-section">
            <h2 class="section-title reveal-down">Contact Me</h2>
            <div class="contact-layout">
                <div class="contact-form-container reveal-left delay-100">

                    <!-- Voice Record -->
                    <div
                        style="margin-bottom: 20px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                        <p style="margin:0 0 10px 0;">Prefer talking? Send a Voice Message!</p>
                        <button id="btn-record-voice" type="button" class="btn-primary"
                            style="background:#ef4444; width:100%;"><i class="fa-solid fa-microphone"></i>
                            Record</button>
                        <audio id="voice-preview" controls style="display:none; width:100%; margin-top:10px;"></audio>
                    </div>

                    <h3 style="margin-top: 0;">Send a Message</h3>
                    <form id="contact-form" class="contact-form">
                        <input type="text" id="contact-name" placeholder="Name" required>
                        <input type="email" id="contact-email" placeholder="Email" required>

                        <select id="contact-subject" required>
                            <option value="" disabled selected>Select Subject</option>
                            <option value="General Inquiry">General Inquiry</option>
                            <option value="New Project">New Project</option>
                            <option value="Cloud Architecture">Cloud Architecture</option>
                            <option value="CI/CD Automation">CI/CD Automation</option>
                        </select>

                        <div id="budget-container" style="display: none; width: 100%;">
                            <input type="text" id="contact-budget" placeholder="Estimated Budget ($)"
                                style="margin-bottom: 0;">
                        </div>

                        <textarea id="contact-message" rows="5" placeholder="Your Message" required></textarea>
                        <button type="submit" id="btn-submit-contact" class="btn-primary">Send Message</button>
                    </form>

                    <!-- Newsletter -->
                    <form id="newsletter-form" class="newsletter-box">
                        <h4>Subscribe to DevOps Tips</h4>
                        <input type="email" required placeholder="Your Email"
                            style="width:70%; padding:10px; border-radius:4px; border:1px solid var(--border-color); outline:none; background: rgba(255,255,255,0.05); color: #fff;">
                        <button type="submit" class="btn-primary"
                            style="padding:10px; border-radius:4px; font-size:0.9em;">Join</button>
                    </form>
                </div>
                <div class="calendly-container reveal-right delay-200">
                    <!-- Embedded Map -->
                    <div class="map-container"
                        style="height: 250px; border-radius: 8px; overflow: hidden; margin-bottom: 20px; border: 1px solid var(--border-color);">
                        <?php $mapUrl = !empty($siteSettings['map_url']) ? $siteSettings['map_url'] : 'https://www.openstreetmap.org/export/embed.html?bbox=-0.14%2C51.5%2C-0.12%2C51.52&amp;layer=mapnik'; ?>
                        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0"
                            marginwidth="0" src="<?= htmlspecialchars($mapUrl) ?>"
                            style="filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(85%);"></iframe>
                    </div>

                    <!-- Direct Contact Info Instead of Calendly -->
                    <div style="display: flex; flex-direction: column; gap: 15px;">
                        <a href="mailto:{{ $vEmail }}"
                            style="display: flex; align-items: center; gap: 15px; padding: 20px; background: rgba(16,185,129,0.05); border: 1px solid rgba(16,185,129,0.2); border-radius: 8px; text-decoration: none; color: inherit; transition: all 0.3s;"
                            onmouseover="this.style.background='rgba(16,185,129,0.1)'"
                            onmouseout="this.style.background='rgba(16,185,129,0.05)'">
                            <i class="fa-solid fa-envelope" style="font-size: 2em; color: #10b981;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1em; color: #e2e8f0;">Email Me</strong>
                                <span style="color: #94a3b8;">{{ $vEmail }}</span>
                            </div>
                        </a>

                        <a href="https://wa.me/{{ $cleanWaNumber }}" target="_blank"
                            style="display: flex; align-items: center; gap: 15px; padding: 20px; background: rgba(37,211,102,0.05); border: 1px solid rgba(37,211,102,0.2); border-radius: 8px; text-decoration: none; color: inherit; transition: all 0.3s;"
                            onmouseover="this.style.background='rgba(37,211,102,0.1)'"
                            onmouseout="this.style.background='rgba(37,211,102,0.05)'">
                            <i class="fa-brands fa-whatsapp" style="font-size: 2em; color: #25D366;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1em; color: #e2e8f0;">WhatsApp</strong>
                                <span style="color: #94a3b8;">{{ $vPhone }}</span>
                            </div>
                        </a>

                        <a href="{{ $vLink }}" target="_blank"
                            style="display: flex; align-items: center; gap: 15px; padding: 20px; background: rgba(10,102,194,0.05); border: 1px solid rgba(10,102,194,0.2); border-radius: 8px; text-decoration: none; color: inherit; transition: all 0.3s;"
                            onmouseover="this.style.background='rgba(10,102,194,0.1)'"
                            onmouseout="this.style.background='rgba(10,102,194,0.05)'">
                            <i class="fa-brands fa-linkedin" style="font-size: 2em; color: #0a66c2;"></i>
                            <div>
                                <strong style="display: block; font-size: 1.1em; color: #e2e8f0;">LinkedIn</strong>
                                <span style="color: #94a3b8;">Connect with me</span>
                            </div>
                        </a>
                    </div>
                </div>
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
                <span class="prompt" dir="ltr">visitor@cloud:~$</span>
                <input type="text" id="terminal-input" autocomplete="off" spellcheck="false" dir="ltr">
            </div>
        </div>
    </div>

    <!-- Infrastructure Health Widget -->
    <div id="infra-widget" class="widget-container">
        <div class="widget-header">System Status</div>
        <div class="widget-body">
            <div class="metric">
                <span>API Latency:</span> <span id="metric-latency" class="value ok" dir="ltr">12ms</span>
            </div>
            <div class="metric">
                <span>Uptime:</span> <span id="metric-uptime" class="value" dir="ltr">99.99%</span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js" integrity="sha384-qzrow8+R9k2/XKVt7fpdI3hp6ocDhtrCzBsdbcw7/VRkwEXYcsTTAEeFvhlgiGBW" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js" integrity="sha384-jb8JQMbMoBUzgWatfe6COACi2ljcDdZQ2OxczGA3bGNeWe+6DChMTBJemed7ZnvJ" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js" integrity="sha384-T/0lMUdJpd2S1ZHtRiofG3htU3xPCrFVeAQ1UUE2TJwlEJSV5NUwn30kP28n238E" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" integrity="sha384-CI3ELBVUz9XQO+97x6nwMDPosPR5XvsxW2ua7N1Xeygeh1IxtgqtCkGfQY9WWdHu" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.8.0/vanilla-tilt.min.js" integrity="sha512-RX/OFugIGpqouq136mZQ4Z8Jv6OghyD80nS5a1gq9L/nS/wV/G13R0F9q16a/6uB1fP98hM1N8P6aXF3P0A24A==" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js" integrity="sha256-11fG8E7k4eI0iP5z96Bw+1M84/w5a443a6wZtK/65jE=" crossorigin="anonymous"></script>

    <!-- تمرير بيانات الرادار إلى الجافاسكريبت -->
    <script>
        window.radarData = {!! json_encode($radarSkills) !!};
    </script>

    <script src="/assets/js/main.js?v={{ time() }}"></script>
    <script src="/assets/js/terminal-ui.js"></script>
    <script src="/assets/js/mock-server.js"></script>

    <!-- Hamburger Menu & Mobile Navigation JS -->
    <script>
    (function() {
        const hamburgerBtn  = document.getElementById('hamburger-btn');
        const mobileMenu    = document.getElementById('mobile-menu');
        const overlay       = document.getElementById('mobile-menu-overlay');
        const closeBtn      = document.getElementById('mobile-menu-close');
        const mobileNavBtns = document.querySelectorAll('.mobile-nav-btn');

        function openMenu() {
            hamburgerBtn.classList.add('open');
            hamburgerBtn.setAttribute('aria-expanded', 'true');
            mobileMenu.classList.add('open');
            mobileMenu.setAttribute('aria-hidden', 'false');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeMenu() {
            hamburgerBtn.classList.remove('open');
            hamburgerBtn.setAttribute('aria-expanded', 'false');
            mobileMenu.classList.remove('open');
            mobileMenu.setAttribute('aria-hidden', 'true');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (hamburgerBtn) hamburgerBtn.addEventListener('click', openMenu);
        if (closeBtn) closeBtn.addEventListener('click', closeMenu);
        if (overlay) overlay.addEventListener('click', closeMenu);

        // Close menu when a nav item is clicked and switch section
        mobileNavBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.dataset.target;

                // Reuse existing desktop nav logic if present
                const desktopBtn = document.querySelector(`.nav-btn[data-target="${target}"]`);
                if (desktopBtn) {
                    desktopBtn.click();
                } else {
                    // Fallback: directly switch sections
                    document.querySelectorAll('.page-section').forEach(s => s.classList.remove('active'));
                    const section = document.getElementById(target);
                    if (section) section.classList.add('active');
                }

                // Update active state in mobile menu
                mobileNavBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                closeMenu();
            });
        });

        // Sync mobile active state with desktop nav clicks
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const target = this.dataset.target;
                mobileNavBtns.forEach(b => {
                    b.classList.toggle('active', b.dataset.target === target);
                });
            });
        });

        // Close menu on Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeMenu();
        });

        // Disable Cursor Glow on touch devices
        if ('ontouchstart' in window || navigator.maxTouchPoints > 0) {
            const cursorGlow = document.getElementById('cursor-glow');
            if (cursorGlow) cursorGlow.style.display = 'none';
        }
    })();
    </script>
</body>

</html>
