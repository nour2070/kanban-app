<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $projectIds = $projects->pluck('id');
        
        $teams = Team::whereIn('project_id', $projectIds)->with('users', 'project')->get();
        
        return view('teams.index', compact('teams'));
    }
}