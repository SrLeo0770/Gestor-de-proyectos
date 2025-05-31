@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="container">
    <!-- Dashboard Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users"></i> Miembros del Equipo
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($teamMembers as $member)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <span>{{ $member->name }}</span>
                                <span class="badge bg-primary rounded-pill" 
                                      data-bs-toggle="tooltip" 
                                      title="Proyectos activos asignados">
                                    {{ $member->team_projects_count }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-tags"></i> Categorías
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-success rounded-pill">{{ $category->projects_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie"></i> Clientes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        @foreach($clients as $client)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $client->name }}
                                <span class="badge bg-info rounded-pill">{{ $client->projects_count }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects List -->
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-list"></i> Lista de Proyectos
            </h5>
            @if(Auth::user()->isProjectLeader())
            <a href="{{ route('projects.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Nuevo Proyecto
            </a>
            @endif
        </div>

        <div class="card-body">
            @if($projects->isEmpty())
                <div class="alert alert-info">
                    No hay proyectos disponibles.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Líder</th>
                                <th>Cliente</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
                                    <td>{{ $project->leader->name }}</td>
                                    <td>{{ $project->client->name }}</td>
                                    <td>
                                        <span class="badge bg-{{ $project->status_color }}">
                                            {{ $project->status_label }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(Auth::user()->isProjectLeader())
                                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este proyecto?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $projects->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.progress {
    height: 20px;
}
.progress-bar {
    min-width: 2em;
}
.card-footer .btn-group {
    width: 100%;
}
.card-footer .btn {
    flex: 1;
}
</style>
@endpush
