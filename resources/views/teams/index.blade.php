@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Mes Équipes 👥</h2>
    <p class="text-gray-400 mt-1">Gérez les membres de vos équipes.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($teams as $team)
        <div class="bg-dark-card p-6 rounded-2xl border border-gray-800 hover:border-violet-primary transition">
            <h3 class="text-xl font-bold mb-2">{{ $team->name }}</h3>
            <p class="text-xs text-gray-500 mb-4">Projet: {{ $team->project->name }}</p>
            <div class="space-y-3">
                @foreach($team->users as $user)
                    <div class="flex items-center gap-3 bg-gray-900/50 p-2 rounded-lg">
                        <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ $user->name }}" class="w-8 h-8 rounded-full bg-gray-700">
                        <span class="text-sm">{{ $user->name }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <div class="col-span-3 text-center py-20 bg-dark-card rounded-2xl border border-gray-800">
            <p class="text-gray-400">Aucune équipe trouvée.</p>
        </div>
    @endforelse
</div>
@endsection