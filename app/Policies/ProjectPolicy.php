<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true; // Todos pueden ver la lista de proyectos (filtrada según su rol)
    }

    public function view(User $user, Project $project): bool
    {
        return $project->canView($user);
    }

    public function create(User $user): bool
    {
        return $user->isProjectLeader();
    }

    public function update(User $user, Project $project): bool
    {
        return $project->canEdit($user);
    }

    public function delete(User $user, Project $project): bool
    {
        return $user->isProjectLeader() && $project->canEdit($user);
    }

    public function addTeamMember(User $user, Project $project): bool
    {
        return $project->canEdit($user);
    }

    public function removeTeamMember(User $user, Project $project): bool
    {
        return $project->canEdit($user);
    }

    public function updateProgress(User $user, Project $project): bool
    {
        return $project->canEdit($user);
    }
} 