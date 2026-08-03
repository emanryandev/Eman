const btnToggle = document.getElementById('btn-toggle-terminal');
const viewStandard = document.getElementById('view-standard');
const viewTerminal = document.getElementById('view-terminal');
const termInput = document.getElementById('terminal-input');
const termOutput = document.getElementById('terminal-output');

btnToggle.addEventListener('click', () => {
    if (viewStandard.classList.contains('view-active')) {
        viewStandard.classList.replace('view-active', 'view-hidden');
        viewTerminal.classList.replace('view-hidden', 'view-active');
        btnToggle.innerText = 'Exit_CLI';
        termInput.focus();
    } else {
        viewTerminal.classList.replace('view-active', 'view-hidden');
        viewStandard.classList.replace('view-hidden', 'view-active');
        btnToggle.innerText = '_CLI Mode';
    }
});

termInput.addEventListener('keydown', (e) => {
    if (e.key === 'Enter') {
        const command = termInput.value.trim().toLowerCase();
        if (command) {
            printToTerminal(`visitor@cloud:~$ ${command}`, 'prompt');
            processCommand(command);
        }
        termInput.value = '';
        termOutput.scrollTop = termOutput.scrollHeight;
    }
});

function processCommand(cmd) {
    switch (cmd) {
        case 'help':
            printToTerminal(`Commands: <br>- ls projects <br>- whoami <br>- clear <br>- exit`);
            break;
        case 'ls projects':
            printToTerminal(window.portfolioProjects ? window.portfolioProjects.map(p => `[OK] ${p.title}`).join('<br>') : "No projects found.");
            break;
        case 'whoami':
            printToTerminal("Cloud Architect specializing in highly available infrastructure.");
            break;
        case 'clear': termOutput.innerHTML = ''; break;
        case 'exit': btnToggle.click(); break;
        default: printToTerminal(`bash: ${cmd}: command not found`);
    }
}

function printToTerminal(text) {
    const div = document.createElement('div');
    div.innerHTML = text; termOutput.appendChild(div);
}