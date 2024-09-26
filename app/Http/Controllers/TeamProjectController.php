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
     * Tries to get all projects of a team
     * If the user does not have the permission to view the team, it aboarts with a 403 response
     * If an exception occurs, it logs the error and returns a 500 response
     * @param  int  $teamId
     * @return \Inertia\Response
     * @throws \Exception
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
            return inertia('Error', [
                'code' => 500,
                'message' => 'Une erreur est survenue lors de l\'affichage des projets.'
            ]);
        }
    }
}

