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

        $data = [];
        $i = 0;
        
        foreach ($projects as $project) {
            $i++;
            $data[$i] = [
                'ID' => $project->id,
                'Title' => $project->title,
                'Description' => $project->description,
                'Team' => $project->team->name
            ];
        }
        
        return response()->json($data);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        // $project = new Project();
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        //
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
