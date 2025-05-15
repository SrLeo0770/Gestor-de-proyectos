@extends('layouts.app')

@section('title', 'Editar Proyecto')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Editar Proyecto</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('projects.update', $project) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Proyecto</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $project->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Descripción</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="3" required>{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                       id="start_date" name="start_date" 
                                       value="{{ old('start_date', $project->start_date->format('Y-m-d')) }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label">Fecha de Finalización</label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                       id="end_date" name="end_date" 
                                       value="{{ old('end_date', $project->end_date->format('Y-m-d')) }}" required>
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="leader_id" class="form-label">Líder del Proyecto</label>
                                <select class="form-select @error('leader_id') is-invalid @enderror" 
                                        id="leader_id" name="leader_id" required>
                                    <option value="">Seleccionar líder...</option>
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
                            <div class="col-md-6">
                                <label for="client_id" class="form-label">Cliente</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" 
                                        id="client_id" name="client_id" required>
                                    <option value="">Seleccionar cliente...</option>
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

                        <div class="mb-3">
                            <label for="status" class="form-label">Estado del Proyecto</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="pending" {{ old('status', $project->status) == 'pending' ? 'selected' : '' }}>
                                    Pendiente
                                </option>
                                <option value="in-progress" {{ old('status', $project->status) == 'in-progress' ? 'selected' : '' }}>
                                    En Progreso
                                </option>
                                <option value="completed" {{ old('status', $project->status) == 'completed' ? 'selected' : '' }}>
                                    Completado
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="team_members" class="form-label">Miembros del Equipo</label>
                            <select class="form-select @error('team_members') is-invalid @enderror" 
                                    id="team_members" name="team_members[]" multiple required>
                                @foreach($teamMembers as $member)
                                    <option value="{{ $member->id }}" 
                                            {{ (old('team_members', $project->teamMembers->pluck('id')->toArray()) && 
                                                in_array($member->id, old('team_members', $project->teamMembers->pluck('id')->toArray()))) ? 'selected' : '' }}>
                                        {{ $member->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('team_members')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Mantén presionado Ctrl (Cmd en Mac) para seleccionar múltiples miembros.</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#team_members').select2({
        placeholder: 'Seleccionar miembros...',
        allowClear: true
    });

    $('#status').change(function() {
        if ($(this).val() === 'completed') {
            if ($('#completion_status_container').length === 0) {
                var completionStatusHtml = `
                    <div id="completion_status_container" class="mb-3">
                        <label for="completion_status" class="form-label">Estado de Finalización</label>
                        <select class="form-select" id="completion_status" name="completion_status">
                            <option value="complete">Completo</option>
                            <option value="incomplete">Incompleto</option>
                            <option value="cancelled">Cancelado</option>
                        </select>
                    </div>
                `;
                $(this).closest('.mb-3').after(completionStatusHtml);
            }
        } else {
            $('#completion_status_container').remove();
        }
    });
});
</script>
@endpush
