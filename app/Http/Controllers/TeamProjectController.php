<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TeamProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($teamId)
    {
        try {
            $team = Team::findOrFail($teamId);
            if (!auth()->user()->hasTeamPermission($team, 'view')) {
                abort(403);
            } else {
                return inertia('Teams/Projects', [
                    'teamProjects' => $team->projects,
                    'teamName' => $team->name,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Une erreur est survenue lors de l\'affichage des projets. ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue lors de l\'affichage des projets.');
        }
    }
}

