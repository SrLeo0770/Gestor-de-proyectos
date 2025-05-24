@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Editar Proyecto</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('projects.update', $project) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre del Proyecto *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $project->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Categoría *</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror" 
                                            id="category_id" name="category_id" required>
                                        <option value="">Seleccione una categoría</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" 
                                                {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="leader_id" class="form-label">Líder del Proyecto *</label>
                                    <select class="form-select @error('leader_id') is-invalid @enderror" 
                                            id="leader_id" name="leader_id" required>
                                        <option value="">Seleccione un líder</option>
                                        @foreach($leaders as $leader)
                                            <option value="{{ $leader->id }}" 
                                                {{ old('leader_id', $project->leader_id) == $leader->id ? 'selected' : '' }}>
                                                {{ $leader->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('leader_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="team_members" class="form-label">Miembros del Equipo *</label>
                                    <select class="form-select @error('team_members') is-invalid @enderror" 
                                            id="team_members" name="team_members[]" multiple required>
                                        @foreach($teamMembers as $member)
                                            <option value="{{ $member->id }}" 
                                                {{ (old('team_members') && in_array($member->id, old('team_members'))) || 
                                                   $project->teamMembers->contains($member->id) ? 'selected' : '' }}>
                                                {{ $member->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('team_members')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="client_id" class="form-label">Cliente *</label>
                                    <select class="form-select @error('client_id') is-invalid @enderror" 
                                            id="client_id" name="client_id" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" 
                                                {{ old('client_id', $project->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('client_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Fecha de Inicio *</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" 
                                           value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Fecha de Finalización *</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" 
                                           value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="estimated_time" class="form-label">Tiempo Estimado (horas) *</label>
                                    <input type="number" class="form-control @error('estimated_time') is-invalid @enderror" 
                                           id="estimated_time" name="estimated_time" 
                                           value="{{ old('estimated_time', $project->estimated_time) }}" required>
                                    @error('estimated_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="team_size" class="form-label">Tamaño del Equipo *</label>
                                    <input type="number" class="form-control @error('team_size') is-invalid @enderror" 
                                           id="team_size" name="team_size" 
                                           value="{{ old('team_size', $project->team_size) }}" required>
                                    @error('team_size')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Estado *</label>
                                    <select class="form-select @error('status') is-invalid @enderror" 
                                            id="status" name="status" required>
                                        <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="in_progress" {{ old('status', $project->status) == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                        <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>Completado</option>
                                        <option value="on_hold" {{ old('status', $project->status) == 'on_hold' ? 'selected' : '' }}>En Espera</option>
                                        <option value="cancelled" {{ old('status', $project->status) == 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="progress" class="form-label">Progreso (%)</label>
                                    <input type="number" class="form-control @error('progress') is-invalid @enderror" 
                                           id="progress" name="progress" 
                                           value="{{ old('progress', $project->progress) }}" min="0" max="100">
                                    @error('progress')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="resources" class="form-label">Recursos Necesarios</label>
                            <textarea class="form-control @error('resources') is-invalid @enderror" 
                                      id="resources" name="resources" rows="3"
                                      placeholder="Ingrese los recursos separados por comas">{{ old('resources', is_array($project->resources) ? implode(', ', $project->resources) : $project->resources) }}</textarea>
                            @error('resources')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="services" class="form-label">Servicios Requeridos</label>
                            <textarea class="form-control @error('services') is-invalid @enderror" 
                                      id="services" name="services" rows="3"
                                      placeholder="Ingrese los servicios separados por comas">{{ old('services', is_array($project->services) ? implode(', ', $project->services) : $project->services) }}</textarea>
                            @error('services')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        startDateInput.addEventListener('change', function() {
            endDateInput.min = this.value;
        });

        endDateInput.addEventListener('change', function() {
            startDateInput.max = this.value;
        });

        const resourcesInput = document.getElementById('resources');
        const servicesInput = document.getElementById('services');

        [resourcesInput, servicesInput].forEach(input => {
            if (input) {
                input.addEventListener('change', function() {
                    const items = this.value.split(',').map(item => item.trim());
                    this.value = items.join(', ');
                });
            }
        });
    });
</script>
@endpush
