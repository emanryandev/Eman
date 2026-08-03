document.addEventListener('DOMContentLoaded', () => {
    fetchProjects();
});

async function fetchProjects() {
    try {
        const response = await fetch('/api/projects');
        const projects = await response.json();
        
        const grid = document.getElementById('project-grid');
        grid.innerHTML = '';
        
        projects.forEach(project => {
            const card = document.createElement('div');
            card.className = `project-card ${project.ui_config?.hover_effect || ''}`;
            
            if(project.ui_config) {
                card.style.animationName = project.ui_config.enter_animation === 'fade-in-up' ? 'fadeInUp' : 'glitchReveal';
                card.style.animationDuration = `${project.ui_config.duration_ms}ms`;
                card.style.animationDelay = `${project.ui_config.delay_ms}ms`;
            }

            card.innerHTML = `
                <h3>${project.title}</h3>
                <p style="color: #8b949e; font-size: 0.9em;">${project.role}</p>
                <p>${project.description}</p>
                <div style="margin-top: 15px;">
                    <a href="${project.repository_url}" target="_blank" style="color: #58a6ff; text-decoration: none;">Repo</a> | 
                    <a href="${project.live_url}" target="_blank" style="color: #58a6ff; text-decoration: none;">Live</a>
                </div>
            `;
            grid.appendChild(card);
        });
        window.portfolioProjects = projects;
    } catch (error) {
        console.error('Error fetching projects:', error);
    }
}