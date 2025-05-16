@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Editar Miembro del Equipo</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('team-members.update', $teamMember) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Usuario</label>
                            <input type="text" class="form-control" 
                                   value="{{ $teamMember->user->name }} ({{ $teamMember->user->email }})" 
                                   disabled>
                        </div>

                        <div class="mb-3">
                            <label for="role" class="form-label">Rol *</label>
                            <input type="text" class="form-control @error('role') is-invalid @enderror" 
                                   id="role" name="role" value="{{ old('role', $teamMember->role) }}" required>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Departamento</label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                   id="department" name="department" value="{{ old('department', $teamMember->department) }}">
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label">Posición *</label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position', $teamMember->position) }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="skills" class="form-label">Habilidades</label>
                            <input type="text" class="form-control @error('skills') is-invalid @enderror" 
                                   id="skills" name="skills" 
                                   value="{{ old('skills', is_array($teamMember->skills) ? implode(', ', $teamMember->skills) : $teamMember->skills) }}"
                                   placeholder="Separar habilidades por comas">
                            <small class="form-text text-muted">
                                Ingrese las habilidades separadas por comas (ej: PHP, Laravel, MySQL)
                            </small>
                            @error('skills')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $teamMember->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Activo</label>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('team-members.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Volver
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Miembro
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
        const skillsInput = document.getElementById('skills');
        
        if (skillsInput) {
            skillsInput.addEventListener('change', function() {
                const skills = this.value.split(',').map(skill => skill.trim());
                this.value = skills.join(', ');
            });
        }
    });
</script>
@endpush 