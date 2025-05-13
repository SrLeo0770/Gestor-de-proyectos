<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

        body {
            margin: 0;
            background-color: #f5f5f5; /* Color suave */
        }

        html {
            overflow: auto;
        }

        .container {
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body>
    <canvas id="backgroundCanvas"></canvas>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Project Manager</h1>

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
                <div class="col-md-4 mb-4">
                    <div class="card position-relative">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">{{ $project->description }}</p>
                            <p class="card-text"><small class="text-muted">Inicio: {{ $project->start_date }}</small></p>
                            <p class="card-text"><small class="text-muted">Fin: {{ $project->end_date }}</small></p>
                            <div class="position-absolute top-0 end-0 m-2">
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </div>
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
                ctx.fillStyle = 'rgba(255, 255, 255, 0.7)';
                ctx.fill();
            }
        }

        function initParticles() {
            for (let i = 0; i < 100; i++) {
                const size = Math.random() * 3 + 1;
                const x = Math.random() * canvas.width;
                const y = Math.random() * canvas.height;
                const speedX = (Math.random() - 0.5) * 2;
                const speedY = (Math.random() - 0.5) * 2;
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
    </script>
</body>
</html>
