<div class="container mt-5">
    <h1 class="text-center mb-4">Reporte de Proyectos por Cliente</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Nombre del Proyecto</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <td>{{ $project->client->name }}</td>
                    <td>{{ $project->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
