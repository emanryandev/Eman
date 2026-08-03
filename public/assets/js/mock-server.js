document.addEventListener('DOMContentLoaded', () => {
    const latencyEl = document.getElementById('metric-latency');
    const uptimeEl = document.getElementById('metric-uptime');

    setInterval(() => {
        const currentLatency = Math.floor(Math.random() * 27) + 8; 
        latencyEl.innerText = `${currentLatency}ms`;
        
        if (currentLatency > 25) {
            latencyEl.style.color = '#d29922'; 
        } else {
            latencyEl.style.color = '#3fb950'; 
        }
    }, 2000);

    let uptimeTicks = 0;
    setInterval(() => {
        uptimeTicks++;
        if (uptimeTicks % 1000 === 0) { uptimeEl.innerText = '99.98%'; } 
        else { uptimeEl.innerText = '99.99%'; }
    }, 5000);
});