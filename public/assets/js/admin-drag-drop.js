let globalProjects = [];

document.addEventListener('DOMContentLoaded', () => {
    fetchAdminProjects();
    setupFilters();
    setupModal();
});

async function fetchAdminProjects() {
    try {
        const response = await fetch('/admin/projects?ajax=1');
        globalProjects = await response.json();
        renderAdminProjects(globalProjects);
        populateCategories(globalProjects);
    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}

function renderAdminProjects(projects) {
    const list = document.getElementById('sortable-projects');
    if (!list) return; // Prevent crash if list is not on the page
    list.innerHTML = '';
    
    projects.forEach(project => {
            const item = document.createElement('div');
            item.className = 'project-item';
            // Use Eloquent ID directly
            const id = project.id;
            item.dataset.id = id; 
            item.dataset.title = project.title.toLowerCase();
            item.dataset.category = project.category || 'all';
            
            const status = project.status || 'published';
            const statusClass = status === 'published' ? 'status-published' : 'status-draft';
            const statusText = status === 'published' ? (document.documentElement.lang==='ar'?'منشور':'Published') : (document.documentElement.lang==='ar'?'مسودة':'Draft');
            
            const techStackHtml = (project.tech_stack || []).map(t => `<span class="tech-pill">${t}</span>`).join('');
            
            item.innerHTML = `
                <div class="project-info" style="display: flex; gap: 15px; align-items: flex-start;">
                    ${project.image_url ? `<img src="${project.image_url}" style="width: 70px; height: 70px; border-radius: 8px; object-fit: cover; flex-shrink: 0; border: 1px solid #eee;">` : `<div style="width: 70px; height: 70px; border-radius: 8px; background: #f4f6f9; display: flex; align-items: center; justify-content: center; font-size: 1.8em; border: 1px solid #eee; flex-shrink: 0;">💻</div>`}
                    <div>
                        <strong style="font-size: 1.2em; display: block; margin-bottom: 8px;">${project.title}</strong>
                        <div style="margin-bottom: 10px;">${techStackHtml}</div>
                        <span style="font-size: 0.85em; color: #666; background: #f8f9fa; padding: 3px 8px; border-radius: 4px; margin-right: 5px;">📂 ${project.category || 'Uncategorized'}</span>
                        <span style="font-size: 0.85em; color: #f59e0b; background: rgba(245,158,11,0.1); padding: 3px 8px; border-radius: 4px; margin-right: 5px;">⭐ ${project.stars || 0}</span>
                        <span style="font-size: 0.85em; color: #10b981; background: rgba(16,185,129,0.1); padding: 3px 8px; border-radius: 4px;">👏 ${project.claps || 0}</span>
                    </div>
                </div>
                <div class="project-actions">
                    <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                        <a href="/admin/projects?action=toggle_status&id=${id}" class="status-badge ${statusClass}" title="Click to toggle status">${statusText}</a>
                        <button type="button" style="background:#17a2b8; color:#fff; border:none; padding:5px 10px; border-radius:4px; cursor:pointer; font-size: 0.85em;" onclick="openPreview('${id}')">👁️ Preview</button>
                        <a href="/admin/projects?action=edit&id=${id}" style="color: #007bff; text-decoration: none; font-size: 0.9em; font-weight: bold;">Edit</a>
                        <a href="/admin/projects?action=delete&id=${id}" onclick="return confirm('Are you sure you want to delete this project?')" style="color: #dc3545; text-decoration: none; font-size: 0.9em; font-weight: bold;">Delete</a>
                    </div>
                    <span style="color:#888; font-size:1.5em;" class="drag-handle">☰</span>
                </div>
            `;
            list.appendChild(item);
        });

        // Initialize SortableJS
        new Sortable(list, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'sortable-ghost',
            onEnd: function () { saveNewOrder(); }
        });
}

// Filtering Logic
function setupFilters() {
    const searchInput = document.getElementById('search-project');
    const categorySelect = document.getElementById('filter-category');
    if(searchInput && categorySelect) {
        const filterFn = () => {
            const term = searchInput.value.toLowerCase();
            const cat = categorySelect.value;
            document.querySelectorAll('.project-item').forEach(item => {
                const matchesSearch = item.dataset.title.includes(term);
                const matchesCat = cat === 'all' || item.dataset.category === cat;
                item.style.display = (matchesSearch && matchesCat) ? 'flex' : 'none';
            });
        };
        searchInput.addEventListener('input', filterFn);
        categorySelect.addEventListener('change', filterFn);
    }
}

function populateCategories(projects) {
    const select = document.getElementById('filter-category');
    if(!select) return;
    const categories = new Set(projects.map(p => p.category).filter(c => c));
    select.innerHTML = `<option value="all" class="i18n" data-en="All Categories" data-ar="جميع الفئات">${document.documentElement.lang==='ar'?'جميع الفئات':'All Categories'}</option>`;
    categories.forEach(cat => {
        const opt = document.createElement('option');
        opt.value = cat; opt.innerText = cat;
        select.appendChild(opt);
    });
}

// Modal Logic
function setupModal() {
    const modal = document.getElementById('preview-modal');
    const closeBtn = document.querySelector('.close-modal');
    if(closeBtn) {
        closeBtn.onclick = () => modal.style.display = 'none';
        window.onclick = (e) => { if (e.target == modal) modal.style.display = 'none'; }
    }
}

window.openPreview = function(id) {
    // Cast id to number since Eloquent IDs are integers
    const project = globalProjects.find(p => p.id == id);
    if(project) {
        const imgEl = document.getElementById('modal-img');
        if(project.image_url) { imgEl.src = project.image_url; imgEl.style.display = 'block'; }
        else { imgEl.style.display = 'none'; }
        
        document.getElementById('modal-title').innerText = project.title;
        document.getElementById('modal-desc').innerText = project.description;
        document.getElementById('modal-badges').innerHTML = (project.tech_stack || []).map(t => `<span class="tech-pill">${t}</span>`).join('');
        document.getElementById('preview-modal').style.display = 'flex';
        const linkBtn = document.getElementById('modal-link');
        if(project.live_url && project.live_url !== '#') { linkBtn.href = project.live_url; linkBtn.style.display = 'inline-block'; } 
        else { linkBtn.style.display = 'none'; }
    }
}

async function saveNewOrder() {
    const items = document.querySelectorAll('.project-item');
    const order = Array.from(items).map(item => item.dataset.id);

    try {
        const response = await fetch('/admin/projects/reorder', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ order })
        });
    } catch (error) {
        console.error('Error saving order:', error);
    }
}