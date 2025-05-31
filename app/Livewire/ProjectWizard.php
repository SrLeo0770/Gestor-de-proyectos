<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Category;
use App\Models\ProjectAudit;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Mail\ProyectoCreadoClienteMailable;
use App\Mail\ProyectoCreadoLiderMailable;
use App\Mail\ProyectoCreadoMiembroMailable;
use Illuminate\Support\Facades\Mail;

class ProjectWizard extends Component
{
    public $currentStep = 1;
    public $totalSteps = 4;
    
    // Step 1: Basic Information
    public $name = '';
    public $description = '';
    public $category_id = '';
    
    // Step 2: Team and Responsibilities
    public $leader_id = '';
    public $client_id = '';
    public $team_members = [];
    public $team_size = 1;
    
    // Step 3: Dates and Resources
    public $start_date = '';
    public $end_date = '';
    public $estimated_time = '';
    public $resources = '';
    public $services = '';
    
    // Step 4: Status
    public $status = 'in_progress';

    // Correos manuales para notificación
    public $manual_client_email = '';
    public $manual_leader_email = '';
    public $manual_member_emails = '';
    
    protected $rules = [
        // Step 1 validation
        'name' => 'required|string|max:255',
        'description' => 'required|string',
        'category_id' => 'required|exists:categories,id',
        
        // Step 2 validation
        'leader_id' => 'required|exists:users,id',
        'client_id' => 'required|exists:clients,id',
        'team_members' => 'required|array|min:1|exists:users,id',
        'team_size' => 'required|integer|min:1',
        
        // Step 3 validation
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'estimated_time' => 'required|integer|min:1',
        'resources' => 'nullable|string',
        'services' => 'nullable|string',
        
        // Step 4 validation
        'status' => 'required|in:pending,in_progress,completed,on_hold,cancelled',
        'manual_client_email' => 'nullable|email',
        'manual_leader_email' => 'nullable|email',
        'manual_member_emails' => 'nullable|string', // separados por coma
    ];

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d', strtotime('+1 month'));
    }

    public function nextStep()
    {
        $this->validateStep($this->currentStep);
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    protected function validateStep($step)
    {
        $validationRules = [];
        
        switch ($step) {
            case 1:
                $validationRules = [
                    'name' => $this->rules['name'],
                    'description' => $this->rules['description'],
                    'category_id' => $this->rules['category_id'],
                ];
                break;
            case 2:
                $validationRules = [
                    'leader_id' => $this->rules['leader_id'],
                    'client_id' => $this->rules['client_id'],
                    'team_members' => $this->rules['team_members'],
                    'team_size' => $this->rules['team_size'],
                ];
                break;
            case 3:
                $validationRules = [
                    'start_date' => $this->rules['start_date'],
                    'end_date' => $this->rules['end_date'],
                    'estimated_time' => $this->rules['estimated_time'],
                ];
                break;
            case 4:
                $validationRules = [
                    'status' => $this->rules['status'],
                ];
                break;
        }
        
        $this->validate($validationRules);
    }

    public function createProject()
    {
        $this->validate();

        $project = Project::create([
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
            'leader_id' => $this->leader_id,
            'client_id' => $this->client_id,
            'team_size' => $this->team_size,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'estimated_time' => $this->estimated_time,
            'resources' => $this->resources ? explode(',', $this->resources) : [],
            'services' => $this->services ? explode(',', $this->services) : [],
            'status' => $this->status,
            'progress' => 0,
        ]);

        $project->teamMembers()->attach($this->team_members);

        ProjectAudit::create([
            'project_id' => $project->id,
            'auditor_id' => Auth::id(),
            'action' => 'create',
            'details' => 'Proyecto creado: ' . $project->name
        ]);

        // Enviar correo al cliente (manual si se ingresó)
        $cliente = Client::find($this->client_id);
        $clientEmail = $this->manual_client_email ?: ($cliente ? $cliente->email : null);
        if ($clientEmail) {
            Mail::to($clientEmail)->send(new ProyectoCreadoClienteMailable($project, $cliente));
        }
        // Enviar correo al líder (manual si se ingresó)
        $lider = User::find($this->leader_id);
        $leaderEmail = $this->manual_leader_email ?: ($lider ? $lider->email : null);
        if ($leaderEmail) {
            Mail::to($leaderEmail)->send(new ProyectoCreadoLiderMailable($project, $lider));
        }
        // Enviar correo a cada miembro (manual si se ingresó)
        $miembros = User::whereIn('id', $this->team_members)->get();
        $manualMembers = array_filter(array_map('trim', explode(',', $this->manual_member_emails)));
        $memberEmails = $miembros->pluck('email')->filter()->merge($manualMembers)->unique();
        foreach ($memberEmails as $email) {
            if ($email) {
                Mail::to($email)->send(new ProyectoCreadoMiembroMailable($project, $lider));
            }
        }

        session()->flash('success', 'Proyecto creado exitosamente. Se han enviado las notificaciones por correo.');
        return redirect()->route('projects.ticket', $project->id);
    }

    public function render()
    {
        return view('livewire.project-wizard', [
            'categories' => Category::all(),
            'leaders' => User::whereHas('role', function($q) {
                $q->where('slug', 'project_leader');
            })->get(),
            'clients' => Client::all(),
            'teamMembers' => User::whereHas('role', function($q) {
                $q->whereNotIn('slug', ['client', 'admin']);
            })->get(),
        ]);
    }
}