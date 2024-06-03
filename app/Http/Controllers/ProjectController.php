<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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
        if (!auth()->user()->hasTeamPermission($request->input('team_id'), 'create')) {
            abort(403);
        } else {
            $project = new Project();
            $project->title = $request->input('title');
            $project->description = $request->input('description');
            $project->team_id = $request->input('team_id');

            $project->save();

            return back()->with('success', 'Projet créé avec succès.');
        }
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
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
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
