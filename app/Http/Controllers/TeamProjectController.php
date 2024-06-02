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
        $teamProjects = Team::find($team)->projects;
        return inertia('teamProjects.index', compact('teamProjects'));
    }
}
