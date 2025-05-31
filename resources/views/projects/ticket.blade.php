@extends('layouts.app')

@section('title', 'Ticket de Proyecto')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div id="ticket" class="bg-white p-3" style="width: 58mm; min-width: 58mm; max-width: 58mm; border: 1px dashed #333; font-family: 'Courier New', Courier, monospace;">
        <div class="text-center mb-2">
            <h5 style="font-size: 1.1em; margin-bottom: 0.2em;">PROYECTO CREADO</h5>
            <small>{{ now()->format('d/m/Y H:i') }}</small>
        </div>
        <hr style="margin: 0.3em 0;">
        <div style="font-size: 0.95em;">
            <b>Nombre:</b> {{ $project->name }}<br>
            <b>Categoría:</b> {{ $project->category->name ?? '-' }}<br>
            <b>Líder:</b> {{ $project->leader->name ?? '-' }}<br>
            <b>Cliente:</b> {{ $project->client->name ?? '-' }}<br>
            <b>Inicio:</b> {{ $project->start_date }}<br>
            <b>Fin:</b> {{ $project->end_date }}<br>
            <b>Estado:</b> {{ ucfirst($project->status) }}<br>
        </div>
        <hr style="margin: 0.3em 0;">
        <div style="font-size: 0.9em;">
            <b>Descripción:</b><br>
            <span>{{ $project->description }}</span>
        </div>
        <hr style="margin: 0.3em 0;">
        <div class="text-center" style="font-size: 0.9em;">
            <span>¡Gracias por registrar su proyecto!</span>
        </div>
    </div>
</div>

<script>
window.onload = function() {
    setTimeout(function() {
        window.print();
    }, 500);
};
</script>

<style>
@media print {
    body * { visibility: hidden !important; }
    #ticket, #ticket * { visibility: visible !important; }
    #ticket { position: absolute; left: 0; top: 0; width: 58mm !important; max-width: 58mm !important; min-width: 58mm !important; }
}
</style>
@endsection
