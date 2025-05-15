<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function createdReports(Request $request)
    {
        $query = Project::query();

        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('created_at', $date);
        }

        if ($request->filled('month')) {
            $query->whereMonth('created_at', $request->month)
                  ->whereYear('created_at', $request->year ?? now()->year);
        }

        if ($request->filled('year')) {
            $query->whereYear('created_at', $request->year);
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

        $projects = $query->with(['projectType', 'category', 'leader', 'client'])
                         ->latest()
                         ->get();

        return view('reports.created', compact('projects'));
    }

    public function inProgressReports()
    {
        $query = Project::where('status', 'in-progress');

        if (!Auth::user()->isProjectLeader()) {
            if (Auth::user()->isClient()) {
                $query->where('client_id', Auth::id());
            } else {
                $query->whereHas('teamMembers', function($q) {
                    $q->where('user_id', Auth::id());
                });
            }
        }

        $projects = $query->with(['projectType', 'category', 'leader', 'client'])
                         ->latest()
                         ->get();

        return view('reports.in-progress', compact('projects'));
    }

    public function completedReports(Request $request)
    {
        $query = Project::where('status', 'completed');

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

        $projects = $query->with(['projectType', 'category', 'leader', 'client'])
                         ->latest()
                         ->get();

        return view('reports.completed', compact('projects'));
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
            $q->with(['projectType', 'category', 'client']);
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
            $q->with(['projectType', 'category', 'leader']);
        }])->get();

        return view('reports.by-client', compact('clients'));
    }
}
