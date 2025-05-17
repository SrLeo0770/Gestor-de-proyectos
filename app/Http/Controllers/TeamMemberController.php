<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::with(['user', 'projects' => function($query) {
            $query->where('status', '!=', 'completed')
                  ->with(['projectType', 'category']);
        }])->latest()->paginate(10);
        return view('team-members.index', compact('teamMembers'));
    }

    public function create()
    {
        $users = User::whereDoesntHave('teamMember')->get();
        return view('team-members.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'skills' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        // Convertir el string de habilidades en un array
        if (!empty($validated['skills'])) {
            $validated['skills'] = array_map('trim', explode(',', $validated['skills']));
        } else {
            $validated['skills'] = [];
        }

        // Asegurarse de que is_active tenga un valor booleano
        $validated['is_active'] = $request->has('is_active');

        TeamMember::create($validated);

        return redirect()->route('team-members.index')
            ->with('success', 'Miembro del equipo creado exitosamente.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('team-members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'role' => 'required|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'required|string|max:255',
            'skills' => 'nullable|array',
            'skills.*' => 'string',
            'is_active' => 'boolean',
        ]);

        $teamMember->update($validated);

        return redirect()->route('team-members.index')
            ->with('success', 'Miembro del equipo actualizado exitosamente.');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('team-members.index')
            ->with('success', 'Miembro del equipo eliminado exitosamente.');
    }
} 