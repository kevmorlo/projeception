<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::with('team')->where('status_id', 2)->get();
        
        $data = $projects->map(function ($project) {
            return [
            'Id' => $project->id,
            'Title' => $project->title,
            'Description' => $project->description,
            'Team' => $project->team->name,
            'TeamId' => $project->team_id
            ];
        });
    
        return inertia('Projects/Index', [
            'projects' => $data
        ]);
    }

    /**
     * Creates a new project.
     * Return the inertia view for creating a new project.
     * @return \Inertia\Response
     */
    public function create()
    {
        $team_id = auth()->user()->currentTeam->id;
        return inertia('Projects/Create', ['teamId' => $team_id]);
    }

    /**
     * Store a newly created project in storage.
     * Check if the authenticated user has the permission to create a project.
     * If the user has the permission, create a new project and save it in the database.
     * Return a JSON response with the project ID for the front-end.
     * If an error occurs, log the error and return a JSON response with an error message.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function store(Request $request)
    {
        try {
            $team_id = $request->json()->get('team_id');
            $team = Team::find($team_id);
            if (!auth()->user()->hasTeamPermission($team, 'create')) {
                abort(403, 'L\'utilisateur n\'a pas la permission de créer un projet pour cette équipe.');
            } else {
                $project = new Project();
                $project->title = $request->json()->get('title');
                $project->description = $request->json()->get('description');
                $project->status_id = 1;
                $project->team_id = $team_id;

                $project->save();

                Log::info('Projet créé avec succès.' . $project->id);
                return response()->json(['id' => $project->id]);
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la création du projet. ' . $request . $e);
            return response()->json(['error' => 'Une erreur s\'est produite lors de la création du projet.'], 500);
        }
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        $team = Team::find($project->team_id);
        if (!auth()->user()->hasTeamPermission($team, 'view')) {
            abort(403, 'L\'utilisateur n\'a pas la permission de créer un projet pour cette équipe.');
        } else {
            try {
                $data = Project::with('team')->where('id', $project->id)->get()->map(function ($project) {
                    return [
                        'Id' => $project->id,
                        'Title' => $project->title,
                        'Description' => $project->description,
                        'Team' => $project->team->name,
                        'TeamId' => $project->team_id
                    ];
                })->first();
                return inertia('Projects/Show', [
                    'project' => $data
                ]);
            } catch (\Exception $e) {
                Log::error('Une erreur s\'est produite lors de l\'affichage du projet.' . $e);
                return back()->with('error', 'Une erreur s\'est produite lors de l\'affichage du projet.');
            }
        }
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        if (!auth()->user()->hasTeamPermission($project->team_id, 'update')) {
            abort(403);
        } else {
            try {
                $project->title = $request->input('title');
                $project->description = $request->input('description');
                $project->save();

                Log::info('Projet mis à jour avec succès.' . $project->id);
                return back()->with('success', 'Projet mis à jour avec succès.');
            } catch (\Exception $e) {
                Log::error('Une erreur s\'est produite lors de la mise à jour du projet. ' . $e);
                return back()->with('error', 'Une erreur s\'est produite lors de la mise à jour du projet.');
            }
        }
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        try {
            if (!auth()->user()->hasTeamPermission($project->team_id, 'delete')) {
                abort(403);
            } else {
                $project->delete();

                Log::info('Projet supprimé avec succès.' . $project->id);
                return back()->with('success', 'Projet supprimé avec succès.');
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la suppression du projet. ' . $e);
            return back()->with('error', 'Une erreur s\'est produite lors de la suppression du projet.');
        }
    }
}
