@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2 class="mb-0">Proyectos</h2>
        </div>
        <div class="col-md-4 text-end">
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Nuevo Proyecto
            </a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('team-members.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-users"></i> Nuevo Miembro del Equipo
                        </a>
                        <a href="{{ route('categories.create') }}" class="btn btn-outline-success">
                            <i class="fas fa-tags"></i> Nueva Categoría
                        </a>
                        <a href="{{ route('clients.create') }}" class="btn btn-outline-info">
                            <i class="fas fa-user-tie"></i> Nuevo Cliente
                        </a>
                        <a href="{{ route('project-types.create') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-project-diagram"></i> Nuevo Tipo de Proyecto
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cliente</th>
                            <th>Líder</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($projects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->client->name }}</td>
                                <td>{{ $project->leader->name }}</td>
                                <td>{{ $project->start_date->format('d/m/Y') }}</td>
                                <td>{{ $project->end_date->format('d/m/Y') }}</td>
                                <td>
                                    @switch($project->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pendiente</span>
                                            @break
                                        @case('in-progress')
                                            <span class="badge bg-info">En Progreso</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Completado</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ $project->status }}</span>
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('projects.show', $project) }}" 
                                           class="btn btn-sm btn-info" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('projects.edit', $project) }}" 
                                           class="btn btn-sm btn-primary" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('projects.destroy', $project) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Está seguro de eliminar este proyecto?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay proyectos registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $projects->links() }}
            </div>
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
