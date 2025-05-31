@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-check-circle"></i> Proyectos Finalizados
                    </h5>
                </div>
                <div class="card-body">
                    <h3 class="text-center">{{ $projects->count() }}</h3>
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
                    <ul class="list-group list-group-flush">
                        @foreach($categories ?? [] as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-success rounded-pill">{{ $category->projects_count ?? 0 }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie"></i> Líderes
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($projects->groupBy('leader_id') as $leaderId => $group)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ optional($group->first()->leader)->name ?? 'Sin líder' }}
                                <span class="badge bg-info rounded-pill">{{ $group->count() }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span><i class="fas fa-list"></i> Lista de Proyectos Finalizados</span>
            <div>
                <a href="{{ route('reports.completed', array_merge(request()->all(), ['export' => 'excel'])) }}" class="btn btn-success btn-sm me-2"><i class="fas fa-file-excel"></i> Excel</a>
                <a href="{{ route('reports.completed', array_merge(request()->all(), ['export' => 'pdf'])) }}" class="btn btn-danger btn-sm"><i class="fas fa-file-pdf"></i> PDF</a>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3 mb-3">
                <div class="col-md-3">
                    <input type="text" name="name" class="form-control" placeholder="Nombre del proyecto" value="{{ request('name') }}">
                </div>
                <div class="col-md-3">
                    <select name="category_id" class="form-select">
                        <option value="">Todas las categorías</option>
                        @foreach($categories ?? [] as $category)
                            <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i> Filtrar</button>
                    <a href="?" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Líder</th>
                            <th>Cliente</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Progreso</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->name }}</td>
                                <td>{{ $project->category->name ?? '-' }}</td>
                                <td>{{ $project->leader->name ?? '-' }}</td>
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
        </div>
    </div>
</div>
@endsection
