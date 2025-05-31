<x-mail::message>
# ¡Hola, {{ $lider->name }}!

Eres el líder del nuevo proyecto:

**Nombre del Proyecto:** {{ $project->name }}
**Categoría:** {{ $project->category->name ?? '-' }}
**Cliente:** {{ $project->client->name ?? '-' }}
**Fecha de inicio:** {{ $project->start_date }}
**Fecha de fin:** {{ $project->end_date }}

**Descripción:**
{{ $project->description }}

<x-mail::button :url="''">
Ver Proyecto
</x-mail::button>

¡Éxito en la gestión!
{{ config('app.name') }}
</x-mail::message>
