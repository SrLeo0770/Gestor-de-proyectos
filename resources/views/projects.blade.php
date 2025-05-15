<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
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

        :root {
            --background-color: #f5f5f5;
            --text-color: #000;
            --card-background: #fff;
            --sidebar-background: #e0e0e0;
            --button-background: #d6d6d6;
        }

        [data-theme="dark"] {
            --background-color: #121212;
            --text-color: #e0e0e0;
            --card-background: #1e1e1e;
            --sidebar-background: #2a2a2a;
            --button-background: #3a3a3a;
        }

        body {
            margin: 0;
            padding: 0;
            font-size: 14px; /* Reducir el tamaño de la fuente */
            background-color: var(--background-color);
            color: var(--text-color);
        }

        html {
            overflow: auto;
        }

        .container {
            max-width: 800px; /* Reducir el ancho del contenedor */
            margin: 0 auto;
            padding: 10px; /* Reducir el relleno */
            position: relative;
            z-index: 1;
        }

        h1 {
            font-size: 24px; /* Reducir el tamaño del título */
            margin-bottom: 20px;
        }

        .form-label {
            font-size: 12px; /* Reducir el tamaño de las etiquetas */
        }

        .form-control {
            font-size: 12px; /* Reducir el tamaño de los campos de entrada */
            padding: 5px; /* Reducir el relleno de los campos */
        }

        .btn {
            font-size: 12px; /* Reducir el tamaño de los botones */
            padding: 5px 10px; /* Reducir el relleno de los botones */
        }

        .card {
            font-size: 12px; /* Reducir el tamaño del texto en las tarjetas */
            margin-bottom: 10px; /* Reducir el margen entre tarjetas */
            background-color: var(--card-background);
        }

        /* Diseño responsivo */
        @media (max-width: 768px) {
            .container {
                padding: 5px;
            }

            h1 {
                font-size: 20px;
            }

            .form-label, .form-control, .btn {
                font-size: 10px;
            }

            .card {
                font-size: 10px;
            }
        }

        /* Animaciones suaves */
        .btn {
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .card {
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }

        #theme-toggle {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            background-color: var(--button-background);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        #theme-toggle:hover {
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilo para la barra lateral */
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
    <div class="container mt-5">
        <h1 class="text-center mb-4">Project Manager</h1>

        <button id="theme-toggle"></button>

        <!-- Formulario para buscar proyectos -->
        <form method="GET" action="{{ route('projects.index') }}" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar proyectos..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Formulario para crear proyectos -->
        <form action="{{ route('projects.store') }}" method="POST" class="mb-5">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del Proyecto</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Descripción</label>
                <textarea class="form-control" id="description" name="description" rows="6" style="resize: none;"></textarea>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Fecha de Inicio</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">Fecha de Finalización</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <button type="submit" class="btn btn-primary">Crear Proyecto</button>
        </form>

        <!-- Sección para mostrar proyectos -->
        <div class="row">
            @foreach ($projects as $project)
                @include('components.project-card', ['project' => $project])
            @endforeach
        </div>
    </div>
    <script>
        const canvas = document.getElementById('backgroundCanvas');
        const ctx = canvas.getContext('2d');
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;

        const particles = [];

        // Update particle visibility
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
                ctx.fillStyle = 'rgba(255, 255, 255, 1)'; // Increase opacity for visibility
                ctx.shadowBlur = 10; // Add glow effect
                ctx.shadowColor = 'white';
                ctx.fill();
            }
        }

        function initParticles() {
            particles.length = 0; // Clear existing particles
            for (let i = 0; i < 150; i++) { // Increase particle count
                const size = Math.random() * 5 + 2; // Increase particle size
                const x = Math.random() * canvas.width;
                const y = Math.random() * canvas.height;
                const speedX = (Math.random() - 0.5) * 3; // Increase speed
                const speedY = (Math.random() - 0.5) * 3;
                particles.push(new Particle(x, y, size, speedX, speedY));
            }
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(particle => {
                particle.update();
                particle.draw();
            });
            requestAnimationFrame(animate);
        }

        initParticles();
        animate();

        window.addEventListener('resize', () => {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            particles.length = 0;
            initParticles();
        });

        document.querySelectorAll('.card').forEach(card => {
            card.style.position = '';
            card.style.cursor = '';

            card.removeEventListener('mousedown', () => {});
            card.removeEventListener('dblclick', () => {});
        });

        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('theme-toggle');
            const updateIcon = () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                themeToggle.textContent = currentTheme === 'dark' ? '☀️' : '🌙';
            };

            themeToggle.addEventListener('click', () => {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                document.documentElement.setAttribute('data-theme', newTheme);
                updateIcon();
            });

            updateIcon();
        });
    </script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
