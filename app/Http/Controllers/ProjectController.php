<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Constants\HttpStatusCodes;
use App\Constants\StatusMessages;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests; // Implémentation des méthodes authorize() et deny()
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
            return response()->json(['error' => StatusMessages::DISPLAY_ERROR], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
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
            $this->authorize('create', [Project::class, $team]);
            $project = new Project();
            $log = new \App\Models\Log(); // Laisser le namespace complet pour éviter les conflits avec Log

            $project->title = $request->json()->get('title');
            $project->description = $request->json()->get('description');
            $project->status_id = $request->json()->get('status_id');
            $project->team_id = $team_id;

            $project->save();

            $this->createLog($project, StatusMessages::CREATE_SUCCESS);

            $log->save();

            Log::info(StatusMessages::CREATE_SUCCESS . $project->id);
            return response()->json([
                'info' => 'Projet créé avec succès.',
                'id' => $project->id
            ], HttpStatusCodes::HTTP_CREATED);
        } catch (\Exception $e) {
        Log::error(StatusMessages::CREATE_ERROR . " " . $request . $e);
        return response()->json(['error' => StatusMessages::CREATE_ERROR], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
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
        $this->authorize('view', $project);
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
            Log::error(StatusMessages::DISPLAY_ERROR . " " . $e);
            return response()->json(['error' => StatusMessages::DISPLAY_ERROR], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
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
        $this->authorize('update', $project);
        try {
            $project->title = $request->input('title');
            $project->description = $request->input('description');
            $project->status_id = $request->input('status_id');
            $project->save();

            $this->createLog($project, StatusMessages::UPDATE_SUCCESS);

            Log::info(StatusMessages::UPDATE_SUCCESS . " " . $project->id);
            return response()->json([
                'info' => StatusMessages::UPDATE_SUCCESS
            ], HttpStatusCodes::HTTP_OK);
        } catch (\Exception $e) {
            Log::error(StatusMessages::UPDATE_ERROR . " " . $request . $e);
            return response()->json([
                'error' => StatusMessages::UPDATE_ERROR
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
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
        $this->authorize('delete', $project);

        try {
            $team = Team::find($project->team_id);
            
            $project->delete();

            Log::info(StatusMessages::DELETE_SUCCESS . " " . $project->id);
            return response()->json([
                'info' => StatusMessages::DELETE_SUCCESS
            ], HttpStatusCodes::HTTP_NO_CONTENT);

        } catch (\Exception $e) {
            Log::error(StatusMessages::DELETE_ERROR . " " . $e);
            return response()->json([
                'error' => StatusMessages::DELETE_ERROR
            ], HttpStatusCodes::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

        /**
     * Create a log entry for the specified project.
     * @param  \App\Models\Project  $project
     * @param  string  $message
     * @return void
     */
    private function createLog(Project $project, string $message)
    {
        $log = new \App\Models\Log(); // Laisser le namespace complet pour éviter les conflits avec Log

        $log->content = $message;
        $log->project_id = $project->id;
        $log->team_id = $project->team_id;
        $log->user_id = auth()->user()->id;

        $log->save();
    }
}