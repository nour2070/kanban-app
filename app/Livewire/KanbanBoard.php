<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Project;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KanbanBoard extends Component
{
    use WithFileUploads;

    public $projectId;
    public $projects = [];
    public $tasks;
    public $members = [];

    public $showModal = false;
    public $title = '';
    public $description = '';
    public $priority = 'Moyenne';
    public $deadline = '';
    public $assignedTo = '';
    public $attachment;

    public $search = '';
    public $selectedTask = null;
    public $newComment = '';

    protected $listeners = ['updateTaskStatus' => 'updateTaskStatus'];

    public function mount($projectId = null)
    {
        $this->projects = Project::where('user_id', Auth::id())->get();

        if ($projectId) {
            $this->projectId = $projectId;
        } elseif ($this->projects->isNotEmpty()) {
            $this->projectId = $this->projects->first()->id;
        }

        $this->members = User::where('id', '!=', Auth::id())->get();
        $this->loadTasks();
    }

    public function updatedProjectId()
    {
        $this->loadTasks();
    }

    public function loadTasks()
    {
        if (!$this->projectId) {
            $this->tasks = collect();
            return;
        }

        $query = Task::where('project_id', $this->projectId);

        if (trim($this->search) !== '') {
            $searchTerm = trim($this->search);
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        $this->tasks = $query->get();
    }

    public function updatedSearch()
    {
        $this->loadTasks();
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::where('project_id', $this->projectId)->find($taskId);
        if (!$task || !in_array($newStatus, ['todo', 'in-progress', 'review', 'done'])) return;

        $task->status = $newStatus;
        $task->save();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $this->projectId,
            'action' => 'moved_task',
            'description' => 'a déplacé la tâche "' . $task->title . '" vers ' . $newStatus,
        ]);

        $this->loadTasks();
    }

    public function deleteTask($taskId)
    {
        $task = Task::where('project_id', $this->projectId)->find($taskId);
        
        if ($task) {
            if ($task->attachment) {
                Storage::disk('public')->delete($task->attachment);
            }

            ActivityLog::create([
                'user_id' => Auth::id(),
                'project_id' => $this->projectId,
                'action' => 'deleted_task',
                'description' => 'a supprimé la tâche "' . $task->title . '"',
            ]);

            $task->delete();
            $this->loadTasks();
        }
    }

    public function addTask()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:Basse,Moyenne,Haute,Urgente',
            'deadline' => 'nullable|date',
            'assignedTo' => 'nullable|exists:users,id',
            'attachment' => 'nullable|file|max:10240',
        ]);

        if (!$this->projectId) return;

        $attachmentPath = null;
        if ($this->attachment) {
            $attachmentPath = $this->attachment->store('attachments', 'public');
        }

        $task = Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'priority' => $this->priority,
            'deadline' => $this->deadline ?: null,
            'status' => 'todo',
            'project_id' => $this->projectId,
            'user_id' => $this->assignedTo ?: Auth::id(),
            'attachment' => $attachmentPath,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'project_id' => $this->projectId,
            'action' => 'created_task',
            'description' => 'a créé la tâche "' . $this->title . '"',
        ]);

        if ($this->assignedTo && $this->assignedTo != Auth::id()) {
            Notification::create([
                'message' => 'Une tâche vous a été assignée : "' . $this->title . '"',
                'user_id' => $this->assignedTo,
                'task_id' => $task->id,
                'is_read' => false,
            ]);
        }

        $this->reset(['title', 'description', 'deadline', 'assignedTo', 'attachment', 'showModal']);
        $this->priority = 'Moyenne';
        $this->loadTasks();
    }

    public function openTaskModal($taskId)
    {
        $this->selectedTask = Task::with('comments.user')->find($taskId);
    }

    public function closeTaskModal()
    {
        $this->selectedTask = null;
        $this->newComment = '';
    }

    public function addComment()
    {
        $this->validate(['newComment' => 'required|string|max:500']);
        
        if (!$this->selectedTask) return;

        $task = Task::find($this->selectedTask->id);
        if (!$task) return;

        $task->comments()->create([
            'content' => $this->newComment,
            'user_id' => Auth::id(),
        ]);
        
        $this->newComment = '';
        $this->selectedTask = Task::with('comments.user')->find($this->selectedTask->id);
    }

    public function render()
    {
        $this->loadTasks();
        return view('livewire.kanban-board');
    }
}