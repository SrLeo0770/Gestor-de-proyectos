@php
    $stepStyles = "
        .step {
            text-align: center;
            position: relative;
            flex: 1;
        }

        .step-circle {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e9ecef;
            border: 2px solid #dee2e6;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: bold;
            color: #6c757d;
        }

        .step.active .step-circle {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }

        .step-text {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .step.active .step-text {
            color: #0d6efd;
            font-weight: 500;
        }

        .step-content {
            min-height: 300px;
        }
    ";
@endphp

<div>
    <style>{!! $stepStyles !!}</style>
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Crear Nuevo Proyecto</h2>
                </div>

                <div class="card-body">
                    <!-- Progress Bar -->
                    <div class="progress mb-4" style="height: 2px;">
                        <div class="progress-bar" role="progressbar" 
                             style="width: {{ ($currentStep / $totalSteps) * 100 }}%"
                             aria-valuenow="{{ ($currentStep / $totalSteps) * 100 }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                    </div>

                    <!-- Step Indicators -->
                    <div class="d-flex justify-content-between mb-4">
                        <div class="step {{ $currentStep >= 1 ? 'active' : '' }}">
                            <div class="step-circle">1</div>
                            <div class="step-text">Información Básica</div>
                        </div>
                        <div class="step {{ $currentStep >= 2 ? 'active' : '' }}">
                            <div class="step-circle">2</div>
                            <div class="step-text">Equipo</div>
                        </div>
                        <div class="step {{ $currentStep >= 3 ? 'active' : '' }}">
                            <div class="step-circle">3</div>
                            <div class="step-text">Fechas y Recursos</div>
                        </div>
                        <div class="step {{ $currentStep >= 4 ? 'active' : '' }}">
                            <div class="step-circle">4</div>
                            <div class="step-text">Revisión</div>
                        </div>
                    </div>

                    <form wire:submit.prevent="{{ $currentStep === $totalSteps ? 'createProject' : 'nextStep' }}">
                        <!-- Step 1: Basic Information -->
                        @if($currentStep === 1)
                        <div class="step-content">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre del Proyecto *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       wire:model="name" id="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Categoría *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" 
                                        wire:model="category_id" id="category_id">
                                    <option value="">Seleccione una categoría</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción *</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          wire:model="description" id="description" rows="4"></textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <!-- Step 2: Team and Responsibilities -->
                        @if($currentStep === 2)
                        <div class="step-content">
                            <div class="mb-3">
                                <label for="leader_id" class="form-label">Líder del Proyecto *</label>
                                <select class="form-select @error('leader_id') is-invalid @enderror" 
                                        wire:model="leader_id" id="leader_id">
                                    <option value="">Seleccione un líder</option>
                                    @foreach($leaders as $leader)
                                        <option value="{{ $leader->id }}">{{ $leader->name }}</option>
                                    @endforeach
                                </select>
                                @error('leader_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="client_id" class="form-label">Cliente *</label>
                                <select class="form-select @error('client_id') is-invalid @enderror" 
                                        wire:model="client_id" id="client_id">
                                    <option value="">Seleccione un cliente</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->id }}">{{ $client->name }}</option>
                                    @endforeach
                                </select>
                                @error('client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="team_members" class="form-label">Miembros del Equipo *</label>
                                <select class="form-select @error('team_members') is-invalid @enderror" 
                                        wire:model="team_members" id="team_members" multiple>
                                    @foreach($teamMembers as $member)
                                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                                    @endforeach
                                </select>
                                @error('team_members')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="team_size" class="form-label">Tamaño del Equipo *</label>
                                <input type="number" class="form-control @error('team_size') is-invalid @enderror" 
                                       wire:model="team_size" id="team_size" min="1">
                                @error('team_size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <!-- Step 3: Dates and Resources -->
                        @if($currentStep === 3)
                        <div class="step-content">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Fecha de Inicio *</label>
                                        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                               wire:model="start_date" id="start_date">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">Fecha de Finalización *</label>
                                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                               wire:model="end_date" id="end_date">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estimated_time" class="form-label">Tiempo Estimado (horas) *</label>
                                <input type="number" class="form-control @error('estimated_time') is-invalid @enderror" 
                                       wire:model="estimated_time" id="estimated_time" min="1">
                                @error('estimated_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="resources" class="form-label">Recursos Necesarios</label>
                                <textarea class="form-control @error('resources') is-invalid @enderror" 
                                          wire:model="resources" id="resources" rows="3"
                                          placeholder="Ingrese los recursos separados por comas"></textarea>
                                @error('resources')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="services" class="form-label">Servicios Requeridos</label>
                                <textarea class="form-control @error('services') is-invalid @enderror" 
                                          wire:model="services" id="services" rows="3"
                                          placeholder="Ingrese los servicios separados por comas"></textarea>
                                @error('services')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        @endif

                        <!-- Step 4: Review -->
                        @if($currentStep === 4)
                        <div class="step-content">
                            <h4 class="mb-3">Resumen del Proyecto</h4>
                            
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Información Básica</h5>
                                    <dl class="row">
                                        <dt class="col-sm-3">Nombre:</dt>
                                        <dd class="col-sm-9">{{ $name }}</dd>
                                        
                                        <dt class="col-sm-3">Categoría:</dt>
                                        <dd class="col-sm-9">
                                            {{ $categories->find($category_id)?->name }}
                                        </dd>
                                        
                                        <dt class="col-sm-3">Descripción:</dt>
                                        <dd class="col-sm-9">{{ $description }}</dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Equipo y Responsabilidades</h5>
                                    <dl class="row">
                                        <dt class="col-sm-3">Líder:</dt>
                                        <dd class="col-sm-9">
                                            {{ $leaders->find($leader_id)?->name }}
                                        </dd>
                                        
                                        <dt class="col-sm-3">Cliente:</dt>
                                        <dd class="col-sm-9">
                                            {{ $clients->find($client_id)?->name }}
                                        </dd>
                                        
                                        <dt class="col-sm-3">Tamaño del Equipo:</dt>
                                        <dd class="col-sm-9">{{ $team_size }}</dd>
                                        
                                        <dt class="col-sm-3">Miembros:</dt>
                                        <dd class="col-sm-9">
                                            @foreach($teamMembers->whereIn('id', $team_members) as $member)
                                                <span class="badge bg-primary me-1">{{ $member->name }}</span>
                                            @endforeach
                                        </dd>
                                    </dl>
                                </div>
                            </div>

                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">Fechas y Recursos</h5>
                                    <dl class="row">
                                        <dt class="col-sm-3">Fecha de Inicio:</dt>
                                        <dd class="col-sm-9">{{ $start_date }}</dd>
                                        
                                        <dt class="col-sm-3">Fecha de Fin:</dt>
                                        <dd class="col-sm-9">{{ $end_date }}</dd>
                                        
                                        <dt class="col-sm-3">Tiempo Estimado:</dt>
                                        <dd class="col-sm-9">{{ $estimated_time }} horas</dd>
                                        
                                        <dt class="col-sm-3">Recursos:</dt>
                                        <dd class="col-sm-9">{{ $resources ?: 'No especificados' }}</dd>
                                        
                                        <dt class="col-sm-3">Servicios:</dt>
                                        <dd class="col-sm-9">{{ $services ?: 'No especificados' }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="d-flex justify-content-between mt-4">
                            @if($currentStep > 1)
                                <button type="button" class="btn btn-secondary" wire:click="previousStep">
                                    <i class="fas fa-arrow-left"></i> Anterior
                                </button>
                            @else
                                <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Volver
                                </a>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                @if($currentStep === $totalSteps)
                                    <i class="fas fa-save"></i> Crear Proyecto
                                @else
                                    Siguiente <i class="fas fa-arrow-right"></i>
                                @endif
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 