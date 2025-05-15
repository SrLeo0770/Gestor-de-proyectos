<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\ProjectAudit;
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

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $leaders = User::whereHas('role', function($q) {
            $q->where('slug', 'project_leader');
        })->get();

        $clients = User::whereHas('role', function($q) {
            $q->where('slug', 'client');
        })->get();

        $teamMembers = User::whereHas('role', function($q) {
            $q->whereNotIn('slug', ['client']);
        })->get();

        return view('projects.create', compact('leaders', 'clients', 'teamMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'leader_id' => 'required|exists:users,id',
            'client_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'team_members' => 'required|array|min:1|exists:users,id'
        ]);

        $project = Project::create($validated + [
            'status' => 'pending'
        ]);

        $project->teamMembers()->attach($request->team_members);

        // Registrar la creación en la auditoría
        ProjectAudit::create([
            'project_id' => $project->id,
            'auditor_id' => Auth::id(),
            'action' => 'create',
            'details' => 'Proyecto creado'
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

        $clients = User::whereHas('role', function($q) {
            $q->where('slug', 'client');
        })->get();

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
            'client_id' => 'required|exists:users,id',
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
                'details' => "Estado cambiado de {$oldStatus} a {$validated['status']}"
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
