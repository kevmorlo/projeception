<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     */
    public function index()
    {
        $projects = Project::with('team')->get();
    
        $data = $projects->map(function ($project) {
            return [
                'ID' => $project->id,
                'Title' => $project->title,
                'Description' => $project->description,
                'Team' => $project->team->name
            ];
        });
    
        return inertia('Projects/Index', [
            'projects' => $data
        ]);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        try {
            if (!auth()->user()->hasTeamPermission($request->input('team_id'), 'create')) {
                abort(403);
            } else {
                $project = new Project();
                $project->title = $request->input('title');
                $project->description = $request->input('description');
                $project->team_id = $request->input('team_id');

                $project->save();

                Log::info('Projet créé avec succès.' . $project->id);
                return back()->with('success', 'Projet créé avec succès.');
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la création du projet. ' . $e->getMessage());
            return back()->with('error', 'Une erreur s\'est produite lors de la création du projet.');
        }
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        try {
            $data = Project::with('team')->where('id', $project->id)->get()->map(function ($project) {
                return [
                    'ID' => $project->id,
                    'Title' => $project->title,
                    'Description' => $project->description,
                    'Team' => $project->team->name
                ];
            })->first();
            return inertia('Projects/Show', [
                'project' => $data
            ]);
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de l\'affichage du projet.'.$e->getMessage());
            return back()->with('error', 'Une erreur s\'est produite lors de l\'affichage du projet.');
        }
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        try {
            if (!auth()->user()->hasTeamPermission($project->team_id, 'update')) {
                abort(403);
            } else {
                $project->title = $request->input('title');
                $project->description = $request->input('description');
                $project->save();

                Log::info('Projet mis à jour avec succès.' . $project->id);
                return back()->with('success', 'Projet mis à jour avec succès.');
            }
        } catch (\Exception $e) {
            Log::error('Une erreur s\'est produite lors de la mise à jour du projet. ' . $e->getMessage());
            return back()->with('error', 'Une erreur s\'est produite lors de la mise à jour du projet.');
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
            Log::error('Une erreur s\'est produite lors de la suppression du projet. ' . $e->getMessage());
            return back()->with('error', 'Une erreur s\'est produite lors de la suppression du projet.');
        }
    }
}
