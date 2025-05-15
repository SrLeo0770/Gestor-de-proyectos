<div class="col-md-4 mb-4">
    <div class="card position-relative">
        <div class="card-body">
            <h5 class="card-title">{{ $project->name }}</h5>
            <p class="card-text">{{ $project->description }}</p>
            <p class="card-text"><small class="text-muted">Inicio: {{ $project->start_date }}</small></p>
            <p class="card-text"><small class="text-muted">Fin: {{ $project->end_date }}</small></p>
            <p class="card-text">
                <span class="badge {{ $project->status === 'completed' ? 'bg-success' : ($project->status === 'in-progress' ? 'bg-warning' : 'bg-secondary') }}">
                    {{ ucfirst($project->status ?? 'pending') }}
                </span>
            </p>
            <div class="position-absolute top-0 end-0 m-2">
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-warning">Editar</a>
                <form action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                </form>
                @if($project->status !== 'completed')
                    <form action="{{ route('projects.update', $project->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $project->name }}">
                        <input type="hidden" name="description" value="{{ $project->description }}">
                        <input type="hidden" name="start_date" value="{{ $project->start_date }}">
                        <input type="hidden" name="end_date" value="{{ $project->end_date }}">
                        <input type="hidden" name="status" value="completed">
                        <button type="submit" class="btn btn-sm btn-success">Marcar como terminado</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
