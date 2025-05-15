<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos Creados</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="{{ asset('js/main.js') }}" defer></script>
    <style>
        #backgroundCanvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 60px;
            background-color: var(--sidebar-background);
            overflow-x: hidden;
            transition: width 0.3s ease;
            z-index: 1000;
        }

        .sidebar:hover {
            width: 200px;
        }

        .sidebar.collapsed {
            width: 60px;
        }

        .sidebar a {
            display: block;
            color: var(--text-color);
            text-decoration: none;
            padding: 15px;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            transition: background-color 0.3s ease;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar a i {
            margin-right: 10px;
        }
        .container {
            margin-left: 220px;
            transition: margin-left 0.3s ease;
        }

        .container.collapsed {
            margin-left: 80px;
        }
    </style>
</head>
<body>
    <canvas id="backgroundCanvas"></canvas>
    <div class="sidebar">
        <a href="{{ route('projects.index') }}"><i class="fas fa-home"></i> Inicio</a>
        <a href="{{ route('reports.created') }}"><i class="fas fa-calendar-plus"></i> Proyectos Creados</a>
        <a href="{{ route('reports.inProgress') }}"><i class="fas fa-tasks"></i> En Ejecución</a>
        <a href="{{ route('reports.completed') }}"><i class="fas fa-check-circle"></i> Finalizados</a>
        <a href="{{ route('reports.byLeader') }}"><i class="fas fa-user-tie"></i> Por Líder</a>
        <a href="{{ route('reports.byClient') }}"><i class="fas fa-user"></i> Por Cliente</a>
    </div>
    <button id="theme-toggle" class="btn btn-secondary position-fixed" style="top: 10px; right: 10px;">☀️</button>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Reporte de Proyectos Creados</h1>
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-3 mb-3">
                    <div class="card" style="font-size: 0.9rem;">
                        <div class="card-body">
                            <h6 class="card-title">{{ $project->name }}</h6>
                            <p class="card-text">{{ Str::limit($project->description, 50) }}</p>
                            <p class="card-text"><small class="text-muted">Creado: {{ $project->created_at->format('d/m/Y') }}</small></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <script>
        const canvas = document.getElementById('backgroundCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];

        class Particle {
            constructor(x, y, size, speedX, speedY) {
                this.x = x;
                this.y = y;
                this.size = size;
                this.speedX = speedX;
                this.speedY = speedY;
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;

                if (this.x < 0 || this.x > canvas.width) this.speedX *= -1;
                if (this.y < 0 || this.y > canvas.height) this.speedY *= -1;
            }

            draw() {
                ctx.beginPath();
                ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                ctx.fillStyle = 'rgba(255, 255, 255, 0.8)';
                ctx.fill();
            }
        }

        function initParticles() {
            particles.length = 0;
            for (let i = 0; i < 100; i++) {
                const size = Math.random() * 5 + 1;
                const x = Math.random() * canvas.width;
                const y = Math.random() * canvas.height;
                const speedX = (Math.random() - 0.5) * 2;
                const speedY = (Math.random() - 0.5) * 2;
                particles.push(new Particle(x, y, size, speedX, speedY));
            }
        }

        function animateParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animateParticles);
        }

        initParticles();
        animateParticles();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            initParticles();
        });

        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            themeToggle.textContent = newTheme === 'dark' ? '☀️' : '🌙';
        });

        const sidebar = document.querySelector('.sidebar');
        const container = document.querySelector('.container');

        sidebar.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            container.classList.toggle('collapsed');
        });

        document.addEventListener('click', (event) => {
            if (!sidebar.contains(event.target) && !event.target.closest('.sidebar')) {
                sidebar.classList.add('collapsed');
                container.classList.add('collapsed');
            }
        });
    </script>
</body>
</html>
