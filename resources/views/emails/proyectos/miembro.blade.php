<x-mail::message>
# ¡Hola, {{ $miembro->name }}!

Has sido agregado como miembro al proyecto:

**Nombre del Proyecto:** {{ $project->name }}
**Líder:** {{ $project->leader->name ?? '-' }}
**Cliente:** {{ $project->client->name ?? '-' }}
**Fecha de inicio:** {{ $project->start_date }}
**Fecha de fin:** {{ $project->end_date }}

**Descripción:**
{{ $project->description }}

<x-mail::button :url="''">
Ver Proyecto
</x-mail::button>

¡Gracias por tu colaboración!
{{ config('app.name') }}
</x-mail::message>
