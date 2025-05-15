<div class="container mt-5">
    <h1 class="text-center mb-4">Reporte de Proyectos en Ejecución</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Porcentaje de Avance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->description }}</td>
                    <td>{{ $project->progress }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
