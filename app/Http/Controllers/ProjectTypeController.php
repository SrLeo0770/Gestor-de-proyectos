<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;

class ProjectTypeController extends Controller
{
    public function index()
    {
        $projectTypes = ProjectType::latest()->paginate(10);
        return view('project-types.index', compact('projectTypes'));
    }

    public function create()
    {
        return view('project-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        ProjectType::create($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Tipo de proyecto creado exitosamente.');
    }

    public function edit(ProjectType $projectType)
    {
        return view('project-types.edit', compact('projectType'));
    }

    public function update(Request $request, ProjectType $projectType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $projectType->update($validated);

        return redirect()->route('project-types.index')
            ->with('success', 'Tipo de proyecto actualizado exitosamente.');
    }

    public function destroy(ProjectType $projectType)
    {
        $projectType->delete();
        return redirect()->route('project-types.index')
            ->with('success', 'Tipo de proyecto eliminado exitosamente.');
    }
} 