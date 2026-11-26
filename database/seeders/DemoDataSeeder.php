<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\ActivityLog;
use App\Models\Notification;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. نجيبو المستخدمين اللي خلقناهم قبل
        $nour = User::where('email', 'nour@gmail.com')->first();
        $ahmed = User::where('email', 'ahmed@gmail.com')->first();
        $sara = User::where('email', 'sara@gmail.com')->first();

        if (!$nour || !$ahmed || !$sara) {
            $this->command->error('❌ Les utilisateurs n\'existent pas. Lancez d\'abord ResetUsersSeeder.');
            return;
        }

        // 2. نخلقو المشاريع
        $projectsData = [
            ['name' => 'Refonte Site E-commerce', 'description' => 'Création d\'une nouvelle plateforme e-commerce moderne.', 'color' => '#7C3AED', 'user_id' => $nour->id],
            ['name' => 'Application Mobile', 'description' => 'Application mobile pour la gestion de tâches.', 'color' => '#3B82F6', 'user_id' => $nour->id],
            ['name' => 'Refonte du Dashboard', 'description' => 'Modernisation de l\'interface administrateur.', 'color' => '#22C55E', 'user_id' => $nour->id],
        ];

        foreach ($projectsData as $projData) {
            $project = Project::firstOrCreate(
                ['name' => $projData['name']],
                array_merge($projData, [
                    'start_date' => Carbon::now()->subDays(30),
                    'end_date' => Carbon::now()->addDays(30),
                ])
            );

            // 3. نخلقو الفريق ونضيفو الأعضاء
            $team = Team::firstOrCreate([
                'project_id' => $project->id,
                'name' => 'Équipe ' . $project->name,
            ]);
            
            $team->users()->syncWithoutDetaching([$nour->id, $ahmed->id, $sara->id]);

            // 4. نخلقو 10 مهام لكل مشروع
            $statuses = ['todo', 'in-progress', 'review', 'done'];
            $priorities = ['Basse', 'Moyenne', 'Haute', 'Urgente'];
            $members = [$nour, $ahmed, $sara];

            for ($i = 1; $i <= 10; $i++) {
                $status = $statuses[array_rand($statuses)];
                $deadline = Carbon::now()->addDays(rand(-10, 20)); // بعضها متأخرة
                
                $task = Task::create([
                    'title' => "Tâche " . $i . " - " . $project->name,
                    'description' => "Description détaillée pour la tâche " . $i . ".",
                    'status' => $status,
                    'priority' => $priorities[array_rand($priorities)],
                    'deadline' => $deadline,
                    'project_id' => $project->id,
                    'user_id' => $members[array_rand($members)]->id,
                ]);

                // 5. نسجلو النشاط
                ActivityLog::create([
                    'user_id' => $nour->id,
                    'description' => 'a créé la tâche "' . $task->title . '"',
                ]);
            }
        }

        $this->command->info('✅ Données de démonstration créées avec succès !');
        $this->command->info('   3 projets, 30 tâches.');
    }
}