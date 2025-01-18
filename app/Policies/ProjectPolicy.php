<?php
namespace App\Policies;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Project $project)
    {
        return $user->hasTeamPermission($project->team, 'view');
    }

    public function create(User $user, Team $team)
    {
        return $user->hasTeamPermission($team, 'create');
    }

    public function update(User $user, Project $project)
    {
        return $user->hasTeamPermission($project->team, 'update');
    }

    public function delete(User $user, Project $project)
    {
        return $user->hasTeamPermission($project->team, 'delete');
    }
}