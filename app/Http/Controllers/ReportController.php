<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function inProgressReports(Request $request)
    {
        $query = Project::where('status', 'in_progress');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if (!Auth::user()->isProjectLeader()) {
            if (Auth::user()->isClient()) {
                $query->where('client_id', Auth::id());
            } else {
                $query->whereHas('teamMembers', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }
        }

        $projects = $query->with(['category', 'leader', 'client'])
                         ->latest()
                         ->get();

        $categories = \App\Models\Category::all();

        // Exportación
        if ($request->get('export') === 'excel') {
            // Aquí podrías usar Laravel Excel
            // return Excel::download(new ProjectsExport($projects), 'proyectos_en_ejecucion.xlsx');
        }
        if ($request->get('export') === 'pdf') {
            // Aquí podrías usar DomPDF o Snappy
            // $pdf = PDF::loadView('reports.in-progress-pdf', compact('projects'));
            // return $pdf->download('proyectos_en_ejecucion.pdf');
        }

        return view('reports.in-progress', compact('projects', 'categories'));
    }

    public function completedReports(Request $request)
    {
        $query = Project::where('status', 'completed');

        if ($request->filled('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }
        if ($request->filled('completion_status')) {
            $query->where('completion_status', $request->completion_status);
        }
        if (!Auth::user()->isProjectLeader()) {
            if (Auth::user()->isClient()) {
                $query->where('client_id', Auth::id());
            } else {
                $query->whereHas('teamMembers', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }
        }

        $projects = $query->with(['category', 'leader', 'client'])
                         ->latest()
                         ->get();

        $categories = \App\Models\Category::all();

        // Exportación
        if ($request->get('export') === 'excel') {
            // Aquí podrías usar Laravel Excel
            // return Excel::download(new ProjectsExport($projects), 'proyectos_finalizados.xlsx');
        }
        if ($request->get('export') === 'pdf') {
            // Aquí podrías usar DomPDF o Snappy
            // $pdf = PDF::loadView('reports.completed-pdf', compact('projects'));
            // return $pdf->download('proyectos_finalizados.pdf');
        }

        return view('reports.completed', compact('projects', 'categories'));
    }

    public function reportsByLeader(Request $request)
    {
        if (!Auth::user()->isProjectLeader() && !Auth::user()->isClient()) {
            abort(403);
        }

        $query = User::whereHas('role', function($q) {
            $q->where('slug', 'project-leader');
        });

        if (Auth::user()->isClient()) {
            $query->whereHas('ledProjects', function($q) {
                $q->where('client_id', Auth::id());
            });
        }

        $leaders = $query->with(['ledProjects' => function($q) {
            $q->with(['category', 'client']);
        }])->get();

        return view('reports.by-leader', compact('leaders'));
    }

    public function reportsByClient()
    {
        if (!Auth::user()->isProjectLeader()) {
            abort(403);
        }

        $clients = User::whereHas('role', function($q) {
            $q->where('slug', 'client');
        })->with(['clientProjects' => function($q) {
            $q->with(['category', 'leader']);
        }])->get();

        return view('reports.by-client', compact('clients'));
    }
}
