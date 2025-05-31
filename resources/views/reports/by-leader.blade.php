@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie"></i> Proyectos por Líder
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($leaders as $leader)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <strong>Líder:</strong> {{ $leader->name }}
                                    </div>
                                    <div class="card-body p-0">
                                        @if($leader->ledProjects->isEmpty())
                                            <div class="alert alert-info m-3">No tiene proyectos asignados.</div>
                                        @else
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Categoría</th>
                                                        <th>Cliente</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                        <th>Progreso</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($leader->ledProjects as $project)
                                                        <tr>
                                                            <td>{{ $project->name }}</td>
                                                            <td>{{ $project->category->name ?? '-' }}</td>
                                                            <td>{{ $project->client->name ?? '-' }}</td>
                                                            <td>{{ $project->start_date }}</td>
                                                            <td>{{ $project->end_date }}</td>
                                                            <td>{{ $project->progress }}%</td>
                                                            <td>
                                                                <span class="badge bg-{{ $project->status_color }}">
                                                                    {{ $project->status_label }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @endif
                                    </div>
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
