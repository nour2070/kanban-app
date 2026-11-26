@extends('layouts.app')

@section('content')
<div class="relative min-h-screen pb-10">
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-violet-primary opacity-10 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-blue-600 opacity-10 rounded-full blur-3xl -z-10"></div>

    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 relative z-10">
        <div>
            <a href="{{ route('projects.index') }}" class="text-gray-400 hover:text-white text-sm mb-2 block transition">← Retour aux projets</a>
            <h2 class="text-3xl font-bold">{{ $project->name }}</h2>
            <p class="text-gray-400 mt-1">Détails et gestion du projet.</p>
        </div>
        <a href="{{ route('kanban') }}" class="bg-violet-primary hover:bg-violet-600 text-white px-5 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30">
            Ouvrir le Kanban →
        </a>
    </div>

    <!-- Infos Projet -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 relative z-10">
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">Description</span>
            <p class="mt-2">{{ $project->description ?? 'Aucune description.' }}</p>
        </div>
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">Période</span>
            <p class="mt-2">Du {{ $project->start_date }} au {{ $project->end_date }}</p>
        </div>
        <div class="bg-gradient-to-br from-violet-900 to-dark-bg p-6 rounded-2xl border border-violet-700">
            <span class="text-violet-200 text-sm">Statut</span>
            <p class="mt-2 text-2xl font-bold">{{ $project->status }}</p>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10 relative z-10">
        <div class="bg-dark-card/80 p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">Tâches Totales</span>
            <p class="text-3xl font-bold mt-2">{{ $totalTasks }}</p>
        </div>
        <div class="bg-dark-card/80 p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">À faire</span>
            <p class="text-3xl font-bold mt-2 text-blue-400">{{ $todoTasks }}</p>
        </div>
        <div class="bg-dark-card/80 p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">En cours</span>
            <p class="text-3xl font-bold mt-2 text-yellow-400">{{ $inProgressTasks }}</p>
        </div>
        <div class="bg-dark-card/80 p-6 rounded-2xl border border-gray-800">
            <span class="text-gray-400 text-sm">Terminées</span>
            <p class="text-3xl font-bold mt-2 text-green-400">{{ $doneTasks }}</p>
        </div>
    </div>

    <!-- Graphique Doughnut -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10 mb-10">
        <div class="md:col-span-2 bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <h3 class="text-lg font-bold mb-6">Répartition des Tâches</h3>
            <div class="w-full h-72 flex justify-center">
                <canvas id="projectChart"></canvas>
            </div>
        </div>

        <!-- Progression Globale -->
        <div class="bg-gradient-to-br from-[#1E1B2E] to-[#0F172A] p-6 rounded-2xl border border-violet-500/20 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-violet-primary opacity-20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10">
                <h3 class="text-lg font-bold mb-4 text-white">Progression Globale</h3>
                <div class="text-5xl font-bold text-white mb-2">{{ $progress }}%</div>
                <p class="text-violet-200 mb-6 font-medium">Tâches terminées</p>
                
                <div class="w-full bg-gray-800/80 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-3 rounded-full transition-all duration-1000 ease-out" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestion des Membres -->
    <div class="mt-12 bg-dark-card/80 backdrop-blur-md p-8 rounded-2xl border border-gray-800 relative z-10">
        <livewire:team-manager :projectId="$project->id" />
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canvas = document.getElementById('projectChart');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['À faire', 'En cours', 'En révision', 'Terminées'],
                    datasets: [{
                        data: [{{ $todoTasks }}, {{ $inProgressTasks }}, {{ $reviewTasks }}, {{ $doneTasks }}],
                        backgroundColor: ['#3B82F6', '#EAB308', '#A855F7', '#22C55E'],
                        borderWidth: 0,
                        hoverOffset: 8,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        animateScale: true,
                        animateRotate: true,
                        duration: 1500
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#9CA3AF',
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    },
                    cutout: '75%'
                }
            });
        }
    });
</script>
@endpush
@endsection