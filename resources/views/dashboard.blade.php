@extends('layouts.app')

@section('content')
<div class="relative min-h-screen pb-10">
    <!-- Background Decor -->
    <div class="fixed top-0 right-0 w-[600px] h-[600px] bg-violet-primary opacity-[0.07] rounded-full blur-[150px] -z-10 pointer-events-none"></div>
    <div class="fixed bottom-0 left-1/4 w-[600px] h-[600px] bg-blue-600 opacity-[0.07] rounded-full blur-[150px] -z-10 pointer-events-none"></div>

    <!-- Header -->
    <div class="mb-10 flex justify-between items-end relative z-10">
        <div>
            <h2 class="text-4xl font-bold tracking-tight">Bonjour, {{ Auth::user()->name }} <span class="inline-block animate-wave origin-bottom-right">👋</span></h2>
            <p class="text-gray-400 mt-2 text-lg">Voici l'état de vos projets aujourd'hui.</p>
        </div>
        <a href="{{ route('projects.create') }}" class="bg-violet-primary hover:bg-violet-500 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-[0_0_20px_rgba(124,58,237,0.3)] hover:shadow-[0_0_30px_rgba(124,58,237,0.6)] hover:-translate-y-1 flex items-center gap-2 font-medium">
            <span>+</span> Nouveau Projet
        </a>
    </div>

    <!-- Les Cartes Statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 relative z-10">
        
        <!-- Projets Totaux -->
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800 hover:border-violet-500/50 transition-all duration-300 group hover:shadow-[0_0_30px_rgba(124,58,237,0.1)] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-violet-500/10 rounded-lg text-violet-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm font-medium mb-1">Projets Totaux</p>
                <h3 class="text-4xl font-bold">{{ $totalProjects }}</h3>
            </div>
        </div>

        <!-- Tâches Totales -->
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800 hover:border-blue-500/50 transition-all duration-300 group hover:shadow-[0_0_30px_rgba(59,130,246,0.1)] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-blue-500/10 rounded-lg text-blue-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm font-medium mb-1">Tâches Totales</p>
                <h3 class="text-4xl font-bold">{{ $totalTasks }}</h3>
            </div>
        </div>

        <!-- Tâches Terminées -->
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800 hover:border-green-500/50 transition-all duration-300 group hover:shadow-[0_0_30px_rgba(34,197,94,0.1)] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-green-500/10 rounded-lg text-green-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm font-medium mb-1">Tâches Terminées</p>
                <h3 class="text-4xl font-bold">{{ $tasksDone }}</h3>
            </div>
        </div>

        <!-- Tâches en Retard -->
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800 hover:border-red-500/50 transition-all duration-300 group hover:shadow-[0_0_30px_rgba(239,68,68,0.1)] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-red-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="flex justify-between items-start mb-4 relative z-10">
                <div class="p-2.5 bg-red-500/10 rounded-lg text-red-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="relative z-10">
                <p class="text-gray-400 text-sm font-medium mb-1">Tâches en Retard</p>
                <h3 class="text-4xl font-bold text-red-400">{{ $tasksLate }}</h3>
            </div>
        </div>

    </div>

    <!-- Graphiques (Doughnut + Line + Pie) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 relative z-10 mb-8">
        
        <!-- Doughnut Chart -->
        <div class="lg:col-span-1 bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <h3 class="text-lg font-bold text-white mb-4">Répartition des Tâches</h3>
            <div class="w-full h-[250px] flex justify-center items-center">
                @if($totalTasks > 0)
                    <canvas id="statusChart"></canvas>
                @else
                    <div class="text-center text-gray-500">
                        <p>Créez des tâches pour voir le graphique.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Line Chart -->
        <div class="lg:col-span-2 bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <h3 class="text-lg font-bold text-white mb-4">Tâches terminées (7 derniers jours)</h3>
            <div class="w-full h-[250px]">
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Pie Chart + Progression Globale -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 relative z-10 mb-8">
        <!-- Pie Chart -->
        <div class="bg-dark-card/80 backdrop-blur-md p-6 rounded-2xl border border-gray-800">
            <h3 class="text-lg font-bold text-white mb-4">Répartition par Membre</h3>
            <div class="w-full h-[250px] flex justify-center items-center">
                @if(count($pieChartCounts) > 0)
                    <canvas id="pieChart"></canvas>
                @else
                    <div class="text-center text-gray-500">
                        <p>Assignez des tâches aux membres pour voir le graphique.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Progression Globale -->
        <div class="bg-gradient-to-br from-[#1E1B2E] to-[#0F172A] p-6 rounded-2xl border border-violet-500/20 relative overflow-hidden group">
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-violet-primary opacity-20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <div class="relative z-10 h-full flex flex-col justify-center">
                <h3 class="text-lg font-bold mb-6 text-white">Progression Globale</h3>
                <div class="flex items-baseline gap-2 mb-2">
                    <div class="text-6xl font-bold text-white tracking-tighter">{{ $progress }}%</div>
                </div>
                <p class="text-violet-300 mb-8 font-medium">Tâches terminées</p>
                
                <div class="w-full bg-gray-800/80 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-violet-500 to-fuchsia-500 h-3 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(124,58,237,0.5)]" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projets Récents -->
    <div class="mt-8 relative z-10">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Projets Récents</h3>
            <a href="{{ route('projects.index') }}" class="text-sm text-violet-primary hover:text-violet-300 transition-colors">Voir tout →</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($recentProjects as $project)
                <a href="{{ route('projects.show', $project) }}" class="bg-dark-card/80 backdrop-blur-md p-5 rounded-xl border border-gray-800 hover:border-violet-500/50 transition-all duration-300 flex items-center gap-4 group hover:shadow-[0_0_20px_rgba(124,58,237,0.15)] hover:-translate-y-1">
                    <div class="w-3 h-12 rounded-full group-hover:scale-y-110 transition-transform" style="background-color: {{ $project->color }}"></div>
                    <div>
                        <h4 class="font-bold text-white group-hover:text-violet-primary transition-colors">{{ $project->name }}</h4>
                        <p class="text-sm text-gray-400 mt-1">{{ $project->tasks()->count() }} tâches</p>
                    </div>
                </a>
            @empty
                <div class="col-span-3 bg-dark-card/50 border border-gray-800 border-dashed rounded-xl p-8 text-center">
                    <p class="text-gray-500">Aucun projet récent pour le moment.</p>
                </div>
            @endforelse
        </div>
    </div>


    @if(isset($recentActivities) && $recentActivities->count() > 0)
    <div class="mt-8 relative z-10">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-white">Activités Récentes</h3>
        </div>
        <div class="bg-dark-card/80 backdrop-blur-md rounded-2xl border border-gray-800 overflow-hidden">
            @foreach($recentActivities as $activity)
                <div class="flex items-center gap-4 p-4 border-b border-gray-800/50 hover:bg-white/5 transition">
                    <div class="w-10 h-10 rounded-full bg-violet-primary/20 text-violet-primary flex items-center justify-center font-bold">
                        {{ strtoupper(substr($activity->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm text-gray-300">
                            <span class="font-bold text-white">{{ $activity->user->name ?? 'Utilisateur' }}</span> 
                            {{ $activity->description }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Doughnut Chart
        const statusCanvas = document.getElementById('statusChart');
        if (statusCanvas) {
            new Chart(statusCanvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['À faire', 'En cours', 'En révision', 'Terminées'],
                    datasets: [{
                        data: [{{ $chartData['todo'] }}, {{ $chartData['in-progress'] }}, {{ $chartData['review'] }}, {{ $chartData['done'] }}],
                        backgroundColor: ['#3B82F6', '#EAB308', '#A855F7', '#22C55E'],
                        borderWidth: 0,
                        hoverOffset: 10,
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: { legend: { position: 'bottom', labels: { color: '#9CA3AF', padding: 15, usePointStyle: true, pointStyle: 'circle' } } }
                }
            });
        }

        // 2. Line Chart
        const lineCanvas = document.getElementById('lineChart');
        if (lineCanvas) {
            new Chart(lineCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: @json($lineChartLabels),
                    datasets: [{
                        label: 'Tâches terminées',
                        data: @json($lineChartData),
                        borderColor: '#7C3AED',
                        backgroundColor: 'rgba(124, 58, 237, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#7C3AED',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, ticks: { color: '#9CA3AF', stepSize: 1 }, grid: { color: 'rgba(255,255,255,0.05)' } },
                        x: { ticks: { color: '#9CA3AF' }, grid: { display: false } }
                    }
                }
            });
        }

        // 3. Pie Chart
        const pieCanvas = document.getElementById('pieChart');
        if (pieCanvas) {
            new Chart(pieCanvas.getContext('2d'), {
                type: 'pie',
                data: {
                    labels: @json($pieChartLabels),
                    datasets: [{
                        data: @json($pieChartCounts),
                        backgroundColor: ['#7C3AED', '#3B82F6', '#22C55E', '#EAB308', '#EF4444', '#EC4899'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: { legend: { position: 'bottom', labels: { color: '#9CA3AF', padding: 15, usePointStyle: true, pointStyle: 'circle' } } }
                }
            });
        }
    });
</script>
@endpush
@endsection