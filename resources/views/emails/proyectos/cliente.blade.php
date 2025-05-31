<x-mail::message>
# ¡Bienvenido, {{ $cliente->name }}!

Has sido asignado como cliente en el proyecto:

**Nombre del Proyecto:** {{ $project->name }}
**Categoría:** {{ $project->category->name ?? '-' }}
**Líder:** {{ $project->leader->name ?? '-' }}
**Fecha de inicio:** {{ $project->start_date }}
**Fecha de fin:** {{ $project->end_date }}

**Descripción:**
{{ $project->description }}

Gracias por confiar en nosotros.

<x-mail::button :url="''">
Ver Proyecto
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
