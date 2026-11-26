@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold">Notifications 🔔</h2>
        <p class="text-gray-400 mt-1">Vos dernières alertes et activités.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-4 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-dark-card rounded-2xl border border-gray-800 overflow-hidden">
        @forelse($notifications as $notification)
            <div class="flex items-start gap-4 p-4 border-b border-gray-800/50 hover:bg-white/5 transition {{ $notification->is_read ? 'opacity-60' : 'bg-violet-primary/5' }}">
                
                <!-- Icon -->
                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $notification->is_read ? 'bg-gray-800 text-gray-400' : 'bg-violet-primary/20 text-violet-primary' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Content -->
                <div class="flex-1">
                    <p class="text-gray-200">{{ $notification->message }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                </div>

                <!-- Delete Button -->
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('Supprimer cette notification ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-500 hover:text-red-400 transition p-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </form>
            </div>
        @empty
            <div class="p-12 text-center text-gray-500">
                <p class="text-lg mb-2">Aucune notification</p>
                <p class="text-sm">Vous êtes à jour !</p>
            </div>
        @endforelse
    </div>
</div>
@endsection