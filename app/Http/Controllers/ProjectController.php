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
        try {
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
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de l\'affichage des projets. '], 500);
        }
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
     * Log the creation of the project.
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
                $log = new \App\Models\Log(); // Laisser le namespace complet pour éviter les conflits avec Log

                $project->title = $request->json()->get('title');
                $project->description = $request->json()->get('description');
                $project->status_id = $request->json()->get('status_id');
                $project->team_id = $team_id;

                $project->save();

                $log->content = 'Projet créé avec succès. ';
                $log->project_id = $project->id;
                $log->team_id = $team_id;
                $log->user_id = auth()->user()->id;

                $log->save();

                Log::info('Projet créé avec succès. ' . $project->id);
                return response()->json([
                    'info' => 'Projet créé avec succès.',
                    'id' => $project->id
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la création du projet. ' . $request . $e);
            return response()->json(['error' => 'Une erreur s\'est produite lors de la création du projet.'], 500);
        }
    }

    /**
     * Display the specified project.
     * Check if the authenticated user has the permission to view the project.
     * If the user has the permission, return the inertia view for the project.
     * If an error occurs, log the error and return a JSON response with an error message.
     * @param  \App\Models\Project  $project
     * @return \Inertia\Response
     * @throws \Exception
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
                        'TeamId' => $project->team_id,
                        'StatusId' => $project->status_id,
                    ];
                })->first();
                return inertia('Projects/Show', [
                    'project' => $data
                ]);
            } catch (\Exception $e) {
                Log::error('Une erreur s\'est produite lors de l\'affichage du projet.' . $e);
                return response()->json(['error' => 'Une erreur s\'est produite lors de l\'affichage du projet.'], 500);
            }
        }
    }

    /**
     * Update the specified project in storage.
     * Check if the authenticated user has the permission to update the project.
     * If the user has the permission, update the project and save it in the database.
     * Log the update of the project.
     * Return a JSON response with a success message.
     * If an error occurs, log the error and return a JSON response with an error message.
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function update(Request $request, Project $project)
    {
        $team = Team::find($project->team_id);
        if (!auth()->user()->hasTeamPermission($team, 'update')) {
            abort(403);
        } else {
            try {
                $project->title = $request->input('title');
                $project->description = $request->input('description');
                $project->status_id = $request->input('status_id');
                $project->save();

                $log = new \App\Models\Log(); // Laisser le namespace complet pour éviter les conflits avec Log

                $log->content = 'Projet mis à jour avec succès. ';
                $log->project_id = $project->id;
                $log->team_id = $project->team_id;
                $log->user_id = auth()->user()->id;

                $log->save();

                Log::info('Projet mis à jour avec succès. ' . $project->id);
                return response()->json([
                    'info' => 'Projet mis à jour avec succès.'
                ]);
            } catch (\Exception $e) {
                Log::error('Une erreur s\'est produite lors de la mise à jour du projet. ' . $request . $e);
                return response()->json([
                    'error' => 'Une erreur s\'est produite lors de la mise à jour du projet.'
                ], 500);
            }
        }
    }

    /**
     * Remove the specified project from storage.
     * Check if the authenticated user has the permission to delete the project.
     * If the user has the permission, log the deletion of the project.
     * Delete the project.
     * Return a JSON response with a success message.
     * If an error occurs, log the error and return a JSON response with an error message.
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        try {
            $team = Team::find($project->team_id);
            if (!auth()->user()->hasTeamPermission($team, 'delete')) {
                abort(403);
            } else {
                // On log avant la suppression pour avoir les informations du projet
                $log = new \App\Models\Log(); // Laisser le namespace complet pour éviter les conflits avec Log

                $log->content = 'Projet supprimé avec succès. ';
                $log->project_id = $project->id;
                $log->team_id = $project->team_id;
                $log->user_id = auth()->user()->id;

                $log->save();

                $project->delete();

                Log::info('Projet supprimé avec succès. ' . $project->id);
                return response()->json([
                    'info' => 'Projet supprimé avec succès.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la suppression du projet. ' . $e);
            return response()->json([
                'error' => 'Une erreur s\'est produite lors de la suppression du projet.'
            ], 500);
        }
    }
}
