(() => {
    // Simple particle field for motion background
    const canvas = document.getElementById('particleCanvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    const particles = Array.from({ length: 60 }, () => ({
        x: Math.random(),
        y: Math.random(),
        r: 1.5 + Math.random() * 1.5,
        vx: (Math.random() - 0.5) * 0.0015,
        vy: (Math.random() - 0.5) * 0.0015,
    }));

    const resize = () => {
        const ratio = window.devicePixelRatio || 1;
        canvas.width = window.innerWidth * ratio;
        canvas.height = window.innerHeight * ratio;
        ctx.scale(ratio, ratio);
    };

    const tick = () => {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        particles.forEach((p, i) => {
            p.x += p.vx;
            p.y += p.vy;
            if (p.x < 0 || p.x > 1) p.vx *= -1;
            if (p.y < 0 || p.y > 1) p.vy *= -1;

            const px = p.x * canvas.width;
            const py = p.y * canvas.height;

            ctx.beginPath();
            ctx.arc(px, py, p.r * 1.2, 0, Math.PI * 2);
            ctx.fillStyle = 'rgba(125, 211, 252, 0.65)';
            ctx.fill();

            // draw connections
            for (let j = i + 1; j < particles.length; j++) {
                const q = particles[j];
                const qx = q.x * canvas.width;
                const qy = q.y * canvas.height;
                const dist = Math.hypot(px - qx, py - qy);
                if (dist < 140) {
                    ctx.strokeStyle = 'rgba(79, 70, 229, 0.12)';
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(px, py);
                    ctx.lineTo(qx, qy);
                    ctx.stroke();
                }
            }
        });

        requestAnimationFrame(tick);
    };

    resize();
    window.addEventListener('resize', resize);
    tick();
})();
