// Fondo interactivo con partículas simples
const canvas = document.getElementById('backgroundCanvas');
const ctx = canvas.getContext('2d');

// Ajustar el tamaño del canvas
function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
resizeCanvas();
window.addEventListener('resize', resizeCanvas);

// Crear partículas
const particles = [];
const particleCount = 150; // Número de partículas

for (let i = 0; i < particleCount; i++) {
    particles.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: Math.random() * 5 + 2, // Tamaño de las partículas
        dx: (Math.random() - 0.5) * 2, // Velocidad horizontal
        dy: (Math.random() - 0.5) * 2, // Velocidad vertical
    });
}

// Animar partículas
function animate() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);

    particles.forEach(particle => {
        // Dibujar partículas
        ctx.beginPath();
        ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
        ctx.fillStyle = 'rgba(255, 255, 255, 0.8)'; // Color y opacidad
        ctx.fill();

        // Mover partículas
        particle.x += particle.dx;
        particle.y += particle.dy;

        // Rebotar en los bordes
        if (particle.x < 0 || particle.x > canvas.width) particle.dx *= -1;
        if (particle.y < 0 || particle.y > canvas.height) particle.dy *= -1;
    });

    requestAnimationFrame(animate);
}

animate();