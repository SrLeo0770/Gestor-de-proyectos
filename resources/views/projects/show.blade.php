@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">{{ $project->name }}</h4>
                    <span class="badge bg-light text-primary">
                        @switch($project->status)
                            @case('pending')
                                Pendiente
                                @break
                            @case('in-progress')
                                En Progreso
                                @break
                            @case('completed')
                                Completado
                                @break
                            @default
                                {{ $project->status }}
                        @endswitch
                    </span>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <h5>Descripción</h5>
                        <p>{{ $project->description }}</p>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Fechas</h5>
                            <p><strong>Inicio:</strong> {{ $project->start_date->format('d/m/Y') }}</p>
                            <p><strong>Fin:</strong> {{ $project->end_date->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>Responsables</h5>
                            <p><strong>Líder:</strong> {{ $project->leader->name }}</p>
                            <p><strong>Cliente:</strong> {{ $project->client->name }}</p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h5>Equipo del Proyecto</h5>
                        <div class="list-group">
                            @foreach($project->teamMembers as $member)
                                <div class="list-group-item">
                                    <i class="fas fa-user"></i> {{ $member->name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="btn-group">
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Está seguro de eliminar este proyecto?')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Historial de Cambios</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($project->audits->sortByDesc('created_at') as $audit)
                            <div class="timeline-item mb-3">
                                <div class="timeline-date text-muted">
                                    {{ $audit->created_at->format('d/m/Y H:i') }}
                                </div>
                                <div class="timeline-content">
                                    <strong>{{ $audit->auditor->name }}</strong>
                                    <p class="mb-0">{{ $audit->details }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 