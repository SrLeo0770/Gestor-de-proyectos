@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">Miembros del Equipo</h2>
                    <a href="{{ route('team-members.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Miembro
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Rol</th>
                                    <th>Departamento</th>
                                    <th>Posición</th>
                                    <th>Proyectos Activos</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($teamMembers as $member)
                                    <tr>
                                        <td>{{ $member->user->name }}</td>
                                        <td>{{ $member->role }}</td>
                                        <td>{{ $member->department ?? 'N/A' }}</td>
                                        <td>{{ $member->position }}</td>
                                        <td>
                                            @if($member->projects->count() > 0)
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" 
                                                            type="button" 
                                                            data-bs-toggle="dropdown" 
                                                            aria-expanded="false">
                                                        {{ $member->projects->count() }} Proyecto(s)
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        @foreach($member->projects as $project)
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('projects.show', $project) }}">
                                                                    <span class="badge bg-{{ $project->status_color }} me-2">
                                                                        {{ $project->status_label }}
                                                                    </span>
                                                                    {{ $project->name }}
                                                                    <small class="text-muted d-block">
                                                                        {{ $project->projectType->name }} - 
                                                                        {{ $project->category->name }}
                                                                    </small>
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <span class="badge bg-secondary">Sin proyectos</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $member->is_active ? 'success' : 'danger' }}">
                                                {{ $member->is_active ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('team-members.edit', $member) }}" 
                                                   class="btn btn-sm btn-info me-2">
                                                    <i class="fas fa-edit"></i> Editar
                                                </a>
                                                <form action="{{ route('team-members.destroy', $member) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('¿Está seguro de eliminar este miembro?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fas fa-trash"></i> Eliminar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No hay miembros registrados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $teamMembers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 