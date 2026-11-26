@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold">Créer un Projet 🚀</h2>
        <p class="text-gray-400 mt-1">Remplissez les informations ci-dessous pour lancer votre nouveau projet.</p>
    </div>

    <form action="{{ route('projects.store') }}" method="POST" class="bg-dark-card p-8 rounded-2xl border border-gray-800 shadow-2xl">
        @csrf
        
        <!-- Nom -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Nom du projet <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-violet-primary focus:ring-violet-primary transition" required placeholder="Ex: Site Web E-commerce">
            @error('name') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
        </div>

        <!-- Description -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="3" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-violet-primary focus:ring-violet-primary transition" placeholder="Décrivez votre projet...">{{ old('description') }}</textarea>
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Date de début <span class="text-red-500">*</span></label>
                <input type="date" name="start_date" value="{{ old('start_date') }}" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-violet-primary focus:ring-violet-primary transition" required>
                @error('start_date') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-300 mb-2">Date de fin <span class="text-red-500">*</span></label>
                <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full bg-gray-900 border border-gray-700 text-white rounded-lg px-4 py-3 focus:border-violet-primary focus:ring-violet-primary transition" required>
                @error('end_date') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
            </div>
        </div>

        <!-- Couleur -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-300 mb-2">Couleur du projet</label>
            <div class="flex items-center gap-4">
                <input type="color" name="color" value="{{ old('color', '#7C3AED') }}" class="w-16 h-12 bg-gray-900 border border-gray-700 rounded-lg cursor-pointer p-1">
                <span class="text-sm text-gray-500">Choisissez une couleur pour identifier votre projet.</span>
            </div>
        </div>

        <!-- Membres (NOUVEAU) -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-300 mb-2">Membres de l'équipe</label>
            <div class="bg-gray-900 border border-gray-700 rounded-lg p-4 max-h-48 overflow-y-auto">
                @php
                    $allUsers = \App\Models\User::where('id', '!=', auth()->id())->get();
                @endphp
                @forelse($allUsers as $user)
                    <label class="flex items-center gap-3 p-2 hover:bg-gray-800 rounded cursor-pointer transition">
                        <input type="checkbox" name="members[]" value="{{ $user->id }}" class="w-4 h-4 text-violet-primary bg-gray-800 border-gray-600 rounded focus:ring-violet-primary">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-violet-primary/20 text-violet-primary flex items-center justify-center font-bold text-xs">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <span class="text-gray-300 text-sm">{{ $user->name }} ({{ $user->email }})</span>
                        </div>
                    </label>
                @empty
                    <p class="text-sm text-gray-500 text-center py-2">Aucun autre utilisateur disponible.</p>
                @endforelse
            </div>
            <p class="text-xs text-gray-500 mt-2">Sélectionnez les membres qui participeront à ce projet.</p>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end gap-4 border-t border-gray-800 pt-6">
            <a href="{{ route('projects.index') }}" class="px-6 py-3 rounded-lg text-gray-400 hover:text-white transition">Annuler</a>
            <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-8 py-3 rounded-lg transition shadow-lg shadow-violet-primary/30 font-semibold flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Créer le projet
            </button>
        </div>
    </form>
</div>
@endsection