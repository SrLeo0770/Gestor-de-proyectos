<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAudit;
use App\Models\ProjectType;
use App\Models\Category;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $query = Project::query();
        
        if (!Auth::user()->isAdmin()) {
            if (Auth::user()->isClient()) {
                $query->where('client_id', Auth::id());
            } elseif (Auth::user()->isProjectLeader()) {
                $query->where('leader_id', Auth::id());
            } else {
                $query->whereHas('teamMembers', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }
        }

        $projects = $query->with(['leader', 'client'])
                         ->latest()
                         ->paginate(10);

        // Obtener datos adicionales para el dashboard
        $teamMembers = User::whereHas('role', function($q) {
            $q->whereNotIn('slug', ['client', 'admin']);
        })->withCount(['teamProjects' => function($query) {
            $query->where('status', '!=', 'completed');
        }])->get();

        $categories = Category::withCount('projects')->get();
        
        $clients = Client::withCount('projects')->get();
        
        $projectTypes = ProjectType::withCount('projects')->get();

        return view('projects.index', compact('projects', 'teamMembers', 'categories', 'clients', 'projectTypes'));
    }

    public function create()
    {
        $leaders = User::whereHas('role', function($q) {
            $q->where('slug', 'project_leader');
        })->get();

        $clients = Client::all();

        $teamMembers = User::whereHas('role', function($q) {
            $q->whereNotIn('slug', ['client', 'admin']);
        })->get();

        $projectTypes = ProjectType::all();
        $categories = Category::all();

        return view('projects.create', compact('leaders', 'clients', 'teamMembers', 'projectTypes', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'leader_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'project_type_id' => 'required|exists:project_types,id',
            'category_id' => 'required|exists:categories,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'estimated_time' => 'required|integer|min:1',
            'team_size' => 'required|integer|min:1',
            'resources' => 'nullable|string',
            'services' => 'nullable|string',
            'team_members' => 'required|array|min:1|exists:users,id'
        ]);

        $project = Project::create($validated + [
            'status' => 'pending',
            'progress' => 0,
            'resources' => $request->resources ? explode(',', $request->resources) : [],
            'services' => $request->services ? explode(',', $request->services) : []
        ]);

        $project->teamMembers()->attach($request->team_members);

        // Registrar la creación en la auditoría
        ProjectAudit::create([
            'project_id' => $project->id,
            'auditor_id' => Auth::id(),
            'action' => 'create',
            'details' => 'Proyecto creado: ' . $project->name
        ]);

        return redirect()->route('projects.index')
                        ->with('success', 'Proyecto creado exitosamente.');
    }

    public function show(Project $project)
    {
        $project->load(['leader', 'client', 'teamMembers', 'audits.auditor']);
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $leaders = User::whereHas('role', function($q) {
            $q->where('slug', 'project_leader');
        })->get();

        $clients = Client::all();

        $teamMembers = User::whereHas('role', function($q) {
            $q->whereNotIn('slug', ['client']);
        })->get();

        return view('projects.edit', compact('project', 'leaders', 'clients', 'teamMembers'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'leader_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:pending,in-progress,completed',
            'team_members' => 'required|array|min:1|exists:users,id'
        ]);

        $oldStatus = $project->status;
        $project->update($validated);
        $project->teamMembers()->sync($request->team_members);

        // Registrar cambios en la auditoría
        if ($oldStatus !== $validated['status']) {
            ProjectAudit::create([
                'project_id' => $project->id,
                'auditor_id' => Auth::id(),
                'action' => 'status_change',
                'details' => "Estado del proyecto '{$project->name}' cambiado de {$oldStatus} a {$validated['status']}"
            ]);
        }

        return redirect()->route('projects.show', $project)
                        ->with('success', 'Proyecto actualizado exitosamente.');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')
                        ->with('success', 'Proyecto eliminado exitosamente.');
    }
}
