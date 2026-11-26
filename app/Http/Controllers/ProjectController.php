<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->latest()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'color' => 'required|string',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        // 2. Création du projet
        $project = Project::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'color' => $request->color,
            'user_id' => Auth::id(),
        ]);

        // 3. Création de l'équipe et attachement des membres
        if ($request->has('members') && count($request->members) > 0) {
            $team = Team::create([
                'name' => 'Équipe ' . $project->name,
                'project_id' => $project->id,
            ]);
            
            $team->users()->attach($request->members);
            
            $team->users()->attach(Auth::id());
        } else {
            $team = Team::create([
                'name' => 'Équipe ' . $project->name,
                'project_id' => $project->id,
            ]);
            $team->users()->attach(Auth::id());
        }

        return redirect()->route('projects.index')->with('success', 'Projet créé avec succès !');
    }

    public function show(Project $project)
    {
        if ($project->user_id !== Auth::id()) {
            abort(403);
        }

        $tasks = $project->tasks;
        
        $totalTasks = $tasks->count();
        $doneTasks = $tasks->where('status', 'done')->count();
        $inProgressTasks = $tasks->where('status', 'in-progress')->count();
        $reviewTasks = $tasks->where('status', 'review')->count();
        $todoTasks = $tasks->where('status', 'todo')->count();
        
        $progress = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;

        return view('projects.show', compact(
            'project', 'tasks', 'totalTasks', 'doneTasks', 'inProgressTasks', 'reviewTasks', 'todoTasks', 'progress'
        ));
    }
}