<div class="container mt-5">
    <h1 class="text-center mb-4">Reporte de Proyectos por Líder</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Líder</th>
                <th>Nombre del Proyecto</th>
                <th>Porcentaje de Avance</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->leader->name }}</td>
                    <td>{{ $project->name }}</td>
                    <td>{{ $project->progress }}%</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
