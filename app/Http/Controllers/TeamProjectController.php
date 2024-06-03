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
    public function index($team)
    {
        if (!auth()->user()->hasTeamPermission($team, 'view')) {
            abort(403);
        } else {
            return inertia('Teams/Projects', [
                'teamProjects' => Team::findOrFail($team)->projects,
                'teamName' => Team::find($team)->name,
            ]);
        }
    }
}
