import re
import sys

with open('/home/figo/Desktop/Felo/E/eman/resources/views/front/home.blade.php', 'r') as f:
    content = f.read()

# Replace About Section inner
about_replacement = """            <!-- Band A: Bio & Contact (Split) -->
            <div class="about-container reveal-zoom" style="margin-bottom: 50px; display: flex; flex-wrap: wrap; gap: 30px;">
                <div class="reveal-left delay-100" style="flex: 1; min-width: 250px;">
                    <div class="scratch-reveal-container"><img src="{{ $profilePic }}" onerror="this.src='https://placehold.co/250';" alt="Profile" class="profile-pic scratch-pic"></div>
                    <ul class="contact-list" style="margin-top: 20px;">
                        @if(!empty($vEmail))
                            <li class="copy-item" data-clipboard="{{ $vEmail }}"><i class="fa-solid fa-envelope" style="color: var(--accent-color); width: 25px;"></i> {{ $vEmail }} <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if(!empty($vPhone))
                            <li class="copy-item" data-clipboard="{{ $vPhone }}"><i class="fa-solid fa-phone" style="color: var(--accent-color); width: 25px;"></i> {{ $vPhone }} <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if(!empty($vLink))
                            <li class="copy-item" data-clipboard="{{ $vLink }}"><i class="fa-brands fa-linkedin" style="color: var(--accent-color); width: 25px;"></i> LinkedIn <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                        @if(!empty($vGithub))
                            <li class="copy-item" data-clipboard="{{ $vGithub }}"><i class="fa-brands fa-github" style="color: var(--accent-color); width: 25px;"></i> GitHub <i class="fa-regular fa-copy copy-icon"></i></li>
                        @endif
                    </ul>
                    <button class="btn-primary i18n" data-en="Download VCard" data-ar="حفظ جهة الاتصال" onclick="downloadVCard('{!! $vName !!}', '{!! $vTitle !!}', '{!! $vEmail !!}', '{!! $vPhone !!}', '{!! $vLink !!}')" style="width:100%; font-size:0.9em; padding:10px 15px; margin-top: 15px;"><i class="fa-solid fa-address-card"></i> Download VCard</button>
                </div>
                
                <div class="profile-info reveal-right delay-200" style="flex: 2; min-width: 300px;">
                    <h2>{{ $activeCv['personal_info']['full_name'] ?? 'Eman' }} <span class="availability-dot" title="Available for work"></span> <button onclick="new Audio('https://dictaudio.playphrase.me/eman.mp3').play()" style="background:none;border:none;color:#10b981;cursor:pointer;"><i class="fa-solid fa-volume-high"></i></button></h2>
                    <p class="title">{{ $activeCv['personal_info']['title'] ?? 'Senior Cloud & DevOps Engineer' }}</p>
                    
                    @if(!empty($learningName))
                        <div class="currently-learning" style="margin-bottom: 20px; font-size: 0.95em;">
                            <span class="i18n" data-en="Currently Learning:" data-ar="أتعلم حالياً:">Currently Learning:</span>
                            <span class="tech-badge" style="display: inline-flex; margin-left: 10px; background: rgba(217, 70, 239, 0.1); border-color: #d946ef; color: #d946ef;"><i class="{{ $learningIcon }}"></i> {{ $learningName }}</span>
                        </div>
                    @endif
                    
                    <div style="font-size: 1.1em; line-height: 1.8; color: var(--text-secondary);">
                        <p class="i18n" data-en="{{ $siteSettings['about_en'] ?? '' }}" data-ar="{{ $siteSettings['about_ar'] ?? '' }}">{{ $siteSettings['about_en'] ?? '' }}</p>
                    </div>

                    @if(!empty($testimonials))
                    <div class="testimonials-wrapper" style="position: relative; min-height: 120px; background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 8px; display: flex; align-items: center; justify-content: center; overflow: hidden; padding: 20px; margin-top: 30px;">
                        <i class="fa-solid fa-quote-left" style="color: var(--accent-color); font-size: 2em; opacity: 0.1; position: absolute; top: 10px; left: 15px;"></i>
                        @foreach($testimonials as $index => $test)
                            <div class="testimonial-slide" style="position: absolute; width: 100%; padding: 0 40px; box-sizing: border-box; text-align: center; opacity: {!! $index === 0 ? '1' : '0' !!}; transition: opacity 0.6s ease-in-out; pointer-events: {!! $index === 0 ? 'auto' : 'none' !!};">
                                <p style="font-style: italic; font-size: 0.95em; color: #e2e8f0; margin-bottom: 10px; line-height: 1.5;">"{{ $test['feedback'] ?? '' }}"</p>
                                <strong style="color: var(--accent-color); display: block; font-size: 1em;">{{ $test['client_name'] ?? '' }}</strong>
                                <span style="color: #888; font-size: 0.85em;">{{ $test['client_role'] ?? '' }}</span>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- Band B: Experience Journey (Full Width) -->
            <div class="experience-band reveal-up" style="margin-bottom: 60px;">
                <h3 class="i18n section-title" data-en="Experience Journey" data-ar="مسار الخبرات" style="text-align: center;">Experience Journey</h3>
                <div class="horizontal-timeline" style="justify-content: center; flex-wrap: wrap;">
                    <?php $delay = 0; foreach($experienceJourney as $exp): ?>
                        <div class="timeline-item reveal-up delay-{!! $delay !!}" style="min-width: 200px;">
                            <span class="timeline-date">{{ $exp['duration'] ?? ($exp['date'] ?? '') }}</span>
                            <strong>{{ $exp['title'] ?? '' }}</strong>
                            @if(!empty($exp['company']))
                                <p style="font-size: 0.9em; color: var(--accent-color); margin-top: 3px; margin-bottom: 5px;">{{ $exp['company'] }}</p>
                            @endif
                            @if(!empty($exp['description']))
                                <p style="font-size: 0.85em; color: #888; margin-top: 0; margin-bottom: 0; line-height: 1.4;">{{ $exp['description'] }}</p>
                            @endif
                        </div>
                    <?php $delay += 100; endforeach; ?>
                    @if(empty($experienceJourney))
                        <p style="color: #666; font-size: 0.9em; text-align: center; width: 100%;">Experience details will appear here.</p>
                    @endif
                </div>
            </div>

            <!-- Band C: Skills Ecosystem -->
            <div class="skills-band reveal-up" style="margin-bottom: 60px;">
                <h3 class="i18n section-title" data-en="Skills & Expertise" data-ar="المهارات والخبرات" style="text-align: center;">Skills & Expertise</h3>
                <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                    <!-- Left: Core Tech & Radar -->
                    <div style="flex: 1; min-width: 300px; display: flex; flex-direction: column; gap: 30px;">
                        <div>
                            <h4 class="i18n" data-en="Core Technologies" data-ar="التقنيات الأساسية" style="margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Core Technologies</h4>
                            @foreach($coreSkills as $skill)
                                <div class="skill-item"><div class="skill-header"><span><i class="{{ $skill['icon'] ?? '' }}" style="color: var(--accent-color); width: 20px;"></i> {{ $skill['name'] ?? '' }}</span><span>{{ $skill['percent'] ?? 0 }}%</span></div><div class="skill-bar"><div class="skill-fill" data-width="{{ $skill['percent'] ?? 0 }}%"></div></div></div>
                            @endforeach
                        </div>
                        
                        <div>
                            <h4 class="i18n" data-en="Skills Radar" data-ar="مخطط المهارات" style="margin-bottom: 15px; border-bottom: 1px solid var(--border-color); padding-bottom: 10px;">Skills Radar</h4>
                            <div class="radar-chart-container" style="max-width: 300px; margin: 0 auto;">
                                <canvas id="skillsRadarChart"></canvas>
                            </div>
                        </div>

                        <!-- Live GitHub Stats -->
                        <div class="live-github-stats" style="margin-top: 0; border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; text-align: center;">
                            <span class="i18n" data-en="Live GitHub Commits:" data-ar="مساهمات جيت هاب الحية:">Live GitHub Commits:</span> <strong id="gh-commits-count" style="color: var(--accent-color);">Loading...</strong>
                        </div>
                    </div>

                    <!-- Right: Tech Stack Categories -->
                    <div style="flex: 1.5; min-width: 300px;">
                        @if(!empty($siteSettings['tech_categories']) && is_array($siteSettings['tech_categories']))
                            <div class="tech-category-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 15px; display: grid;">
                                @foreach($siteSettings['tech_categories'] as $cat)
                                <div class="tech-category-card" style="background: rgba(15,23,42,0.5);">
                                    <div class="tech-cat-header">
                                        <i class="{{ $cat['icon'] ?? 'fa-solid fa-layer-group' }} tech-cat-icon"></i>
                                        <span class="tech-cat-title">{{ $cat['name'] ?? '' }}</span>
                                    </div>
                                    <div class="tech-cat-skills">
                                        @if(!empty($cat['skills']) && is_array($cat['skills']))
                                            @foreach($cat['skills'] as $skill)
                                                <span class="tech-badge"><i class="fa-solid fa-check" style="color:var(--accent-primary); font-size:0.8em;"></i> {{ $skill }}</span>
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
            <div class="personal-band reveal-up">
                <div style="display: flex; gap: 40px; flex-wrap: wrap;">
                    <div style="flex: 2; min-width: 300px;">
                        @if(!empty($activeCv['certifications']))
                        <h3 class="i18n section-title" data-en="Certifications" data-ar="الشهادات المعتمدة" style="margin-bottom: 20px;">Certifications</h3>
                        <div class="certifications-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 15px;">
                            <?php $delay = 0; foreach($activeCv['certifications'] as $cert): ?>
                                <div class="cert-card reveal-up delay-{!! $delay !!}" style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-color); border-radius: 8px; padding: 15px; display: flex; align-items: center; gap: 15px;">
                                    @if(!empty($cert['image']))
                                        <div style="background: #fff; padding: 5px; border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                                            <img src="{{ $cert['image'] }}" alt="{{ $cert['name'] }}" style="width: 40px; height: 40px; object-fit: contain;">
                                        </div>
                                    @else
                                        <div style="width: 40px; height: 40px; background: rgba(16,185,129,0.1); color: var(--accent-color); border-radius: 6px; display: flex; align-items: center; justify-content: center; font-size: 1.2em; flex-shrink: 0;"><i class="fa-solid fa-award"></i></div>
                                    @endif
                                    <div>
                                        <strong style="display: block; color: var(--text-color); font-size: 0.95em; line-height: 1.2; margin-bottom: 4px;">{{ $cert['name'] }}</strong>
                                        <span style="color: #888; font-size: 0.8em;">{{ $cert['issuer'] }} {!! !empty($cert['date']) ? ' (' . htmlspecialchars($cert['date']) . ')' : '' !!}</span>
                                    </div>
                                </div>
                            <?php $delay += 100; endforeach; ?>
                        </div>
                        @endif
                    </div>
                    
                    <div style="flex: 1; min-width: 200px;">
                        <h3 class="i18n section-title" data-en="Hobbies" data-ar="الاهتمامات" style="margin-bottom: 20px;">Hobbies</h3>
                        <div class="hobbies-icons" style="justify-content: flex-start;">
                            @foreach($hobbies as $hobby)
                                <span title="{{ $hobby['name'] ?? '' }}"><i class="{{ $hobby['icon'] ?? '' }}"></i></span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>"""

cloud_calculator_replacement = """                    <!-- Interactive Cloud Cost Calculator -->
                    <h3 class="i18n" data-en="FinOps: Cloud Cost Estimator" data-ar="مُقدر تكاليف السحابة" style="margin-top: 30px; text-align: center;">FinOps: Cloud Cost Estimator</h3>
                    <div class="cost-calculator reveal-up delay-200" style="background: rgba(15,23,42,0.6); padding: 20px; border-radius: 8px; border: 1px solid var(--border-color); margin-bottom: 20px; max-width: 600px; margin-left: auto; margin-right: auto;">
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 5px;"><span class="i18n" data-en="Compute (EC2 Instances)" data-ar="الخوادم السحابية">Compute (EC2 Instances)</span> <span id="calc-compute-val" style="color:var(--accent-color); font-weight:bold;">2</span></label>
                                <input type="range" id="calc-compute" min="1" max="50" value="2" style="width: 100%; accent-color: var(--accent-color);">
                            </div>
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 5px;"><span class="i18n" data-en="Database Storage (GB)" data-ar="مساحة قواعد البيانات">Database Storage (GB)</span> <span id="calc-db-val" style="color:var(--accent-color); font-weight:bold;">100 GB</span></label>
                                <input type="range" id="calc-db" min="10" max="2000" value="100" step="10" style="width: 100%; accent-color: var(--accent-color);">
                            </div>
                            <div>
                                <label style="display: flex; justify-content: space-between; margin-bottom: 5px;"><span class="i18n" data-en="Object Storage (S3 - GB)" data-ar="التخزين السحابي">Object Storage (S3 - GB)</span> <span id="calc-s3-val" style="color:var(--accent-color); font-weight:bold;">500 GB</span></label>
                                <input type="range" id="calc-s3" min="50" max="10000" value="500" step="50" style="width: 100%; accent-color: var(--accent-color);">
                            </div>
                            <div style="margin-top: 15px; padding-top: 15px; border-top: 1px dashed rgba(255,255,255,0.1); text-align: center;">
                                <span class="i18n" style="color:var(--text-secondary);" data-en="Estimated Monthly Cost:" data-ar="التكلفة الشهرية التقديرية:">Estimated Monthly Cost:</span>
                                <h2 style="color: #fff; font-size: 2em; margin: 10px 0;"><span style="color:var(--accent-color);">$</span><span id="calc-total">0</span> <span style="font-size:0.4em; color:#888;">/mo</span></h2>
                                <p style="font-size: 0.8em; color: #666; margin: 0;">*Estimates based on standard AWS pricing</p>
                            </div>
                        </div>
                    </div>"""

pattern = re.compile(r'<div class="about-container reveal-zoom">.*?(?=\s*</section>)', re.DOTALL)
content = pattern.sub(about_replacement, content)

services_roi_target = """                <div class="before-after-container">
                    <div class="ba-layer after-layer"><div class="ba-label">Cloud (Automated)</div></div>
                    <div class="ba-layer before-layer"><div class="ba-label">Legacy (Manual)</div></div>
                    <input type="range" min="0" max="100" value="50" class="ba-slider" id="ba-slider">
                </div>"""

if services_roi_target in content:
    content = content.replace(services_roi_target, services_roi_target + '\n' + cloud_calculator_replacement)
else:
    print("Could not find ROI calculator in services!")
    sys.exit(1)

with open('/home/figo/Desktop/Felo/E/eman/resources/views/front/home.blade.php', 'w') as f:
    f.write(content)

print("Rewrite successful.")
