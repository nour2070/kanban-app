<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'status', 'priority', 'deadline', 'project_id', 'user_id', 'attachment'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function booted()
    {
        static::created(function ($task) {
            if (Auth::check()) {
                try {
                    ActivityLog::create([
                        'user_id' => Auth::id(),
                        'description' => "a ajouté la tâche '{$task->title}'",
                    ]);
                } catch (\Exception $e) {}
            }
        });

        static::updated(function ($task) {
            if (Auth::check()) {
                if ($task->wasChanged('status')) {
                    try {
                        ActivityLog::create([
                            'user_id' => Auth::id(),
                            'description' => "a changé le statut de '{$task->title}' à '{$task->status}'",
                        ]);
                    } catch (\Exception $e) {}
                }
            }
        });
    }
}