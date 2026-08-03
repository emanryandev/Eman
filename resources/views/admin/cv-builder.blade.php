@extends("admin.layout")
@section("content")
<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
    <div>
        <h1 style="margin:0;" class="i18n" data-en="CV Builder (Visual & ATS)" data-ar="بناء السيرة الذاتية">CV Builder (Visual & ATS)</h1>
        <p style="color: #666; margin: 5px 0 0 0;" class="i18n" data-en="Edit your data on the left. Drag and drop sections on the right paper preview like Lego blocks!" data-ar="قم بتعديل بياناتك على اليسار. اسحب وأفلت الأقسام على الورقة لترتيبها!">Edit your data on the left. Drag and drop sections on the right paper preview like Lego blocks!</p>
    </div>
    <a href="/cv/download/<?= (string)($cvData['id'] ?? '') ?>" class="btn btn-primary i18n" data-en="📄 Download Live PDF" data-ar="📄 تحميل ملف الـ PDF" target="_blank" style="margin: 0; background: #28a745;">📄 Download Live PDF</a>
</div>

@if (session('success'))
    <div style="background: #d4edda; color: #155724; padding: 15px; margin-bottom: 20px; border-radius: 4px; border: 1px solid #c3e6cb;" class="i18n" data-en="CV settings saved successfully!" data-ar="تم حفظ إعدادات السيرة الذاتية بنجاح!">
        {{ session('success') }}
    </div>
@endif

<div class="builder-layout">
<div class="editor-panel">
<form class="cv-form" method="POST" action="/admin/cv-builder" enctype="multipart/form-data">
    <hr style="margin: 0 0 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="🎨 Theme & Styling" data-ar="🎨 المظهر والتصميم">🎨 Theme & Styling</h3>
    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
        <div style="flex: 1;">
            <label class="i18n" data-en="Primary Color" data-ar="اللون الأساسي">Primary Color</label>
            <input type="color" name="primary_color" value="<?= htmlspecialchars($cvData['layout_preferences']['primary_color'] ?? '#000000') ?>" style="width: 100%; height: 40px; border: 1px solid #ccc; border-radius: 4px; cursor: pointer;">
        </div>
        <div style="flex: 1;">
            <label class="i18n" data-en="Font Family" data-ar="نوع الخط">Font Family</label>
            <select name="font_family" class="form-control" style="height: 40px;">
                <option value="Helvetica" <?= ($cvData['layout_preferences']['font_family'] ?? '') === 'Helvetica' ? 'selected' : '' ?>>Helvetica (ATS Standard)</option>
                <option value="Times-Roman" <?= ($cvData['layout_preferences']['font_family'] ?? '') === 'Times-Roman' ? 'selected' : '' ?>>Times New Roman</option>
                <option value="Courier" <?= ($cvData['layout_preferences']['font_family'] ?? '') === 'Courier' ? 'selected' : '' ?>>Courier</option>
            </select>
        </div>
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="📄 Custom PDF CV (Optional)" data-ar="📄 ملف سيرة ذاتية جاهز (اختياري)">📄 Custom PDF CV (Optional)</h3>
    <div style="margin-bottom: 20px;">
        <label class="i18n" data-en="Upload Custom PDF" data-ar="رفع ملف PDF مخصص">Upload Custom PDF</label>
        <input type="file" name="custom_cv" accept=".pdf" class="form-control" style="background: transparent;">
        <small style="color: #666;" class="i18n" data-en="If uploaded, visitors will download this file instead of the auto-generated one." data-ar="إذا تم الرفع، سيتم تحميل هذا الملف للزوار بدلاً من السيرة الذاتية المولدة تلقائياً.">If uploaded, visitors will download this file instead of the auto-generated one.</small>
        <?php if (!empty($cvData['custom_cv_url'])): ?>
            <div style="margin-top: 10px; font-size: 0.9em;"><a href="<?= htmlspecialchars($cvData['custom_cv_url']) ?>" target="_blank" style="color: #3b82f6;"><i class="fa-solid fa-eye"></i> عرض الملف المرفوع حالياً</a></div>
        <?php endif; ?>
    </div>

    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <input type="hidden" name="section_order" id="section_order_input" value="<?= htmlspecialchars(implode(',', (array)($cvData['layout_preferences']['section_order'] ?? ['summary','skills','experience','education','certifications']))) ?>">
    <label class="i18n" data-en="Full Name" data-ar="الاسم الكامل">Full Name</label>
    <input type="text" name="full_name" value="<?= htmlspecialchars($cvData['personal_info']['full_name'] ?? '') ?>" class="form-control" required>
    
    <label class="i18n" data-en="Job Title" data-ar="المسمى الوظيفي">Job Title</label>
    <input type="text" name="title" value="<?= htmlspecialchars($cvData['personal_info']['title'] ?? '') ?>" class="form-control" required>
    
    <label class="i18n" data-en="Contact Email" data-ar="البريد الإلكتروني">Contact Email</label>
    <input type="email" name="email" value="<?= htmlspecialchars($cvData['personal_info']['email'] ?? '') ?>" class="form-control" required>
    
    <label class="i18n" data-en="Phone Number" data-ar="رقم الهاتف">Phone Number</label>
    <input type="text" name="phone" value="<?= htmlspecialchars($cvData['personal_info']['phone'] ?? '') ?>" class="form-control">
    
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="Header Links & Contact Info" data-ar="روابط الهيدر ومعلومات الاتصال">Header Links & Contact Info</h3>
    <p style="color: #666; font-size: 0.9em;" class="i18n" data-en="Add dynamic links (LinkedIn, GitHub) or Location." data-ar="أضف روابطك (LinkedIn, GitHub) أو موقعك كحقول ديناميكية.">Add dynamic links (LinkedIn, GitHub) or Location.</p>
    
    <div id="links-container">
        <?php $links = $cvData['personal_info']['links'] ?? []; ?>
        <?php foreach($links as $link): ?>
            <div class="link-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="links[label][]" value="<?= htmlspecialchars($link['label'] ?? '') ?>" class="form-control" placeholder="Label (e.g. LinkedIn, Location)" style="flex: 1;" required>
                <input type="text" name="links[icon][]" value="<?= htmlspecialchars($link['icon'] ?? '') ?>" class="form-control" placeholder="Icon (e.g. fa-brands fa-linkedin)" style="flex: 1;">
                <input type="text" name="links[value][]" value="<?= htmlspecialchars($link['value'] ?? '') ?>" class="form-control" placeholder="Value or URL" style="flex: 2;" required>
                <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" onclick="addLinkRow()" style="background: #6c757d; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px; margin-bottom: 20px;" class="i18n" data-en="+ Add Contact Link" data-ar="+ إضافة رابط اتصال">+ Add Contact Link</button>
    
    <label class="i18n" data-en="Professional Summary" data-ar="نبذة مهنية">Professional Summary</label>
    <textarea name="summary" rows="6" class="form-control" required><?= htmlspecialchars($cvData['summary'] ?? '') ?></textarea>
    
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="Core Skills" data-ar="المهارات الأساسية">Core Skills</h3>
    <p style="color: #666; font-size: 0.9em;" class="i18n" data-en="Add skills as categories and comma-separated keywords." data-ar="أضف المهارات كفئات وكلمات مفتاحية مفصولة بفاصلة.">Add skills as categories and comma-separated keywords.</p>
    
    <div id="skills-container">
        <?php $skills = $cvData['skills'] ?? []; ?>
        <?php foreach($skills as $skill): ?>
            <div class="skill-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="skills[category][]" value="<?= htmlspecialchars($skill['category'] ?? '') ?>" class="form-control" placeholder="Category (e.g. CI/CD)" style="flex: 1;" required>
                <input type="text" name="skills[keywords][]" value="<?= htmlspecialchars(implode(', ', (array)($skill['keywords'] ?? []))) ?>" class="form-control" placeholder="Keywords: Docker, Jenkins..." style="flex: 2;" required>
                <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" onclick="addSkillRow()" style="background: #6c757d; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px; margin-bottom: 20px;" class="i18n" data-en="+ Add Skill Category" data-ar="+ إضافة فئة مهارات">+ Add Skill Category</button>
    
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="Work Experience" data-ar="خبرات العمل">Work Experience</h3>
    
    <div id="experiences-container">
        <?php $experiences = $cvData['experience'] ?? []; ?>
        <?php foreach($experiences as $exp): ?>
            <div class="exp-block" style="background: #e9ecef; padding: 15px; margin-bottom: 15px; border-radius: 6px; position: relative;">
                <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="position: absolute; right: 15px; top: 15px; background: #dc3545; color:#fff; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">X</button>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" name="exp[job_title][]" value="<?= htmlspecialchars($exp['job_title'] ?? '') ?>" class="form-control" placeholder="Job Title" style="flex: 1;" required>
                    <input type="text" name="exp[company][]" value="<?= htmlspecialchars($exp['company'] ?? '') ?>" class="form-control" placeholder="Company Name" style="flex: 1;" required>
                </div>
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" name="exp[start_date][]" value="<?= htmlspecialchars($exp['start_date'] ?? '') ?>" class="form-control" placeholder="Start Date (MM/YYYY)" style="flex: 1;" required>
                    <input type="text" name="exp[end_date][]" value="<?= htmlspecialchars($exp['end_date'] ?? '') ?>" class="form-control" placeholder="End Date (or Present)" style="flex: 1;" required>
                    <input type="text" name="exp[location][]" value="<?= htmlspecialchars($exp['location'] ?? '') ?>" class="form-control" placeholder="Location" style="flex: 1;">
                </div>
                <textarea name="exp[achievements][]" rows="4" class="form-control" placeholder="Achievements (Write each point in a new line)"><?= htmlspecialchars(implode("\n", (array)($exp['achievements'] ?? []))) ?></textarea>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" onclick="addExperienceRow()" style="background: #17a2b8; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px; margin-bottom: 20px;" class="i18n" data-en="+ Add Experience Block" data-ar="+ إضافة خبرة عمل">+ Add Experience Block</button>
    
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="Education" data-ar="التعليم">Education</h3>
    
    <div id="education-container">
        <?php $education = $cvData['education'] ?? []; ?>
        <?php foreach($education as $edu): ?>
            <div class="edu-row" style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="edu[institution][]" value="<?= htmlspecialchars($edu['institution'] ?? '') ?>" class="form-control" placeholder="Institution" style="flex: 2;" required>
                <input type="text" name="edu[degree][]" value="<?= htmlspecialchars($edu['degree'] ?? '') ?>" class="form-control" placeholder="Degree" style="flex: 2;" required>
                <input type="text" name="edu[graduation_year][]" value="<?= htmlspecialchars($edu['graduation_year'] ?? '') ?>" class="form-control" placeholder="Graduation Year" style="flex: 1;" required>
                <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" onclick="addEducationRow()" style="background: #28a745; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px; margin-bottom: 20px;" class="i18n" data-en="+ Add Education" data-ar="+ إضافة تعليم">+ Add Education</button>
    
    <hr style="margin: 30px 0; border: 0; border-top: 1px solid #ccc;">
    <h3 class="i18n" data-en="Certifications" data-ar="الشهادات">Certifications</h3>
    
    <div id="certifications-container">
        <?php $certifications = $cvData['certifications'] ?? []; ?>
        <?php foreach($certifications as $cert): ?>
            <div class="cert-row" style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 6px; margin-bottom: 10px; border: 1px solid #ccc;">
                <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                    <input type="text" name="cert[name][]" value="<?= htmlspecialchars($cert['name'] ?? '') ?>" class="form-control" placeholder="Certification Name" style="flex: 2;" required>
                    <input type="text" name="cert[issuer][]" value="<?= htmlspecialchars($cert['issuer'] ?? '') ?>" class="form-control" placeholder="Issuer (e.g. AWS)" style="flex: 2;" required>
                    <input type="text" name="cert[date][]" value="<?= htmlspecialchars($cert['date'] ?? '') ?>" class="form-control" placeholder="Date (e.g. 2023)" style="flex: 1;">
                    <button type="button" onclick="this.parentElement.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <input type="hidden" name="cert_existing_image[]" value="<?= htmlspecialchars($cert['image'] ?? '') ?>">
                    <?php if(!empty($cert['image'])): ?>
                        <img src="<?= htmlspecialchars($cert['image']) ?>" style="width: 40px; height: 40px; object-fit: contain; border-radius: 4px; background: #fff; padding: 2px;">
                    <?php endif; ?>
                    <label style="margin: 0; font-size: 0.9em; white-space: nowrap;" class="i18n" data-en="Badge Image:" data-ar="صورة الشارة:">Badge Image:</label>
                    <input type="file" name="cert_image[]" accept="image/*" class="form-control" style="background: transparent; padding: 5px;">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" onclick="addCertificationRow()" style="background: #ffc107; color:#000; border:none; padding:10px; cursor:pointer; border-radius:4px; margin-bottom: 20px;" class="i18n" data-en="+ Add Certification" data-ar="+ إضافة شهادة">+ Add Certification</button>

    <script>
    function addLinkRow() {
        const container = document.getElementById('links-container');
        const row = document.createElement('div');
        row.className = 'link-row';
        row.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
        row.innerHTML = `<input type="text" name="links[label][]" class="form-control" placeholder="Label (e.g. LinkedIn, Location)" style="flex: 1;" required>
                         <input type="text" name="links[icon][]" class="form-control" placeholder="Icon (e.g. fa-brands fa-linkedin)" style="flex: 1;">
                         <input type="text" name="links[value][]" class="form-control" placeholder="Value or URL" style="flex: 2;" required>
                         <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>`;
        container.appendChild(row);
        updateLivePreview();
    }

    function addSkillRow() {
        const container = document.getElementById('skills-container');
        const row = document.createElement('div');
        row.className = 'skill-row';
        row.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
        row.innerHTML = `<input type="text" name="skills[category][]" class="form-control" placeholder="Category (e.g. CI/CD)" style="flex: 1;" required>
                         <input type="text" name="skills[keywords][]" class="form-control" placeholder="Keywords: Docker, Jenkins..." style="flex: 2;" required>
                         <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>`;
        container.appendChild(row);
        updateLivePreview();
    }

    function addExperienceRow() {
        const container = document.getElementById('experiences-container');
        const block = document.createElement('div');
        block.className = 'exp-block';
        block.style.cssText = 'background: #e9ecef; padding: 15px; margin-bottom: 15px; border-radius: 6px; position: relative;';
        block.innerHTML = `
            <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="position: absolute; right: 15px; top: 15px; background: #dc3545; color:#fff; border:none; padding:5px 10px; cursor:pointer; border-radius:4px;">X</button>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;"><input type="text" name="exp[job_title][]" class="form-control" placeholder="Job Title" style="flex: 1;" required><input type="text" name="exp[company][]" class="form-control" placeholder="Company Name" style="flex: 1;" required></div>
            <div style="display: flex; gap: 10px; margin-bottom: 10px;"><input type="text" name="exp[start_date][]" class="form-control" placeholder="Start Date (MM/YYYY)" style="flex: 1;" required><input type="text" name="exp[end_date][]" class="form-control" placeholder="End Date (or Present)" style="flex: 1;" required><input type="text" name="exp[location][]" class="form-control" placeholder="Location" style="flex: 1;"></div>
            <textarea name="exp[achievements][]" rows="4" class="form-control" placeholder="Achievements (Write each point in a new line)"></textarea>
        `;
        container.appendChild(block);
        updateLivePreview();
    }

    function addEducationRow() {
        const container = document.getElementById('education-container');
        const row = document.createElement('div');
        row.className = 'edu-row';
        row.style.cssText = 'display: flex; gap: 10px; margin-bottom: 10px;';
        row.innerHTML = `
            <input type="text" name="edu[institution][]" class="form-control" placeholder="Institution" style="flex: 2;" required>
            <input type="text" name="edu[degree][]" class="form-control" placeholder="Degree" style="flex: 2;" required>
            <input type="text" name="edu[graduation_year][]" class="form-control" placeholder="Graduation Year" style="flex: 1;" required>
            <button type="button" onclick="this.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>`;
        container.appendChild(row);
        updateLivePreview();
    }

    function addCertificationRow() {
        const container = document.getElementById('certifications-container');
        const row = document.createElement('div');
        row.className = 'cert-row';
        row.style.cssText = 'background: rgba(255,255,255,0.05); padding: 15px; border-radius: 6px; margin-bottom: 10px; border: 1px solid #ccc;';
        row.innerHTML = `
            <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                <input type="text" name="cert[name][]" class="form-control" placeholder="Certification Name" style="flex: 2;" required>
                <input type="text" name="cert[issuer][]" class="form-control" placeholder="Issuer (e.g. AWS)" style="flex: 2;" required>
                <input type="text" name="cert[date][]" class="form-control" placeholder="Date (e.g. 2023)" style="flex: 1;">
                <button type="button" onclick="this.parentElement.parentElement.remove(); updateLivePreview();" style="background: #dc3545; color:#fff; border:none; padding:10px; cursor:pointer; border-radius:4px;">X</button>
            </div>
            <div style="display: flex; align-items: center; gap: 10px;">
                <input type="hidden" name="cert_existing_image[]" value="">
                <label style="margin: 0; font-size: 0.9em; white-space: nowrap;">Badge Image:</label>
                <input type="file" name="cert_image[]" accept="image/*" class="form-control" style="background: transparent; padding: 5px;">
            </div>`;
        container.appendChild(row);
        updateLivePreview();
    }
    </script>

    <button type="submit" class="btn btn-primary i18n" data-en="Save Configuration" data-ar="حفظ الإعدادات">Save Configuration</button>
</form>
</div> <!-- End Editor Panel -->

<!-- Live Preview Panel (Lego Blocks) -->
<div class="preview-panel">
    <div class="a4-paper" id="a4-preview">
        <div class="a4-header">
            <h1 id="preview-name"><?= htmlspecialchars($cvData['personal_info']['full_name'] ?? 'Your Name') ?></h1>
            <h3 id="preview-title" style="margin: 0 0 10px 0; color: #555; font-size: 14pt;"><?= htmlspecialchars($cvData['personal_info']['title'] ?? 'Job Title') ?></h3>
            <p id="preview-contact" style="font-size: 11pt; color: #555; margin: 0;"></p>
        </div>
        
        <div id="cv-sections-container">
            <?php 
            $order = (array)($cvData['layout_preferences']['section_order'] ?? ['summary', 'skills', 'experience', 'education', 'certifications']);
            foreach($order as $sec): 
            ?>
                <div class="cv-section" data-section="<?= $sec ?>">
                    <h2><?= ucfirst($sec) ?></h2>
                    <div id="preview-<?= $sec ?>"></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</div> <!-- End Builder Layout -->

<script>
// Make preview blocks draggable using SortableJS (already loaded in layout)
new Sortable(document.getElementById('cv-sections-container'), {
    animation: 150,
    ghostClass: 'sortable-ghost',
    onEnd: function () {
        const sections = document.querySelectorAll('.cv-section');
        const newOrder = Array.from(sections).map(sec => sec.getAttribute('data-section'));
        document.getElementById('section_order_input').value = newOrder.join(',');
    }
});

// Comprehensive Live Data Sync function
function updateLivePreview() {
    // Apply Styles
    const pColor = document.querySelector('input[name="primary_color"]').value;
    const pFont = document.querySelector('select[name="font_family"]').value;
    const paper = document.getElementById('a4-preview');
    paper.style.fontFamily = pFont + ', sans-serif';
    paper.style.color = '#000';
    document.querySelector('.a4-header').style.borderBottom = `3px solid ${pColor}`;
    document.querySelectorAll('.cv-section h2').forEach(h2 => { h2.style.color = pColor; h2.style.borderBottom = `2px solid ${pColor}`; });
    document.getElementById('preview-title').style.color = pColor;

    // Header Info
    const name = document.querySelector('input[name="full_name"]').value;
    document.getElementById('preview-name').innerText = name || 'Your Name';
    document.getElementById('preview-title').innerText = document.querySelector('input[name="title"]').value || 'Job Title';
    
    let contactHtml = [];
    const email = document.querySelector('input[name="email"]').value;
    if(email) contactHtml.push(`<span>${email}</span>`);
    const phone = document.querySelector('input[name="phone"]').value;
    if(phone) contactHtml.push(`<span>${phone}</span>`);
    
    document.querySelectorAll('.link-row').forEach(row => {
        const val = row.querySelector('input[name="links[value][]"]').value;
        if (val) contactHtml.push(`<span>${val}</span>`);
    });
    document.getElementById('preview-contact').innerHTML = contactHtml.length > 0 ? contactHtml.join(' | ') : 'Email | Phone';

    // Summary
    const summaryVal = document.querySelector('textarea[name="summary"]').value;
    const summaryContainer = document.getElementById('preview-summary');
    if (summaryContainer) {
        summaryContainer.innerHTML = `<p style="margin: 0;">${summaryVal.replace(/\n/g, '<br>')}</p>`;
    }

    // Skills
    const skillsContainer = document.getElementById('preview-skills');
    if (skillsContainer) {
        let html = '<ul style="margin: 0 0 15px 0; padding-left: 20px;">';
        document.querySelectorAll('.skill-row').forEach(row => {
            const cat = row.querySelector('input[name="skills[category][]"]').value;
            const keys = row.querySelector('input[name="skills[keywords][]"]').value;
            if (cat || keys) html += `<li style="margin-bottom: 5px;"><strong>${cat}:</strong> ${keys}</li>`;
        });
        html += '</ul>';
        skillsContainer.innerHTML = html === '<ul style="margin: 0 0 15px 0; padding-left: 20px;"></ul>' ? '<p style="color:#777;font-style:italic;">Add skills on the left...</p>' : html;
    }

    // Experience
    const expContainer = document.getElementById('preview-experience');
    if (expContainer) {
        let html = '';
        document.querySelectorAll('.exp-block').forEach(block => {
            const title = block.querySelector('input[name="exp[job_title][]"]').value;
            const comp = block.querySelector('input[name="exp[company][]"]').value;
            const start = block.querySelector('input[name="exp[start_date][]"]').value;
            const end = block.querySelector('input[name="exp[end_date][]"]').value;
            const loc = block.querySelector('input[name="exp[location][]"]').value;
            const ach = block.querySelector('textarea[name="exp[achievements][]"]').value;
            
            if (title || comp) {
                html += `<div style="margin-bottom: 15px;">
                    <h3 style="font-size: 12pt; margin: 0 0 5px 0;">${title} at ${comp}</h3>
                    <p style="font-style: italic; margin-bottom: 5px; font-size: 11pt; color: #555;">${loc} | ${start} - ${end}</p>`;
                if (ach) {
                    html += `<ul style="margin: 0 0 15px 0; padding-left: 20px;">`;
                    ach.split('\n').forEach(line => { if (line.trim()) html += `<li style="margin-bottom: 5px;">${line}</li>`; });
                    html += `</ul>`;
                }
                html += `</div>`;
            }
        });
        expContainer.innerHTML = html || '<p style="color:#777;font-style:italic;">Add experience on the left...</p>';
    }

    // Education
    const eduContainer = document.getElementById('preview-education');
    if (eduContainer) {
        let html = '';
        document.querySelectorAll('.edu-row').forEach(row => {
            const inst = row.querySelector('input[name="edu[institution][]"]').value;
            const deg = row.querySelector('input[name="edu[degree][]"]').value;
            const year = row.querySelector('input[name="edu[graduation_year][]"]').value;
            if (inst || deg) html += `<div style="margin-bottom: 10px;"><h3 style="font-size: 12pt; margin: 0 0 5px 0;">${deg}</h3><p style="margin: 0; font-size: 11pt; color: #555;">${inst} | Graduated: ${year}</p></div>`;
        });
        eduContainer.innerHTML = html || '<p style="color:#777;font-style:italic;">Add education on the left...</p>';
    }

    // Certifications
    const certContainer = document.getElementById('preview-certifications');
    if (certContainer) {
        let html = '<ul style="margin: 0 0 15px 0; padding-left: 20px;">';
        document.querySelectorAll('.cert-row').forEach(row => {
            const name = row.querySelector('input[name="cert[name][]"]').value;
            const iss = row.querySelector('input[name="cert[issuer][]"]').value;
            const date = row.querySelector('input[name="cert[date][]"]').value;
            if (name) html += `<li style="margin-bottom: 5px;"><strong>${name}</strong> - ${iss} (${date})</li>`;
        });
        html += '</ul>';
        certContainer.innerHTML = html === '<ul style="margin: 0 0 15px 0; padding-left: 20px;"></ul>' ? '<p style="color:#777;font-style:italic;">Add certifications on the left...</p>' : html;
    }
}

// Listen for ANY change in the form
document.querySelector('.cv-form').addEventListener('input', updateLivePreview);
// Initial render
document.addEventListener('DOMContentLoaded', updateLivePreview);
</script>
@endsection
