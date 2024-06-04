<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($teamId)
    {
        $team = Team::findOrFail($teamId);
        if (!auth()->user()->hasTeamPermission($team, 'view')) {
            abort(403);
        } else {
            return inertia('Teams/Projects', [
                'teamProjects' => $team->projects,
                'teamName' => $team->name,
            ]);
        }
    }
}
