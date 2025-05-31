<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'leader_id',
        'client_id',
        'category_id',
        'start_date',
        'end_date',
        'status',
        'progress',
        'estimated_time',
        'team_size',
        'resources',
        'services'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'resources' => 'array',
        'services' => 'array',
        'progress' => 'integer'
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'completed' => 'success',
            'in_progress' => 'primary',
            'on_hold' => 'warning',
            'cancelled' => 'danger',
            default => 'secondary'
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'completed' => 'Completado',
            'in_progress' => 'En Progreso',
            'pending' => 'Pendiente',
            'on_hold' => 'En Espera',
            'cancelled' => 'Cancelado',
            default => ucfirst($this->status)
        };
    }

    public function getLastAuditAttribute()
    {
        return $this->audits()->latest()->first()?->created_at;
    }

    public function leader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function teamMembers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_team')
                    ->withTimestamps();
    }

    public function audits(): HasMany
    {
        return $this->hasMany(ProjectAudit::class);
    }

    public function isLeader(User $user): bool
    {
        return $this->leader_id === $user->id;
    }

    public function isTeamMember(User $user): bool
    {
        return $this->teamMembers()->where('user_id', $user->id)->exists();
    }

    public function canEdit(User $user): bool
    {
        return $this->isLeader($user);
    }

    public function canView(User $user): bool
    {
        return $this->isLeader($user) || 
               $this->isTeamMember($user) || 
               $this->client_id === $user->id;
    }
}
