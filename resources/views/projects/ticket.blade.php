@php
use Illuminate\Support\Str;
@endphp

@extends('layouts.app')

@section('title', 'Ticket de Proyecto')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div id="ticket" class="bg-white p-2" style="width: 58mm; min-width: 58mm; max-width: 58mm; border: 1px dashed #333; font-family: 'Courier New', Courier, monospace; font-size: 0.8em;">
        <div class="text-center mb-1">
            <h6 class="mb-0" style="font-size: 1em;">PROYECTO CREADO</h6>
            <small>{{ now()->format('d/m/Y H:i') }}</small>
        </div>
        <hr style="margin: 0.2em 0;">
        <div>
            <b>ID:</b> {{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}<br>
            <b>Nombre:</b> {{ str($project->name)->limit(20) }}<br>
            <b>Cliente:</b> {{ str($project->client->name ?? '-')->limit(20) }}<br>
            <b>Líder:</b> {{ str($project->leader->name ?? '-')->limit(20) }}
        </div>
        <hr style="margin: 0.2em 0;">
        <div class="text-center" style="font-size: 0.8em;">
            <span>¡Gracias por su confianza!</span>
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
