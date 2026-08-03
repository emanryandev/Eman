let allProjects = [];

// إعداد المؤثر الصوتي عند تمرير الماوس (Hover)
const hoverSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2571/2571-preview.mp3');
hoverSound.volume = 0.15; // جعل الصوت هادئاً وغير مزعج
window.playHoverSound = () => {
    hoverSound.currentTime = 0; // إعادة الصوت للبداية ليعمل مع كل تمريرة
    hoverSound.play().catch(e => {}); // تجاهل الخطأ إذا كان المتصفح يمنع الصوت قبل تفاعل المستخدم
};

document.addEventListener('DOMContentLoaded', () => {
    fetchProjects();
    setupMainNav();
    setupContactForm();
    initTypingEffect();
    initScrollAnimations();
    initParticles();
    setupFAQ();
    initMicroInteractions();
    setupSmartGreeting();
    initRadarChart();
    setupCopyClipboard();
    setupProjectFilters();
    initThreeJS();
    initMiniTerminal();
    initAudioToggle();
    fetchGitHubStats();
    initBeforeAfter();
    initVoiceRecord();
    initTestimonialSlider();
    initHeaderScroll();
    initSmoothScrolling();
    setupNewsletterForm();
    setupTestimonialForm();
});

async function fetchProjects() {
    try {
        const response = await fetch('/api/projects');
        const rawProjects = await response.json();
        // Filter out Drafts for normal visitors
        allProjects = rawProjects.filter(p => !p.status || p.status === 'published');
        window.portfolioProjects = allProjects; // For Terminal Output
        
        renderProjects();
    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}

function renderProjects(projectsToRender = allProjects) {
    const grid = document.getElementById('project-grid');
    grid.innerHTML = '';
    
    const isMarquee = projectsToRender.length > 3;
    let displayProjects = [...projectsToRender];
    
    if (isMarquee) {
        displayProjects.sort((a, b) => new Date(b.created_at || 0) - new Date(a.created_at || 0));
        
        grid.className = 'marquee-container';
        grid.style.cssText = 'overflow: hidden; width: 100%; position: relative; padding: 20px 0; background: transparent; border-radius: 12px; cursor: grab; display: flex;';
        
        const track = document.createElement('div');
        track.className = 'marquee-track';
        track.style.cssText = 'display: flex; width: max-content; gap: 30px;';
        
        grid.appendChild(track);
        
        // Duplicate for infinite loop
        displayProjects = [...displayProjects, ...displayProjects];

        // Drag to Scroll & Auto-Scroll Logic
        let isDown = false;
        let isDragging = false;
        let startX;
        let scrollLeft;
        const speed = 0.8; // Adjust auto-scroll speed

        const loop = () => {
            if (!isDown) {
                grid.scrollLeft += speed;
                if (grid.scrollLeft >= track.scrollWidth / 2) {
                    grid.scrollLeft = 0;
                }
            }
            requestAnimationFrame(loop);
        };
        requestAnimationFrame(loop);

        grid.addEventListener('mousedown', (e) => {
            isDown = true;
            isDragging = false;
            grid.style.cursor = 'grabbing';
            startX = e.pageX - grid.offsetLeft;
            scrollLeft = grid.scrollLeft;
        });

        grid.addEventListener('mouseleave', () => {
            if(isDown) {
                isDown = false;
                grid.style.cursor = 'grab';
            }
        });

        grid.addEventListener('mouseup', () => {
            isDown = false;
            grid.style.cursor = 'grab';
        });

        grid.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            isDragging = true;
            const x = e.pageX - grid.offsetLeft;
            const walk = (x - startX) * 1.5;
            grid.scrollLeft = scrollLeft - walk;
            
            if (grid.scrollLeft >= track.scrollWidth / 2) {
                grid.scrollLeft -= track.scrollWidth / 2;
                startX = e.pageX - grid.offsetLeft;
                scrollLeft = grid.scrollLeft;
            } else if (grid.scrollLeft <= 0) {
                grid.scrollLeft += track.scrollWidth / 2;
                startX = e.pageX - grid.offsetLeft;
                scrollLeft = grid.scrollLeft;
            }
        });

        // Prevent accidental clicks on buttons/links when dragging
        grid.addEventListener('click', (e) => {
            if (isDragging) {
                e.preventDefault();
                e.stopPropagation();
            }
        }, true);

    } else {
        grid.className = 'grid-container';
        grid.style.cssText = '';
    }

    const repoText = 'Repo';
    const liveText = 'Live Demo';

    displayProjects.forEach((project, index) => {
            const card = document.createElement('div');
            const defaultHover = index % 2 === 0 ? 'terminal-glow' : 'matrix-cascade';
            
            const uiConfig = project.ui_config || {
                enter_animation: 'fade-in-up',
                hover_effect: defaultHover,
                duration_ms: 800,
                delay_ms: (index % 3) * 150 // staggered delay based on column
            };

            card.className = `project-card ${uiConfig.hover_effect}`;
            
            if (isMarquee) {
                card.style.cssText = 'width: 400px; max-width: 90vw; flex-shrink: 0; opacity: 1;';
            } else {
                card.classList.add('reveal-dynamic');
                card.style.opacity = '0';
                card.style.animationFillMode = 'both';
                card.dataset.animName = uiConfig.enter_animation === 'fade-in-up' ? 'fadeInUp' : 'glitchReveal';
                card.dataset.animDuration = `${uiConfig.duration_ms}ms`;
                card.dataset.animDelay = `${uiConfig.delay_ms}ms`;
            }

            function getTechIcon(tech) {
                const t = tech.toLowerCase();
                if(t.includes('aws') || t.includes('amazon')) return '<i class="fa-brands fa-aws" style="color: #ff9900;"></i>';
                if(t.includes('docker')) return '<i class="fa-brands fa-docker" style="color: #2496ed;"></i>';
                if(t.includes('kubernetes') || t.includes('k8s')) return '<i class="fa-solid fa-dharmachakra" style="color: #326ce5;"></i>';
                if(t.includes('terraform')) return '<i class="fa-solid fa-cubes" style="color: #844FBA;"></i>';
                if(t.includes('jenkins')) return '<i class="fa-brands fa-jenkins" style="color: #D33833;"></i>';
                if(t.includes('git')) return '<i class="fa-brands fa-git-alt" style="color: #F1502F;"></i>';
                if(t.includes('linux') || t.includes('bash')) return '<i class="fa-brands fa-linux"></i>';
                if(t.includes('python')) return '<i class="fa-brands fa-python" style="color: #3776ab;"></i>';
                if(t.includes('node')) return '<i class="fa-brands fa-node-js" style="color: #68a063;"></i>';
                return '<i class="fa-solid fa-bolt" style="color: var(--accent-color);"></i>';
            }

            // Create Badges for Tech Stack
            const techStackHtml = project.tech_stack ? project.tech_stack.map(tech => `<span class="tech-badge">${getTechIcon(tech)} ${tech}</span>`).join('') : '';

            const imageHtml = project.image_url 
                ? `<div class="project-img-slider" style="height: 180px; overflow: hidden;"><img src="${project.image_url}" alt="${project.title}" class="project-thumbnail" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s;"></div>` 
                : `<div class="project-thumbnail" style="height: 180px; background: linear-gradient(135deg, #1e293b, #0f172a); display: flex; align-items: center; justify-content: center; color: rgba(255,255,255,0.03); font-size: 6em; transition: transform 0.5s;"><i class="fa-solid fa-server"></i></div>`;

            // Project Extras
            const stars = project.stars || 0; 
            const claps = project.claps || 0; 
            const projectId = project.id;

            const isClapped = localStorage.getItem(`clapped_${projectId}`) === 'true';
            const isStarred = localStorage.getItem(`starred_${projectId}`) === 'true';
            const clapColor = isClapped ? '#10b981' : '#64748b';
            const starColor = isStarred ? '#10b981' : '#f59e0b';
            const starBg = isStarred ? 'rgba(16,185,129,0.1)' : 'rgba(245,158,11,0.1)';

            // Badges & Buttons
            const ciBadgeHtml = project.github_actions_status ? `<div style="position: absolute; top: 10px; right: 10px; background: rgba(15,23,42,0.8); backdrop-filter: blur(4px); padding: 4px 8px; border-radius: 4px; border: 1px solid rgba(255,255,255,0.1); z-index: 2;"><img src="${project.github_actions_status}" alt="CI/CD" style="height: 18px; display: block;"></div>` : '';
            const archBtn = (project.architecture_diagram || project.architecture_image_url) ? `<button onclick="showArchitecture('${projectId}')" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b; border: 1px solid rgba(245, 158, 11, 0.2); padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8em; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; gap: 5px;" onmouseover="this.style.background='rgba(245, 158, 11, 0.2)'" onmouseout="this.style.background='rgba(245, 158, 11, 0.1)'" title="Architecture Diagram"><i class="fa-solid fa-sitemap"></i> Arch</button>` : '';
            const videoBtn = project.video_url ? `<button onclick="showVideo('${projectId}')" style="background: rgba(239, 68, 68, 0.1); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); padding: 6px 12px; border-radius: 4px; cursor: pointer; font-size: 0.8em; transition: all 0.2s; font-family: inherit; display: flex; align-items: center; gap: 5px;" onmouseover="this.style.background='rgba(239, 68, 68, 0.2)'" onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'" title="Demo Video"><i class="fa-solid fa-play"></i> Video</button>` : '';

            card.innerHTML = `
                <div style="position: relative; overflow: hidden; border-radius: 8px 8px 0 0;">
                    ${imageHtml}
                    ${ciBadgeHtml}
                </div>
                <div class="project-card-content" style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1; background: transparent;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                        <h3 style="margin: 0; font-size: 1.25em; color: #e2e8f0; font-weight: 700;">${project.title}</h3>
                        <div onclick="addStar('${projectId}', this)" style="display: flex; align-items: center; gap: 4px; font-size: 0.75em; color: ${starColor}; background: ${starBg}; padding: 2px 6px; border-radius: 4px; border: 1px solid ${starBg}; cursor: pointer; transition: all 0.2s; user-select: none;">
                            <i class="fa-solid fa-star"></i> <span>${stars}</span>
                        </div>
                    </div>
                    
                    <div style="color: var(--accent-color); font-size: 0.8em; margin-bottom: 12px; font-weight: 500;"><i class="fa-solid fa-terminal" style="margin-right: 5px; opacity: 0.7;"></i>${project.role}</div>
                    
                    <p style="flex-grow: 1; line-height: 1.5; color: #94a3b8; font-size: 0.9em; margin-bottom: 15px;">${project.description}</p>
                    
                    <div class="tech-stack" style="margin-bottom: 15px; display: flex; flex-wrap: wrap; gap: 6px;">${techStackHtml}</div>
                    
                    <!-- Buttons / Actions -->
                    <div style="display: flex; gap: 8px; flex-wrap: wrap; margin-top: auto; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 15px;">
                        <a href="${project.repository_url}" target="_blank" style="background: rgba(255, 255, 255, 0.05); color: #cbd5e1; border: 1px solid rgba(255, 255, 255, 0.1); padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.8em; transition: all 0.2s; display: flex; align-items: center; gap: 5px;" onmouseover="this.style.background='rgba(255, 255, 255, 0.1)'" onmouseout="this.style.background='rgba(255, 255, 255, 0.05)'"><i class="fa-brands fa-github"></i> ${repoText}</a>
                        
                        <a href="${project.live_url}" target="_blank" style="background: rgba(16, 185, 129, 0.1); color: #10b981; border: 1px solid rgba(16, 185, 129, 0.2); padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.8em; transition: all 0.2s; display: flex; align-items: center; gap: 5px;" onmouseover="this.style.background='rgba(16, 185, 129, 0.2)'" onmouseout="this.style.background='rgba(16, 185, 129, 0.1)'"><i class="fa-solid fa-arrow-up-right-from-square"></i> ${liveText}</a>
                        
                        ${archBtn}
                        ${videoBtn}
                        
                        <button onclick="addClap('${projectId}', this)" style="margin-left: auto; background: transparent; border: none; cursor: pointer; color: ${clapColor}; font-size: 0.9em; transition: all 0.2s; display: flex; align-items: center; gap: 5px;" title="Clap for this project"><i class="fa-solid fa-hands-clapping"></i> <span>${claps}</span></button>
                    </div>
                </div>
            `;
            
            if (isMarquee) {
                grid.querySelector('.marquee-track').appendChild(card);
            } else {
                grid.appendChild(card);
                if (window.scrollObserver) window.scrollObserver.observe(card);
            }
            
            // Initialize 3D Tilt Effect
            if(typeof VanillaTilt !== 'undefined') {
                VanillaTilt.init(card, { max: 10, speed: 400, glare: true, "max-glare": 0.1, scale: 1.02 });
            }
        });
}

// --- Live Database Claps & Stars Function ---
window.addClap = async function(projectId, btn) {
    const span = btn.querySelector('span');
    const storageKey = `clapped_${projectId}`;
    const isClapped = localStorage.getItem(storageKey) === 'true';
    
    // Toggle state
    if (isClapped) {
        span.innerText = Math.max(0, parseInt(span.innerText) - 1);
        btn.style.color = '#64748b';
        localStorage.removeItem(storageKey);
    } else {
        span.innerText = parseInt(span.innerText) + 1;
        btn.style.color = '#10b981';
        localStorage.setItem(storageKey, 'true');
    }

    try {
        await fetch(`/api/projects/${projectId}/clap`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: isClapped ? 'remove' : 'add' })
        });
    } catch (e) { console.error('Failed to save clap', e); }
}

window.addStar = async function(projectId, btn) {
    const span = btn.querySelector('span');
    const storageKey = `starred_${projectId}`;
    const isStarred = localStorage.getItem(storageKey) === 'true';
    
    // Toggle state
    if (isStarred) {
        span.innerText = Math.max(0, parseInt(span.innerText) - 1);
        btn.style.color = '#f59e0b';
        btn.style.background = 'rgba(245,158,11,0.1)';
        btn.style.borderColor = 'rgba(245,158,11,0.1)';
        localStorage.removeItem(storageKey);
    } else {
        span.innerText = parseInt(span.innerText) + 1;
        btn.style.color = '#10b981';
        btn.style.background = 'rgba(16,185,129,0.1)';
        btn.style.borderColor = 'rgba(16,185,129,0.1)';
        localStorage.setItem(storageKey, 'true');
    }

    try {
        await fetch(`/api/projects/${projectId}/star`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: isStarred ? 'remove' : 'add' })
        });
    } catch (e) { console.error('Failed to save star', e); }
}

function setupMainNav() {
    const navBtns = document.querySelectorAll('.nav-btn');
    const sections = document.querySelectorAll('.page-section');
    
    navBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            navBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const target = btn.dataset.target;
            sections.forEach(sec => {
                if(sec.id === target) {
                    sec.classList.add('active');
                } else {
                    sec.classList.remove('active');
                }
            });
        });
    });
}

function initMicroInteractions() {
    // 1. Cursor Glow Follower
    const glow = document.getElementById('cursor-glow');
    if (glow) {
        window.addEventListener('mousemove', (e) => {
            // استخدام requestAnimationFrame لضمان أداء سلس جداً (60 فريم)
            requestAnimationFrame(() => {
                glow.style.left = `${e.clientX}px`;
                glow.style.top = `${e.clientY}px`;
            });
        });
    }

    // 2. Scroll Progress Bar
    window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const progressBar = document.getElementById('scroll-progress');
        if(progressBar) progressBar.style.width = scrolled + "%";
    });

    // FAQ Progress
    const faqs = document.querySelectorAll('.faq-item');
    faqs.forEach(q => {
        q.addEventListener('click', () => {
            let openFaqs = document.querySelectorAll('.faq-item.active').length;
            document.getElementById('faq-progress').style.width = (openFaqs / faqs.length) * 100 + "%";
        });
    });
}

function setupContactForm() {
    const form = document.getElementById('contact-form');
    if (!form) return;

    const subjectEl = document.getElementById('contact-subject');
    const budgetContainer = document.getElementById('budget-container');
    
    if (subjectEl) {
        subjectEl.addEventListener('change', () => {
            if (subjectEl.value === 'New Project') {
                budgetContainer.style.display = 'block';
            } else {
                budgetContainer.style.display = 'none';
            }
        });
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button');
        // Rocket animation for submission
        btn.innerHTML = '<i class="fa-solid fa-rocket"></i> Sending...';
        btn.disabled = true;

        let finalMessage = document.getElementById('contact-message').value;
        const subjectVal = subjectEl ? subjectEl.value : '';
        const budgetVal = document.getElementById('contact-budget') ? document.getElementById('contact-budget').value : '';
        
        if (subjectVal) finalMessage = `[Subject: ${subjectVal}]\n` + finalMessage;
        if (budgetVal && subjectVal === 'New Project') finalMessage = `[Budget: ${budgetVal}]\n` + finalMessage;

        try {
            const formData = new FormData();
            formData.append('name', document.getElementById('contact-name').value);
            formData.append('email', document.getElementById('contact-email').value);
            formData.append('message', finalMessage);
            if (window.recordedVoiceBlob) {
                formData.append('voice', window.recordedVoiceBlob, 'voice_message.webm');
            }

            const response = await fetch('/api/contact', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();
            
            if (result.success === true) {
                form.reset();
                window.recordedVoiceBlob = null;
                const preview = document.getElementById('voice-preview');
                if (preview) { preview.src = ''; preview.style.display = 'none'; }
                if (budgetContainer) budgetContainer.style.display = 'none';
                if (typeof confetti !== 'undefined') {
                    confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 }, colors: ['#10b981', '#3b82f6'] });
                }
                setTimeout(() => showToast('Message sent successfully!', 'success'), 500);
            } else {
                showToast('An error occurred.', 'error');
            }
        } catch (error) {
            showToast('Connection error, please try again.', 'error');
        } finally {
            btn.innerHTML = btn.getAttribute('data-en') || 'Send Message';
            btn.disabled = false;
        }
    });
}

function setupSmartGreeting() {
    const el = document.getElementById('smart-greeting');
    if (!el) return;
    const hour = new Date().getHours();
    let greetingEn;
    if (hour < 12) { greetingEn = "Good Morning!"; }
    else if (hour < 18) { greetingEn = "Good Afternoon!"; }
    else { greetingEn = "Good Evening!"; }
    
    el.setAttribute('data-en', greetingEn);
    el.innerText = greetingEn;
}

function initRadarChart() {
    const ctx = document.getElementById('skillsRadarChart');
    if(!ctx) return;
    if(typeof Chart === 'undefined') return;

    // جلب البيانات من المتغير العام الذي طبعناه في HTML
    const rData = window.radarData || [];
    const labels = rData.map(item => item.name);
    const values = rData.map(item => item.percent);

    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Skill Level',
                data: values,
                backgroundColor: 'rgba(16, 185, 129, 0.2)',
                borderColor: '#10b981',
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#10b981'
            }]
        },
        options: {
            scales: {
                r: {
                    angleLines: { color: 'rgba(255, 255, 255, 0.1)' },
                    grid: { color: 'rgba(255, 255, 255, 0.1)' },
                    pointLabels: { color: '#94a3b8', font: { size: 12 } },
                    ticks: { display: false, min: 0, max: 100 }
                }
            },
            plugins: { legend: { display: false } }
        }
    });
}

function setupCopyClipboard() {
    document.querySelectorAll('.copy-item').forEach(item => {
        item.style.cursor = 'pointer';
        item.addEventListener('click', () => {
            const text = item.getAttribute('data-clipboard');
            navigator.clipboard.writeText(text).then(() => {
                const icon = item.querySelector('.copy-icon');
                if(icon) {
                    icon.classList.remove('fa-copy', 'fa-regular');
                    icon.classList.add('fa-check', 'fa-solid');
                    icon.style.color = '#10b981';
                    setTimeout(() => {
                        icon.classList.remove('fa-check', 'fa-solid');
                        icon.classList.add('fa-copy', 'fa-regular');
                        icon.style.color = '';
                    }, 2000);
                }
            });
        });
    });
}

function setupProjectFilters() {
    const searchInput = document.getElementById('project-search');
    const filterSelect = document.getElementById('project-filter');
    
    if(!searchInput || !filterSelect) return;

    const filterFn = () => {
        const term = searchInput.value.toLowerCase();
        const cat = filterSelect.value.toLowerCase();
        
        const filtered = allProjects.filter(p => {
            // حماية من الأخطاء في حال كان الحقل غير موجود في قاعدة البيانات
            const title = (p.title || '').toLowerCase();
            const desc = (p.description || '').toLowerCase();
            const category = (p.category || '').toLowerCase();
            
            // البحث في العنوان، الوصف، أو قائمة التقنيات
            const matchesSearch = title.includes(term) || desc.includes(term) || (p.tech_stack && p.tech_stack.some(t => t.toLowerCase().includes(term)));
            const matchesCat = cat === 'all' || category === cat;
            return matchesSearch && matchesCat;
        });
        renderProjects(filtered);
        
        // إظهار واجهة "لا توجد نتائج" إذا كان الفلتر فارغاً
        const grid = document.getElementById('project-grid');
        if (filtered.length === 0) {
            const noResultsText = 'No projects found matching your criteria.';
            grid.innerHTML = `
                <div style="grid-column: 1 / -1; text-align: center; padding: 50px; color: #94a3b8; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed var(--border-color);">
                    <i class="fa-solid fa-folder-open" style="font-size: 3em; margin-bottom: 15px; color: var(--border-color);"></i>
                    <p style="font-size: 1.1em; font-weight: bold;">${noResultsText}</p>
                </div>
            `;
        }
    };

    searchInput.addEventListener('input', filterFn);
    filterSelect.addEventListener('change', filterFn);
}

function initTypingEffect() {
    const typeEl = document.getElementById('typewriter-text');
    if (typeEl) {
        const fullText = typeEl.getAttribute('data-en');
        typeEl.parentElement.setAttribute('data-text', fullText);
        typeEl.innerHTML = '';
        clearTimeout(window.typingTimeout);
        let i = 0;
        
        const typeSound = new Audio('https://assets.mixkit.co/active_storage/sfx/2568/2568-preview.mp3'); 
        
        const type = () => {
            if (i < fullText.length) {
                typeEl.innerHTML += fullText.charAt(i);
                
                let clickSound = typeSound.cloneNode();
                clickSound.volume = 0.15; 
                clickSound.play().catch(e => {}); 
                
                i++;
                window.typingTimeout = setTimeout(type, 50); 
            }
        };
        setTimeout(type, 4600); // Wait for preloader to fully fade out (3800 + 800)
    }
}

function initScrollAnimations() {
    const observerOptions = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };

    window.scrollObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                if (entry.target.classList.contains('reveal-dynamic')) {
                    entry.target.style.animationName = entry.target.dataset.animName;
                    entry.target.style.animationDuration = entry.target.dataset.animDuration;
                    entry.target.style.animationDelay = entry.target.dataset.animDelay;
                }
                
                // Trigger Counters
                if (entry.target.classList.contains('counter') && !entry.target.classList.contains('counted')) {
                    entry.target.classList.add('counted');
                    let count = 0;
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    const interval = setInterval(() => {
                        count += Math.ceil(target / 50) || 1;
                        if (count >= target) { count = target; clearInterval(interval); }
                        entry.target.innerText = count;
                    }, 30);
                }

                // Trigger Skill Bars
                if (entry.target.classList.contains('skill-fill')) {
                    entry.target.style.width = entry.target.getAttribute('data-width');
                }
            } else {
                entry.target.classList.remove('active');
                if (entry.target.classList.contains('reveal-dynamic')) {
                    entry.target.style.animationName = 'none';
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal-up, .reveal-down, .reveal-left, .reveal-right, .reveal-zoom, .counter, .skill-fill').forEach(el => {
        window.scrollObserver.observe(el);
    });
}

function initParticles() {
    if(document.getElementById('particles-js')) {
        particlesJS("particles-js", {
            "particles": {
                "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
                "color": { "value": "#10b981" },
                "shape": { "type": "circle" },
                "opacity": { "value": 0.5, "random": false },
                "size": { "value": 3, "random": true },
                "line_linked": { "enable": true, "distance": 150, "color": "#10b981", "opacity": 0.2, "width": 1 },
                "move": { "enable": true, "speed": 2, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": true, "mode": "push" }, "resize": true },
                "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 1 } }, "push": { "particles_nb": 4 } }
            },
            "retina_detect": true
        });
    }
}

function setupFAQ() {
    document.querySelectorAll('.faq-question').forEach(q => {
        q.addEventListener('click', () => {
            const parent = q.parentElement;
            parent.classList.toggle('active');
            q.querySelector('span:last-child').innerText = parent.classList.contains('active') ? '-' : '+';
        });
    });
}

// --- New Advanced Features ---

function initThreeJS() {
    if(typeof THREE === 'undefined') return;
    const container = document.getElementById('three-container');
    if(!container) return;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({alpha:true});
    renderer.setSize(window.innerWidth, window.innerHeight);
    container.appendChild(renderer.domElement);
    const geometry = new THREE.BoxGeometry(2, 2, 2);
    const edges = new THREE.EdgesGeometry(geometry);
    const material = new THREE.LineBasicMaterial({color: 0x10b981});
    const cube = new THREE.LineSegments(edges, material);
    scene.add(cube);
    camera.position.z = 5;
    function animate() {
        requestAnimationFrame(animate);
        cube.rotation.x += 0.005;
        cube.rotation.y += 0.005;
        renderer.render(scene, camera);
    }
    animate();
    window.addEventListener('resize', () => { renderer.setSize(window.innerWidth, window.innerHeight); camera.aspect = window.innerWidth/window.innerHeight; camera.updateProjectionMatrix();});
}

function initMiniTerminal() {
    const mt = document.getElementById('mt-body');
    if(!mt) return;
    const cmds = ["docker ps", "kubectl get pods", "terraform apply", "ping aws.com", "tail -f /var/log/syslog"];
    setInterval(() => {
        const cmd = cmds[Math.floor(Math.random() * cmds.length)];
        mt.innerHTML += `<div>> ${cmd}... [OK]</div>`;
        mt.scrollTop = mt.scrollHeight;
    }, 2500);
}

function initAudioToggle() {
    const audio = document.getElementById('bg-audio');
    const btn = document.getElementById('btn-audio-toggle');
    if(btn && audio) {
        btn.addEventListener('click', () => {
            if(audio.paused) { audio.play(); btn.innerHTML = '<i class="fa-solid fa-volume-high"></i>'; }
            else { audio.pause(); btn.innerHTML = '<i class="fa-solid fa-volume-xmark"></i>'; }
        });
    }
}

async function fetchGitHubStats() {
    const el = document.getElementById('gh-commits-count');
    if(el) {
        try {
            // استدعاء حقيقي لواجهة برمجة جيت هاب (يجب تغيير eman-devops لاسم حسابك الحقيقي)
            const response = await fetch('https://api.github.com/users/emanryandev');
            const data = await response.json();
            if(data.public_repos !== undefined) {
                el.innerText = `${data.public_repos} Repos / ${data.followers} Followers`; 
            }
        } catch (e) {
            el.innerText = "Unavailable";
        }
    }
}

function initBeforeAfter() {
    const slider = document.getElementById('ba-slider');
    const before = document.querySelector('.before-layer');
    if(slider && before) {
        slider.addEventListener('input', (e) => {
            const percentage = 100 - e.target.value;
            before.style.clipPath = `inset(0 ${percentage}% 0 0)`;
        });
    }
}

window.calculateROI = function() {
    const input = document.getElementById('roi-input').value;
    const result = document.getElementById('roi-result');
    if(input) {
        result.innerText = `By moving to Cloud Native, you save ~$${(input * 0.35).toFixed(2)}/month!`;
    }
}

// VCard Generator
window.downloadVCard = function(name, title, email, phone, websiteUrl) {
    // فرض الاسم الاحترافي دائماً
    const contactName = "ENG.Eman Alaa";
    const vcard = `BEGIN:VCARD
VERSION:3.0
FN:${contactName}
TITLE:${title}
EMAIL:${email}
TEL:${phone}
URL:${websiteUrl}
NOTE:Cloud Infrastructure, CI/CD, and DevOps Specialist.
END:VCARD`;
    
    const blob = new Blob([vcard], { type: 'text/vcard' });
    const objectUrl = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = objectUrl;
    a.download = `ENG.Eman_Alaa_Contact.vcf`;
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(objectUrl);
}

// --- Testimonial Submission ---
function setupTestimonialForm() {
    const form = document.getElementById('testimonial-form');
    if (!form) return;
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = form.querySelector('button');
        const nameInput = document.getElementById('test-name');
        const roleInput = document.getElementById('test-role');
        const feedbackInput = document.getElementById('test-feedback');
        
        const ratingInput = document.getElementById('test-rating');
        
        if(!nameInput.value || !roleInput.value || !feedbackInput.value) return;
        
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Submitting...';
        btn.disabled = true;
        
        try {
            const response = await fetch('/api/testimonials', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ 
                    name: nameInput.value,
                    role: roleInput.value,
                    feedback: feedbackInput.value,
                    rating: ratingInput ? ratingInput.value : 5
                })
            });
            const result = await response.json();
            
            if (response.ok && result.success) {
                form.reset();
                document.getElementById('testimonial-modal').style.display = 'none';
                showToast('Testimonial submitted successfully! It will appear once approved.', 'success');
                if (typeof confetti !== 'undefined') {
                    confetti({ particleCount: 50, spread: 60, origin: { y: 0.8 } });
                }
            } else {
                showToast(result.message || 'Error submitting testimonial.', 'error');
            }
        } catch (error) {
            showToast('Connection error.', 'error');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
}

// --- Newsletter Subscription ---
function setupNewsletterForm() {
    const form = document.getElementById('newsletter-form');
    if (!form) return;
    
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const emailInput = form.querySelector('input[type="email"]');
        const btn = form.querySelector('button');
        if(!emailInput || !emailInput.value) return;
        
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Subscribing...';
        btn.disabled = true;
        
        try {
            const response = await fetch('/api/subscribe', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email: emailInput.value })
            });
            const result = await response.json();
            
            if (response.ok && result.success) {
                form.reset();
                showToast('Successfully Subscribed to DevOps Tips!', 'success');
                if (typeof confetti !== 'undefined') {
                    confetti({ particleCount: 50, spread: 60, origin: { y: 0.8 } });
                }
            } else {
                showToast(result.message || 'Error subscribing. Maybe you already joined?', 'error');
            }
        } catch (error) {
            showToast('Connection error.', 'error');
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    });
}

// --- Toast Notifications System ---
function showToast(message, type = 'success') {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:10px;';
        document.body.appendChild(container);
    }
    
    const toast = document.createElement('div');
    const bgColor = type === 'success' ? '#10b981' : '#ef4444';
    const icon = type === 'success' ? '<i class="fa-solid fa-circle-check"></i>' : '<i class="fa-solid fa-circle-exclamation"></i>';
    toast.style.cssText = `background:${bgColor};color:#fff;padding:12px 20px;border-radius:8px;box-shadow:0 10px 15px -3px rgba(0,0,0,0.5);display:flex;align-items:center;gap:10px;font-weight:600;transform:translateX(120%);transition:transform 0.3s ease-out;`;
    toast.innerHTML = `${icon} <span>${message}</span>`;
    
    container.appendChild(toast);
    
    requestAnimationFrame(() => {
        toast.style.transform = 'translateX(0)';
    });
    
    setTimeout(() => {
        toast.style.transform = 'translateX(120%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Actual Voice Recording using MediaRecorder API
function initVoiceRecord() {
    const btn = document.getElementById('btn-record-voice');
    const preview = document.getElementById('voice-preview');
    if(!btn) return;
    
    let mediaRecorder;
    let audioChunks = [];

    btn.addEventListener('click', async () => {
        if (!mediaRecorder || mediaRecorder.state === 'inactive') {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true }).catch(() => alert('Microphone access denied!'));
            if(!stream) return;
            
            mediaRecorder = new MediaRecorder(stream);
            mediaRecorder.start();
            btn.innerHTML = '<i class="fa-solid fa-stop"></i> Stop Recording';
            btn.style.background = '#059669';
            
            mediaRecorder.addEventListener('dataavailable', event => audioChunks.push(event.data));
            mediaRecorder.addEventListener('stop', () => {
                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                window.recordedVoiceBlob = audioBlob;
                const audioUrl = URL.createObjectURL(audioBlob);
                preview.src = audioUrl;
                preview.style.display = 'block';
                audioChunks = [];
                
                // Stop tracks
                stream.getTracks().forEach(track => track.stop());
            });
        } else {
            mediaRecorder.stop();
            btn.innerHTML = '<i class="fa-solid fa-microphone"></i> Record Again';
            btn.style.background = '#ef4444';
        }
    });
}

// --- Video Explainer Controls ---
window.openVideoModal = function() {
    const modal = document.getElementById('video-modal');
    const video = document.getElementById('service-video');
    modal.style.display = 'flex';
    video.muted = false; // تشغيل الصوت بشكل افتراضي عند الفتح
    video.play();
    const btn = document.getElementById('btn-video-sound');
    btn.innerHTML = '<i class="fa-solid fa-volume-high"></i> <span style="margin-left: 5px;">Sound ON</span>';
    btn.style.color = '#10b981';
}

window.closeVideoModal = function() {
    const modal = document.getElementById('video-modal');
    const video = document.getElementById('service-video');
    modal.style.display = 'none';
    video.pause(); // إيقاف الفيديو عند الإغلاق لتوفير الموارد
    video.currentTime = 0;
}

window.toggleVideoSound = function() {
    const video = document.getElementById('service-video');
    const btn = document.getElementById('btn-video-sound');
    video.muted = !video.muted;
    if(video.muted) {
        btn.innerHTML = '<i class="fa-solid fa-volume-xmark"></i> <span style="margin-left: 5px;">Muted</span>';
        btn.style.color = '#ef4444';
    } else {
        btn.innerHTML = '<i class="fa-solid fa-volume-high"></i> <span style="margin-left: 5px;">Sound ON</span>';
        btn.style.color = '#10b981';
    }
}

// --- Testimonials Slider ---
function initTestimonialSlider() {
    const slides = document.querySelectorAll('.testimonial-slide');
    if (slides.length <= 1) return; // لا داعي للسلايدر إذا كان هناك تقييم واحد فقط
    
    let currentIndex = 0;
    setInterval(() => {
        // إخفاء التقييم الحالي
        slides[currentIndex].style.opacity = '0';
        slides[currentIndex].style.pointerEvents = 'none';

        // إظهار التقييم التالي
        currentIndex = (currentIndex + 1) % slides.length;
        slides[currentIndex].style.opacity = '1';
        slides[currentIndex].style.pointerEvents = 'auto';
    }, 6000); // تغيير التقييم كل 6 ثوانٍ
}

// --- Header Scroll Effect ---
function initHeaderScroll() {
    const header = document.querySelector('.app-header');
    if (!header) return;
    
    let lastScroll = 0;
    window.addEventListener('scroll', () => {
        const currentScroll = window.pageYOffset;
        
        if (currentScroll > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
        
        lastScroll = currentScroll;
    });
}

// --- Smooth Scrolling for Navigation ---
function initSmoothScrolling() {
    document.querySelectorAll('a[href^="#"], .nav-btn').forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href') || this.getAttribute('data-target');
            if (!targetId) return;
            
            const targetElement = document.getElementById(targetId.replace('section-', ''));
            if (targetElement) {
                e.preventDefault();
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// --- Parallax Effect for Hero Section ---
function initParallax() {
    const hero = document.querySelector('.hero');
    if (!hero) return;
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * 0.5;
        hero.style.transform = `translateY(${rate}px)`;
        hero.style.opacity = 1 - (scrolled / 700);
    });
}

// --- Magnetic Buttons Effect ---
function initMagneticButtons() {
    const buttons = document.querySelectorAll('.btn-primary, .nav-btn');
    
    buttons.forEach(button => {
        button.addEventListener('mousemove', (e) => {
            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            
            button.style.transform = `translate(${x * 0.15}px, ${y * 0.15}px)`;
        });
        
        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translate(0, 0)';
            button.style.transition = 'transform 0.3s ease';
        });
        
        button.addEventListener('mouseenter', () => {
            button.style.transition = 'transform 0.1s ease';
        });
    });
}

// --- Enhanced Counter Animation ---
function animateCounter(element, target, duration = 2000) {
    const start = 0;
    const startTime = performance.now();
    
    function update(currentTime) {
        const elapsed = currentTime - startTime;
        const progress = Math.min(elapsed / duration, 1);
        
        // Easing function for smooth animation
        const easeOut = 1 - Math.pow(1 - progress, 3);
        const current = Math.floor(start + (target - start) * easeOut);
        
        element.textContent = current;
        
        if (progress < 1) {
            requestAnimationFrame(update);
        }
    }
    
    requestAnimationFrame(update);
}

// --- Initialize Enhanced Effects ---
window.addEventListener('load', () => {
    initParallax();
    initMagneticButtons();
    
    // Add page load animation
    document.body.style.opacity = '0';
    document.body.style.transition = 'opacity 0.5s ease';
    setTimeout(() => {
        document.body.style.opacity = '1';
    }, 100);
});

// Live Status Dashboard Logic
document.addEventListener("DOMContentLoaded", () => {
    const cpuBar = document.querySelector(".lsd-cpu");
    const cpuVal = document.getElementById("lsd-cpu-val");
    const memBar = document.querySelector(".lsd-mem");
    const memVal = document.getElementById("lsd-mem-val");
    const pingChart = document.getElementById("lsd-ping-chart");
    const pingVal = document.getElementById("lsd-ping-val");

    if(!cpuBar) return;

    // Initialize ping chart bars
    let pings = Array(15).fill(20);
    pings.forEach(p => {
        const bar = document.createElement("div");
        bar.className = "lsd-chart-bar";
        bar.style.height = (p) + "px";
        pingChart.appendChild(bar);
    });

    setInterval(() => {
        // CPU Fluctuation (10% to 40%)
        let cpu = Math.floor(Math.random() * 30) + 10;
        cpuBar.style.width = cpu + "%";
        cpuVal.innerText = cpu + "%";

        // Memory Fluctuation (40% to 60%)
        let mem = Math.floor(Math.random() * 20) + 40;
        memBar.style.width = mem + "%";
        memVal.innerText = mem + "%";

        // Ping Fluctuation (10ms to 40ms)
        let ping = Math.floor(Math.random() * 30) + 10;
        pingVal.innerText = ping + "ms";
        
        pings.shift();
        pings.push(ping);
        
        const bars = pingChart.querySelectorAll(".lsd-chart-bar");
        bars.forEach((bar, i) => {
            bar.style.height = (pings[i] / 40 * 30) + "px";
        });
        
    }, 2500);
});

// --- Architecture Diagram Modal ---
if (typeof mermaid !== "undefined") {
    mermaid.initialize({ startOnLoad: false, theme: "dark" });
}

window.showArchitecture = function(projectId) {
    const project = allProjects.find(p => {
        const pId = p.id;
        // In Laravel IDs are typically integers, but might be strings in JS
        return String(p.id) === String(projectId) || String(pId) === String(projectId);
    });

    if (project && (project.architecture_diagram || project.architecture_image_url)) {
        const modal = document.getElementById("arch-modal");
        const container = document.getElementById("arch-diagram");
        
        let contentHtml = '';
        if (project.architecture_image_url && project.architecture_diagram) {
            contentHtml = `
            <div style="display: flex; flex-wrap: wrap; gap: 30px; align-items: center; justify-content: center;">
                <div style="flex: 1; min-width: 300px; text-align: center;">
                    <img src="${project.architecture_image_url}" alt="Architecture Image" style="max-width: 100%; max-height: 70vh; object-fit: contain; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                </div>
                <div style="flex: 1; min-width: 300px; padding: 20px; background: rgba(0,0,0,0.2); border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: center; align-items: center; overflow-x: auto;">
                    <div class="mermaid">${project.architecture_diagram}</div>
                </div>
            </div>`;
        } else if (project.architecture_image_url) {
            contentHtml = `<div style="text-align: center;"><img src="${project.architecture_image_url}" alt="Architecture Diagram" style="max-width: 100%; max-height: 75vh; object-fit: contain; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 4px 6px rgba(0,0,0,0.3);"></div>`;
        } else if (project.architecture_diagram) {
            contentHtml = `<div class="mermaid">${project.architecture_diagram}</div>`;
        }
        
        container.innerHTML = contentHtml;
        container.removeAttribute("data-processed");
        
        if (project.architecture_diagram) {
            setTimeout(() => {
                try {
                    mermaid.init(undefined, container.querySelectorAll('.mermaid'));
                } catch (e) {
                    console.error("Mermaid parsing error:", e);
                }
            }, 100);
        }
        
        modal.style.display = "flex";
    }
}

window.showVideo = function(projectId) {
    const project = allProjects.find(p => String(p.id) === String(projectId));
    if (project && project.video_url) {
        // Create video modal dynamically if it doesn't exist
        let videoModal = document.getElementById("project-video-modal");
        if (!videoModal) {
            videoModal = document.createElement('div');
            videoModal.id = "project-video-modal";
            videoModal.className = "modal";
            videoModal.style.cssText = "display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;";
            
            const closeBtn = document.createElement('span');
            closeBtn.innerHTML = '&times;';
            closeBtn.style.cssText = "position: absolute; top: 20px; right: 30px; color: white; font-size: 40px; cursor: pointer; transition: color 0.2s;";
            closeBtn.onmouseover = function() { this.style.color = '#ef4444'; };
            closeBtn.onmouseout = function() { this.style.color = 'white'; };
            closeBtn.onclick = function() { 
                videoModal.style.display = "none"; 
                const videoEl = document.getElementById("project-video-player");
                if (videoEl) videoEl.pause();
            };
            
            const contentContainer = document.createElement('div');
            contentContainer.id = "project-video-container";
            contentContainer.style.cssText = "max-width: 900px; width: 90%; max-height: 80vh;";
            
            videoModal.appendChild(closeBtn);
            videoModal.appendChild(contentContainer);
            document.body.appendChild(videoModal);
            
            // Close when clicking outside
            videoModal.onclick = function(e) {
                if(e.target === videoModal) {
                    videoModal.style.display = "none";
                    const videoEl = document.getElementById("project-video-player");
                    if (videoEl) videoEl.pause();
                }
            };
        }
        
        const container = document.getElementById("project-video-container");
        container.innerHTML = `<video id="project-video-player" controls autoplay style="width: 100%; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 10px 25px rgba(0,0,0,0.5);"><source src="${project.video_url}" type="video/mp4"></video>`;
        
        videoModal.style.display = "flex";
    }
}

// --- Cloud Cost Estimator ---
function initCostCalculator() {
    const dynamicInputs = document.querySelectorAll('.dynamic-calc-input');
    const totalEl = document.getElementById("calc-total");
    
    // If no dynamic inputs, fallback to the original behavior for backward compatibility or when empty
    if (dynamicInputs.length === 0) {
        const compute = document.getElementById("calc-compute");
        const db = document.getElementById("calc-db");
        const s3 = document.getElementById("calc-s3");
        
        if(!compute || !db || !s3 || !totalEl) return;
        
        const computeVal = document.getElementById("calc-compute-val");
        const dbVal = document.getElementById("calc-db-val");
        const s3Val = document.getElementById("calc-s3-val");

        function calculateFallback() {
            computeVal.innerText = compute.value;
            dbVal.innerText = db.value + " GB";
            s3Val.innerText = s3.value + " GB";
            
            const total = (parseInt(compute.value) * 25) + (parseInt(db.value) * 0.115) + (parseInt(s3.value) * 0.023);
            totalEl.innerText = total.toFixed(2);
        }

        compute.addEventListener("input", calculateFallback);
        db.addEventListener("input", calculateFallback);
        s3.addEventListener("input", calculateFallback);
        
        calculateFallback();
        return;
    }
    
    if (!totalEl) return;

    function calculateDynamic() {
        let total = 0;
        
        dynamicInputs.forEach(input => {
            const id = input.getAttribute('data-id');
            const price = parseFloat(input.getAttribute('data-price')) || 0;
            const unit = input.getAttribute('data-unit') || '';
            const val = parseInt(input.value) || 0;
            
            const valDisplay = document.getElementById(`calc-estimator-val-${id}`);
            if (valDisplay) {
                valDisplay.innerText = `${val} ${unit}`.trim();
            }
            
            total += (val * price);
        });
        
        totalEl.innerText = total.toFixed(2);
    }

    dynamicInputs.forEach(input => {
        input.addEventListener("input", calculateDynamic);
    });
    
    calculateDynamic();
}
document.addEventListener("DOMContentLoaded", initCostCalculator);