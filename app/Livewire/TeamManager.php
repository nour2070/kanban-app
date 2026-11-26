<?php

namespace App\Livewire;

use App\Models\Team;
use App\Models\User;
use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class TeamManager extends Component
{
    public $projectId;
    public $showModal = false;
    public $email = '';
    public $teamName = '';

    public function mount($projectId)
    {
        $this->projectId = $projectId;
    }

    public function inviteMember()
    {
        $this->validate([
            'email' => 'required|email|exists:users,email',
            'teamName' => 'required|string|max:255',
        ]);

        $user = User::where('email', $this->email)->first();
        
    
        $team = Team::firstOrCreate([
            'project_id' => $this->projectId,
            'name' => $this->teamName
        ]);


        if (!$team->users()->where('user_id', $user->id)->exists()) {
            $team->users()->attach($user->id);
        }

        $this->reset(['email', 'teamName', 'showModal']);
    }

    public function render()
    {
        $project = Project::with('teams.users', 'user')->find($this->projectId);
        return view('livewire.team-manager', compact('project'));
    }
}