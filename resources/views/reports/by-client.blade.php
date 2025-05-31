@extends('layouts.app')
@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user"></i> Proyectos por Cliente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($clients as $client)
                            <div class="col-md-6 mb-4">
                                <div class="card shadow-sm">
                                    <div class="card-header bg-info text-white">
                                        <strong>Cliente:</strong> {{ $client->name }}
                                    </div>
                                    <div class="card-body p-0">
                                        @if($client->clientProjects->isEmpty())
                                            <div class="alert alert-info m-3">No tiene proyectos asignados.</div>
                                        @else
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Categoría</th>
                                                        <th>Líder</th>
                                                        <th>Fecha Inicio</th>
                                                        <th>Fecha Fin</th>
                                                        <th>Progreso</th>
                                                        <th>Estado</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($client->clientProjects as $project)
                                                        <tr>
                                                            <td>{{ $project->name }}</td>
                                                            <td>{{ $project->category->name ?? '-' }}</td>
                                                            <td>{{ $project->leader->name ?? '-' }}</td>
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
