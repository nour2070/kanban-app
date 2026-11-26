<?php

namespace App\Livewire;

use App\Models\Task;
use App\Models\Comment;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TaskComments extends Component
{
    public $taskId;
    public $content = '';
    public $comments = [];

    public function mount($taskId)
    {
        $this->taskId = $taskId;
        $this->loadComments();
    }

    public function loadComments()
    {
        $this->comments = Comment::where('task_id', $this->taskId)->with('user')->latest()->get();
    }

    public function addComment()
    {
        $this->validate(['content' => 'required|string|max:500']);

        Comment::create([
            'content' => $this->content,
            'task_id' => $this->taskId,
            'user_id' => Auth::id(),
        ]);

        $this->reset('content');
        $this->loadComments();
    }

    public function render()
    {
        return view('livewire.task-comments');
    }
}