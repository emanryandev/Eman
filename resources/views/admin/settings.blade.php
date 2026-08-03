@extends("admin.layout")
@section("content")
<style>
    .settings-tabs {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        padding-bottom: 15px;
        flex-wrap: wrap;
    }
    .settings-tab {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #94a3b8;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
        white-space: nowrap;
    }
    .settings-tab:hover {
        background: rgba(255, 255, 255, 0.1);
        color: #fff;
    }
    .settings-tab.active {
        background: rgba(16, 185, 129, 0.15);
        border-color: #10b981;
        color: #10b981;
        font-weight: bold;
    }
    .settings-section {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    .settings-section.active {
        display: block;
    }
    .section-title {
        font-size: 1.2em;
        color: #fff;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 1px dashed rgba(255,255,255,0.1);
    }
    .dynamic-row {
        background: rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.05);
    }
</style>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
    <h1 style="margin: 0;">System Settings</h1>
</div>

<?php if (isset($_GET['success'])): ?>
    <div style="background: rgba(16, 185, 129, 0.1); color: #10b981; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid rgba(16, 185, 129, 0.3);">
        <i class="fa-solid fa-check-circle"></i> Settings updated successfully!
    </div>
<?php endif; ?>

<?php if (isset($error)): ?>
    <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid rgba(239, 68, 68, 0.3);">
        <i class="fa-solid fa-triangle-exclamation"></i> <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>

<div style="display: flex; gap: 30px; flex-wrap: wrap; align-items: flex-start;">

    <!-- إعدادات محتوى الواجهة (Tabbed) -->
    <div class="stat-card" style="flex: 2; min-width: 300px; padding: 30px; border-top: 4px solid #10b981;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #10b981;">Frontend Content Management</h3>
        
        <p style="background: rgba(59, 130, 246, 0.1); padding: 10px 15px; border-radius: 6px; font-size: 0.9em; border-left: 4px solid #3b82f6;"><i class="fa-solid fa-circle-info text-blue"></i> <b>Note:</b> Phone number and social links are automatically synced from the <b>CV Builder</b> section.</p>

        <!-- Tabs -->
        <div class="settings-tabs">
            <div class="settings-tab active" onclick="switchTab('general', this)">
                <i class="fa-solid fa-id-card"></i> General Info
            </div>
            <div class="settings-tab" onclick="switchTab('skills', this)">
                <i class="fa-solid fa-code"></i> Skills & Tech
            </div>
            <div class="settings-tab" onclick="switchTab('experience', this)">
                <i class="fa-solid fa-briefcase"></i> Experience
            </div>
            <div class="settings-tab" onclick="switchTab('certifications', this)">
                <i class="fa-solid fa-certificate"></i> Certifications
            </div>
            <div class="settings-tab" onclick="switchTab('extras', this)">
                <i class="fa-solid fa-star"></i> Extras (Testimonials)
            </div>
            <div class="settings-tab" onclick="switchTab('services', this)">
                <i class="fa-solid fa-server"></i> Services
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}" class="cv-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="form_type" value="site_content">

            <!-- TAB: General Info -->
            <div id="tab-general" class="settings-section active">
                <h4 class="section-title">General & Profile Information</h4>
                
                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                    <div style="flex: 1;">
                        <label>Years of Experience</label>
                        <input type="number" name="years_experience" value="<?= htmlspecialchars($siteSettings['years_experience'] ?? 5) ?>" class="form-control" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Uptime Percentage (%)</label>
                        <input type="number" name="uptime_percentage" value="<?= htmlspecialchars($siteSettings['uptime_percentage'] ?? 99) ?>" class="form-control" required>
                    </div>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>WhatsApp Number</label>
                    <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($siteSettings['whatsapp_number'] ?? '1234567890') ?>" class="form-control" placeholder="e.g. 201012345678" style="max-width: 100%;">
                    <small style="color: #666;">Enter with country code, no '+'. e.g. 201xxxxxxxxx</small>
                </div>

                <div style="margin-bottom: 15px;">
                    <label>Map Embed URL (Iframe Src)</label>
                    <input type="url" name="map_url" value="<?= htmlspecialchars($siteSettings['map_url'] ?? '') ?>" class="form-control" placeholder="e.g. https://www.openstreetmap.org/export/embed.html?..." style="max-width: 100%;">
                    <small style="color: #666;">Paste the `src` attribute from a Google Maps or OpenStreetMap embed link. Leave empty to hide the map.</small>
                </div>

                <label>Profile Picture</label>
                <input type="hidden" name="current_profile_pic" value="<?= htmlspecialchars($siteSettings['profile_pic'] ?? '/assets/images/profile.png') ?>">
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                    <img src="<?= htmlspecialchars($siteSettings['profile_pic'] ?? '/assets/images/profile.png') ?>" style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 2px solid #10b981;">
                    <input type="file" name="profile_pic" accept="image/*" class="form-control" style="background: transparent; border: none; padding: 0;">
                </div>

                <label>B2B Brochure PDF (Optional)</label>
                <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 15px; background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px;">
                    <?php if(!empty($siteSettings['b2b_brochure'])): ?>
                        <a href="<?= htmlspecialchars($siteSettings['b2b_brochure']) ?>" target="_blank" style="color: var(--accent-color); text-decoration: none;"><i class="fa-solid fa-file-pdf"></i> View Current</a>
                    <?php endif; ?>
                    <input type="file" name="b2b_brochure" accept=".pdf" class="form-control" style="background: transparent; border: none; padding: 0;">
                </div>

                <label>Hero Title</label>
                <input type="text" name="hero_title_en" value="<?= htmlspecialchars($siteSettings['hero_title_en'] ?? 'Architecting Scalable Cloud Infrastructure') ?>" class="form-control" style="margin-bottom: 15px;">

                <label>About Me</label>
                <textarea name="about_en" class="form-control" rows="4" style="margin-bottom: 15px; line-height: 1.6;"><?= htmlspecialchars($siteSettings['about_en'] ?? 'Cloud Engineer specializing in designing secure, scalable, and highly available environments.') ?></textarea>

                <div style="display: flex; gap: 15px; margin-bottom: 15px; background: rgba(217, 70, 239, 0.05); padding: 15px; border-radius: 8px; border: 1px dashed #d946ef;">
                    <div style="flex: 2;">
                        <label>Currently Learning (Text)</label>
                        <input type="text" name="currently_learning_name" value="<?= htmlspecialchars($siteSettings['currently_learning_name'] ?? 'Rust 🦀') ?>" class="form-control" placeholder="e.g. Rust 🦀 (Leave empty to hide)">
                    </div>
                    <div style="flex: 1;">
                        <label>Icon Class</label>
                        <input type="text" name="currently_learning_icon" value="<?= htmlspecialchars($siteSettings['currently_learning_icon'] ?? 'fa-brands fa-rust') ?>" class="form-control" placeholder="e.g. fa-brands fa-rust">
                    </div>
                </div>
            </div>

            <!-- TAB: Skills & Tech -->
            <div id="tab-skills" class="settings-section">
                <!-- Core Technologies -->
                <h4 class="section-title">Core Technologies</h4>
                <div id="core-skills-container">
                    <?php $coreSkills = $siteSettings['core_skills'] ?? [['name'=>'AWS / GCP', 'icon'=>'fa-brands fa-aws', 'percent'=>90]]; ?>
                    <?php foreach($coreSkills as $skill): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;" class="dynamic-row">
                            <input type="text" name="core_skills[name][]" value="<?= htmlspecialchars($skill['name'] ?? '') ?>" class="form-control" placeholder="Skill Name" style="flex: 2;" required>
                            <input type="text" name="core_skills[icon][]" value="<?= htmlspecialchars($skill['icon'] ?? '') ?>" class="form-control" placeholder="Icon Class (fa-brands fa-aws)" style="flex: 2;">
                            <input type="number" name="core_skills[percent][]" value="<?= htmlspecialchars($skill['percent'] ?? 0) ?>" class="form-control" placeholder="%" style="flex: 1;" max="100" min="0">
                            <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('core-skills-container', `<input type='text' name='core_skills[name][]' class='form-control' placeholder='Skill Name' style='flex: 2;' required><input type='text' name='core_skills[icon][]' class='form-control' placeholder='Icon Class (e.g. fa-brands fa-docker)' style='flex: 2;'><input type='number' name='core_skills[percent][]' class='form-control' placeholder='%' style='flex: 1;' max='100' min='0'>`)" class="btn-add">+ Add Skill</button>

                <!-- Radar Skills -->
                <h4 class="section-title" style="margin-top: 30px;">Radar Chart Skills</h4>
                <div id="radar-skills-container">
                    <?php $radarSkills = $siteSettings['radar_skills'] ?? [
                        ['name'=>'Cloud (AWS/GCP)', 'percent'=>95],
                        ['name'=>'Containers', 'percent'=>90],
                    ]; ?>
                    <?php foreach($radarSkills as $skill): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;" class="dynamic-row">
                            <input type="text" name="radar_skills[name][]" value="<?= htmlspecialchars($skill['name'] ?? '') ?>" class="form-control" placeholder="Skill Name" style="flex: 2;" required>
                            <input type="number" name="radar_skills[percent][]" value="<?= htmlspecialchars($skill['percent'] ?? 0) ?>" class="form-control" placeholder="%" style="flex: 1;" max="100" min="0">
                            <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('radar-skills-container', `<input type='text' name='radar_skills[name][]' class='form-control' placeholder='Skill Name' style='flex: 2;' required><input type='number' name='radar_skills[percent][]' class='form-control' placeholder='%' style='flex: 1;' max='100' min='0'>`)" class="btn-add">+ Add Radar Skill</button>

                <!-- Tech Categories -->
                <h4 class="section-title" style="margin-top: 30px;">Tech Stack Categories</h4>
                <div id="tech-categories-container">
                    <?php $techCategories = $siteSettings['tech_categories'] ?? []; ?>
                    <?php foreach($techCategories as $cat): ?>
                        <div class="dynamic-row" style="position: relative; margin-bottom: 15px;">
                            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 15px; top: 15px;" class="btn-remove">X</button>
                            <div style="display: flex; gap: 10px; margin-bottom: 10px; padding-right: 40px;">
                                <input type="text" name="tech_categories[name][]" value="<?= htmlspecialchars($cat['name'] ?? '') ?>" class="form-control" placeholder="Category Name (e.g. Cloud Providers)" required style="flex: 2;">
                                <input type="text" name="tech_categories[icon][]" value="<?= htmlspecialchars($cat['icon'] ?? 'fa-solid fa-layer-group') ?>" class="form-control" placeholder="Icon" style="flex: 1;">
                            </div>
                            <textarea name="tech_categories[skills][]" class="form-control" placeholder="Skills (comma separated, e.g. AWS, GCP, Azure)" rows="2" required><?= htmlspecialchars(implode(', ', $cat['skills'] ?? [])) ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addTechCategoryRow()" class="btn-add">+ Add Tech Category</button>
            </div>

            <!-- TAB: Experience -->
            <div id="tab-experience" class="settings-section">
                <!-- Experience Journey -->
                <h4 class="section-title">Experience Journey</h4>
                <div id="experience-journey-container">
                    <?php $experienceJourney = $siteSettings['experience_journey'] ?? []; ?>
                    <?php foreach($experienceJourney as $exp): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px; flex-wrap: wrap;" class="dynamic-row">
                            <input type="text" name="experience_journey[title][]" value="<?= htmlspecialchars($exp['title'] ?? '') ?>" class="form-control" placeholder="Job Title" style="flex: 1; min-width: 150px;" required>
                            <input type="text" name="experience_journey[company][]" value="<?= htmlspecialchars($exp['company'] ?? '') ?>" class="form-control" placeholder="Company" style="flex: 1; min-width: 150px;" required>
                            <input type="text" name="experience_journey[duration][]" value="<?= htmlspecialchars($exp['duration'] ?? '') ?>" class="form-control" placeholder="Date (e.g. 2021 - Present)" style="flex: 1; min-width: 150px;" required>
                            <input type="text" name="experience_journey[description][]" value="<?= htmlspecialchars($exp['description'] ?? '') ?>" class="form-control" placeholder="Short Desc (Optional)" style="flex: 3; min-width: 250px;">
                            <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('experience-journey-container', `<input type='text' name='experience_journey[title][]' class='form-control' placeholder='Job Title' style='flex: 1; min-width: 150px;' required><input type='text' name='experience_journey[company][]' class='form-control' placeholder='Company' style='flex: 1; min-width: 150px;' required><input type='text' name='experience_journey[duration][]' class='form-control' placeholder='Date' style='flex: 1; min-width: 150px;' required><input type='text' name='experience_journey[description][]' class='form-control' placeholder='Short Desc' style='flex: 3; min-width: 250px;'>`)" class="btn-add">+ Add Experience</button>
            </div>

            <!-- TAB: Certifications -->
            <div id="tab-certifications" class="settings-section">
                <!-- Certifications -->
                <h4 class="section-title">Certifications</h4>
                <div id="certifications-container">
                    <?php $certifications = $siteSettings['certifications'] ?? []; ?>
                    <?php foreach($certifications as $cert): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;" class="dynamic-row">
                            <input type="text" name="certifications[name][]" value="<?= htmlspecialchars($cert['name'] ?? '') ?>" class="form-control" placeholder="Cert Name" style="flex: 2;" required>
                            <input type="text" name="certifications[issuer][]" value="<?= htmlspecialchars($cert['issuer'] ?? '') ?>" class="form-control" placeholder="Issuer (e.g. AWS)" style="flex: 2;" required>
                            <input type="text" name="certifications[url][]" value="<?= htmlspecialchars($cert['url'] ?? '') ?>" class="form-control" placeholder="URL / Link" style="flex: 2;">
                            <input type="text" name="certifications[icon][]" value="<?= htmlspecialchars($cert['icon'] ?? 'fa-solid fa-certificate') ?>" class="form-control" placeholder="Icon" style="flex: 1;">
                            <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('certifications-container', `<input type='text' name='certifications[name][]' class='form-control' placeholder='Cert Name' style='flex: 2;' required><input type='text' name='certifications[issuer][]' class='form-control' placeholder='Issuer' style='flex: 2;' required><input type='text' name='certifications[url][]' class='form-control' placeholder='URL / Link' style='flex: 2;'><input type='text' name='certifications[icon][]' class='form-control' placeholder='Icon' style='flex: 1;' value='fa-solid fa-certificate'>`)" class="btn-add">+ Add Certification</button>
            </div>

            <!-- TAB: Extras (Testimonials & Hobbies) -->
            <div id="tab-extras" class="settings-section">
                <!-- Testimonials -->
                <h4 class="section-title">Client Testimonials</h4>
                <div id="testimonials-container">
                    <?php $testimonials = $siteSettings['testimonials'] ?? []; ?>
                    <?php foreach($testimonials as $test): ?>
                        <div class="dynamic-row" style="position: relative; margin-bottom: 15px;">
                            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 15px; top: 15px;" class="btn-remove">X</button>
                            <div style="display: flex; gap: 10px; margin-bottom: 10px; padding-right: 40px;">
                                <input type="text" name="testimonials[client_name][]" value="<?= htmlspecialchars($test['client_name'] ?? '') ?>" class="form-control" placeholder="Client Name" required style="flex: 1;">
                                <input type="text" name="testimonials[client_role][]" value="<?= htmlspecialchars($test['client_role'] ?? '') ?>" class="form-control" placeholder="Role / Company (e.g. CTO, FinTech)" style="flex: 1;">
                            </div>
                            <textarea name="testimonials[feedback][]" class="form-control" placeholder="Review Text..." rows="3" required><?= htmlspecialchars($test['feedback'] ?? '') ?></textarea>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addTestimonialRow()" class="btn-add">+ Add Testimonial</button>

                <!-- Hobbies -->
                <h4 class="section-title" style="margin-top: 30px;">Hobbies</h4>
                <div id="hobbies-container">
                    <?php $hobbies = $siteSettings['hobbies'] ?? []; ?>
                    <?php foreach($hobbies as $hobby): ?>
                        <div style="display: flex; gap: 10px; margin-bottom: 10px;" class="dynamic-row">
                            <input type="text" name="hobbies[name][]" value="<?= htmlspecialchars($hobby['name'] ?? '') ?>" class="form-control" placeholder="Hobby Name" style="flex: 2;" required>
                            <input type="text" name="hobbies[icon][]" value="<?= htmlspecialchars($hobby['icon'] ?? '') ?>" class="form-control" placeholder="Icon Class (fa-solid fa-gamepad)" style="flex: 2;">
                            <button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('hobbies-container', `<input type='text' name='hobbies[name][]' class='form-control' placeholder='Hobby Name' style='flex: 2;' required><input type='text' name='hobbies[icon][]' class='form-control' placeholder='Icon Class' style='flex: 2;'>`)" class="btn-add">+ Add Hobby</button>
            </div>

            <!-- TAB: Services -->
            <div id="tab-services" class="settings-section">
                <h4 class="section-title">Cloud Services</h4>
                <div id="services-container">
                    <?php $services = $siteSettings['services'] ?? []; ?>
                    <?php foreach($services as $srv): ?>
                        <div class="dynamic-row" style="position: relative; margin-bottom: 20px; background: rgba(255,255,255,0.02); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);">
                            <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 15px; top: 15px;" class="btn-remove">X</button>
                            
                            <div style="display: flex; gap: 15px; margin-bottom: 10px; padding-right: 40px;">
                                <div style="flex: 2;">
                                    <input type="text" name="services[title_en][]" value="<?= htmlspecialchars($srv['title_en'] ?? '') ?>" class="form-control" placeholder="Service Title" required>
                                </div>
                                <div style="flex: 1; max-width: 200px;">
                                    <input type="text" name="services[icon][]" value="<?= htmlspecialchars($srv['icon'] ?? 'fa-solid fa-cloud') ?>" class="form-control" placeholder="Icon (fa-solid fa-cloud)">
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 15px;">
                                <textarea name="services[description_en][]" class="form-control" placeholder="Description" rows="3" required style="flex: 1;"><?= htmlspecialchars($srv['description_en'] ?? '') ?></textarea>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" onclick="addDynamicRow('services-container', `<div class='dynamic-row' style='position: relative; margin-bottom: 20px; background: rgba(255,255,255,0.02); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05);'><button type='button' onclick='this.parentElement.remove()' style='position: absolute; right: 15px; top: 15px;' class='btn-remove'>X</button><div style='display: flex; gap: 15px; margin-bottom: 10px; padding-right: 40px;'><div style='flex: 2;'><input type='text' name='services[title_en][]' class='form-control' placeholder='Service Title' required></div><div style='flex: 1; max-width: 200px;'><input type='text' name='services[icon][]' class='form-control' placeholder='Icon (fa-solid fa-cloud)'></div></div><div style='display: flex; gap: 15px;'><textarea name='services[description_en][]' class='form-control' placeholder='Description' rows='3' required style='flex: 1;'></textarea></div></div>`)" class="btn-add" style="margin-bottom: 30px;">+ Add Service</button>
            </div>

            <!-- Submit Button (Sticky to bottom of form) -->
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="margin: 0; padding: 12px 30px; font-size: 1.1em; background: #10b981; border-color: #10b981;"><i class="fa-solid fa-save"></i> Save All Site Content</button>
            </div>
        </form>
    </div>

    <style>
        .btn-remove {
            background: rgba(220, 53, 69, 0.2); 
            color: #ef4444; 
            border: 1px solid rgba(220, 53, 69, 0.5); 
            padding: 8px 12px; 
            border-radius: 4px; 
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-remove:hover {
            background: #dc3545;
            color: #fff;
        }
        .btn-add {
            background: rgba(108, 117, 125, 0.2); 
            color: #cbd5e1; 
            border: 1px dashed rgba(108, 117, 125, 0.5); 
            padding: 8px 20px; 
            border-radius: 4px; 
            margin-bottom: 10px; 
            cursor: pointer;
            transition: all 0.3s;
            width: 100%;
        }
        .btn-add:hover {
            background: rgba(108, 117, 125, 0.5);
            color: #fff;
        }
    </style>

    <script>
        function switchTab(tabId, element) {
            // Remove active from all tabs
            document.querySelectorAll('.settings-tab').forEach(t => t.classList.remove('active'));
            // Add active to clicked tab
            element.classList.add('active');
            
            // Hide all sections
            document.querySelectorAll('.settings-section').forEach(s => s.classList.remove('active'));
            // Show targeted section
            document.getElementById('tab-' + tabId).classList.add('active');
        }

        function addDynamicRow(containerId, inputsHtml) {
            const container = document.getElementById(containerId);
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
            div.innerHTML = inputsHtml + `<button type="button" onclick="this.parentElement.remove()" class="btn-remove">X</button>`;
            container.appendChild(div);
        }

        function addTestimonialRow() {
            const container = document.getElementById('testimonials-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'position: relative; margin-bottom: 15px;';
            div.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 15px; top: 15px;" class="btn-remove">X</button>
                <div style="display: flex; gap: 10px; margin-bottom: 10px; padding-right: 40px;">
                    <input type="text" name="testimonials[client_name][]" class="form-control" placeholder="Client Name" required style="flex: 1;">
                    <input type="text" name="testimonials[client_role][]" class="form-control" placeholder="Role / Company" style="flex: 1;">
                </div>
                <textarea name="testimonials[feedback][]" class="form-control" placeholder="Review Text..." rows="3" required></textarea>`;
            container.appendChild(div);
        }

        function addTechCategoryRow() {
            const container = document.getElementById('tech-categories-container');
            const div = document.createElement('div');
            div.className = 'dynamic-row';
            div.style.cssText = 'position: relative; margin-bottom: 15px;';
            div.innerHTML = `
                <button type="button" onclick="this.parentElement.remove()" style="position: absolute; right: 15px; top: 15px;" class="btn-remove">X</button>
                <div style="display: flex; gap: 10px; margin-bottom: 10px; padding-right: 40px;">
                    <input type="text" name="tech_categories[name][]" class="form-control" placeholder="Category Name" required style="flex: 2;">
                    <input type="text" name="tech_categories[icon][]" class="form-control" placeholder="Icon" value="fa-solid fa-layer-group" style="flex: 1;">
                </div>
                <textarea name="tech_categories[skills][]" class="form-control" placeholder="Skills (comma separated)..." rows="2" required></textarea>`;
            container.appendChild(div);
        }
    </script>

    <!-- إعدادات الأمان (القديم) -->
    <div class="stat-card" style="flex: 1; min-width: 300px; padding: 30px; border-top: 4px solid #007bff;">
        <form method="POST" action="{{ route('admin.settings.update') }}" class="cv-form">
            @csrf
            <input type="hidden" name="form_type" value="credentials">
            <h3 style="margin-top: 0; margin-bottom: 20px; color: #007bff;">Admin Credentials</h3>
            
            <div style="margin-bottom: 15px;">
                <label>Username</label>
                <input type="text" name="admin_username" value="<?= htmlspecialchars($_ENV['ADMIN_USERNAME'] ?? '') ?>" class="form-control" required style="max-width: 100%;">
            </div>
            <div style="margin-bottom: 30px;">
                <label>Password</label>
                <input type="text" name="admin_password" value="<?= htmlspecialchars($_ENV['ADMIN_PASSWORD'] ?? '') ?>" class="form-control" required style="max-width: 100%;">
            </div>
            <button type="submit" class="btn btn-primary" style="margin: 0; width: 100%; padding: 12px; font-size: 1em;">Update Credentials</button>
        </form>
    </div>
</div>
@endsection
