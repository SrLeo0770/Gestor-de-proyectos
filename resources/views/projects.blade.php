<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://localhost:5174/resources/css/app.css">
    <script src="http://localhost:5174/resources/js/main.js" defer></script>
    <style>
        body {
            background-color: #f5f5f5; /* Color suave */
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
                <label for="name" class="form-label">Project Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date">
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date">
            </div>
            <button type="submit" class="btn btn-primary">Create Project</button>
        </form>

        <!-- Sección para mostrar proyectos -->
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card position-relative">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->name }}</h5>
                            <p class="card-text">{{ $project->description }}</p>
                            <p class="card-text"><small class="text-muted">Start: {{ $project->start_date }}</small></p>
                            <p class="card-text"><small class="text-muted">End: {{ $project->end_date }}</small></p>
                            <!-- Botones de editar y borrar -->
                            <div class="position-absolute top-0 end-0 m-2">
                                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
