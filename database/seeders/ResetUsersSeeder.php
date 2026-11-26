<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\ActivityLog;
use App\Models\Notification;
use App\Models\Comment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResetUsersSeeder extends Seeder
{
    public function run(): void
    {
        // 1. نمسحو كل البيانات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        Project::truncate();
        Task::truncate();
        Team::truncate();
        ActivityLog::truncate();
        Notification::truncate();
        Comment::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 2. نخلقو المستخدمين الجدد بكلمة سر 12345678
        $admin = User::create([
            'name' => 'Nour',
            'email' => 'nour@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $user1 = User::create([
            'name' => 'Ahmed',
            'email' => 'ahmed@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name' => 'Sara',
            'email' => 'sara@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 3 utilisateurs créés avec succès !');
        $this->command->info('   Admin : nour@gmail.com / 12345678');
        $this->command->info('   User 1 : ahmed@gmail.com / 12345678');
        $this->command->info('   User 2 : sara@gmail.com / 12345678');
    }
}