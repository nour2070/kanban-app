<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\ActivityLog; 
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', Auth::id())->get();
        $projectIds = $projects->pluck('id');

        $totalProjects = $projects->count();
        $totalTasks = Task::whereIn('project_id', $projectIds)->count();
        $tasksDone = Task::whereIn('project_id', $projectIds)->where('status', 'done')->count();
        $tasksInProgress = Task::whereIn('project_id', $projectIds)->where('status', 'in-progress')->count();
        
        $tasksLate = Task::whereIn('project_id', $projectIds)
            ->where('status', '!=', 'done')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->count();

        $progress = $totalTasks > 0 ? round(($tasksDone / $totalTasks) * 100) : 0;

        $chartData = [
            'todo' => Task::whereIn('project_id', $projectIds)->where('status', 'todo')->count(),
            'in-progress' => $tasksInProgress,
            'review' => Task::whereIn('project_id', $projectIds)->where('status', 'review')->count(),
            'done' => $tasksDone,
        ];

        $lineChartLabels = [];
        $lineChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $lineChartLabels[] = $date->format('d/m');
            $lineChartData[] = Task::whereIn('project_id', $projectIds)
                ->where('status', 'done')
                ->whereDate('updated_at', $date->format('Y-m-d'))
                ->count();
        }

        // 2. Pie Chart: توزيع المهام حسب العضو
        $pieChartData = Task::whereIn('project_id', $projectIds)
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('count(*) as count'))
            ->groupBy('user_id')
            ->with('user')
            ->get();
        
        $pieChartLabels = [];
        $pieChartCounts = [];
        foreach ($pieChartData as $item) {
            $pieChartLabels[] = $item->user ? $item->user->name : 'Non assigné';
            $pieChartCounts[] = $item->count;
        }

        $recentProjects = $projects->sortByDesc('created_at')->take(3);

        try {
            $recentActivities = ActivityLog::where('user_id', Auth::id())
                ->with('user')
                ->latest()
                ->take(5)
                ->get();
        } catch (\Exception $e) {
            $recentActivities = collect();
        }

        return view('dashboard', compact(
            'totalProjects', 'totalTasks', 'tasksDone', 'tasksInProgress', 'tasksLate', 
            'progress', 'chartData', 'recentProjects', 'recentActivities',
            'lineChartLabels', 'lineChartData', 'pieChartLabels', 'pieChartCounts'
        ));
    }
}