<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProjectLogController extends Controller
{
    /**
     * Display a listing of the resource.
     * Tries to get all logs with their project
     * If an exception occurs, it logs the error and returns a 500 response
     * @return \Inertia\Response
     */
    public function index()
    {
        try {
            $logs = \App\Models\Log::with('project')->get(); // Laisser le namespace pour éviter les conflits
            return inertia('Logs/Projects', [
                'logs' => $logs
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de l\'affichage des logs. '], 500);   
        }  
    }
}
