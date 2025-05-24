@extends('layouts.app')

@section('title', $project->name)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">{{ $project->name }}</h2>
                    <div>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-info me-2">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('¿Está seguro de eliminar este proyecto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>Información General</h4>
                            <table class="table">
                                <tr>
                                    <th>Categoría:</th>
                                    <td>
                                        <span class="badge" style="background-color: {{ $project->category->color }}">
                                            {{ $project->category->name }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Líder:</th>
                                    <td>{{ $project->leader->name }}</td>
                                </tr>
                                <tr>
                                    <th>Cliente:</th>
                                    <td>{{ $project->client->name }}</td>
                                </tr>
                                <tr>
                                    <th>Estado:</th>
                                    <td>
                                        <span class="badge bg-{{ $project->status_color }}">
                                            {{ $project->status_label }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Progreso:</th>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" 
                                                 style="width: {{ $project->progress }}%"
                                                 aria-valuenow="{{ $project->progress }}" 
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ $project->progress }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4>Detalles del Proyecto</h4>
                            <table class="table">
                                <tr>
                                    <th>Fecha de Inicio:</th>
                                    <td>{{ $project->start_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Fecha de Finalización:</th>
                                    <td>{{ $project->end_date->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Tiempo Estimado:</th>
                                    <td>{{ $project->estimated_time }} horas</td>
                                </tr>
                                <tr>
                                    <th>Tamaño del Equipo:</th>
                                    <td>{{ $project->team_size }} personas</td>
                                </tr>
                                <tr>
                                    <th>Última Auditoría:</th>
                                    <td>{{ $project->last_audit ? $project->last_audit->format('d/m/Y H:i') : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Descripción</h4>
                            <p class="card-text">{{ $project->description ?? 'Sin descripción' }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h4>Recursos Necesarios</h4>
                            @php
                                $resourcesArray = is_array($project->resources) ? $project->resources : 
                                    (!empty($project->resources) ? explode(',', $project->resources) : []);
                            @endphp
                            @if(!empty($resourcesArray))
                                <ul class="list-group">
                                    @foreach($resourcesArray as $resource)
                                        <li class="list-group-item">{{ trim($resource) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay recursos especificados</p>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <h4>Servicios Requeridos</h4>
                            @php
                                $servicesArray = is_array($project->services) ? $project->services : 
                                    (!empty($project->services) ? explode(',', $project->services) : []);
                            @endphp
                            @if(!empty($servicesArray))
                                <ul class="list-group">
                                    @foreach($servicesArray as $service)
                                        <li class="list-group-item">{{ trim($service) }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No hay servicios especificados</p>
                            @endif
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h4>Historial de Auditoría</h4>
                            @if($project->audits->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Auditor</th>
                                                <th>Acción</th>
                                                <th>Detalles</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($project->audits as $audit)
                                                <tr>
                                                    <td>{{ $audit->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $audit->auditor->name }}</td>
                                                    <td>{{ $audit->action }}</td>
                                                    <td>{{ $audit->details }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>No hay registros de auditoría</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Listado
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 