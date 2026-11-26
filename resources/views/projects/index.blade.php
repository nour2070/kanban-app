@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h2 class="text-3xl font-bold">Mes Projets 📁</h2>
        <p class="text-gray-400 mt-1">Gérez vos projets et suivez leur avancement.</p>
    </div>
    <a href="{{ route('projects.create') }}" class="bg-violet-primary hover:bg-violet-600 text-white px-5 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30">
        + Nouveau Projet
    </a>
</div>

@if(session('success'))
    <div class="bg-green-900/50 border border-green-500 text-green-300 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($projects as $project)
        <div class="bg-dark-card p-6 rounded-2xl border border-gray-800 hover:border-violet-primary transition relative overflow-hidden group">
            <div class="absolute top-0 left-0 w-full h-1.5" style="background-color: {{ $project->color }}"></div>
            <h3 class="text-xl font-bold mb-2 mt-2">{{ $project->name }}</h3>
            <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $project->description ?? 'Pas de description' }}</p>
            <div class="flex justify-between items-center text-xs text-gray-500 mb-4">
                <span>📅 {{ $project->start_date }}</span>
                <span>🏁 {{ $project->end_date }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="px-2 py-1 rounded-full text-xs font-semibold bg-violet-900/50 text-violet-300">{{ $project->status }}</span>
                <a href="{{ route('projects.show', $project) }}" class="text-violet-primary hover:text-violet-300 font-semibold text-sm transition">Voir détails →</a>
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-20 bg-dark-card rounded-2xl border border-gray-800">
            <p class="text-gray-400 text-lg">Vous n'avez pas encore de projets.</p>
        </div>
    @endforelse
</div>
@endsection