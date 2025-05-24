<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Client;
use App\Models\Project;
use App\Models\Category;
use App\Models\ProjectAudit;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

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
            'status' => 'pending',
            'progress' => 0,
        ]);

        $project->teamMembers()->attach($this->team_members);

        ProjectAudit::create([
            'project_id' => $project->id,
            'auditor_id' => Auth::id(),
            'action' => 'create',
            'details' => 'Proyecto creado: ' . $project->name
        ]);

        session()->flash('success', 'Proyecto creado exitosamente.');
        return redirect()->route('projects.index');
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