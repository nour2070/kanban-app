@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h2 class="text-3xl font-bold">Mon Profil 👤</h2>
        <p class="text-gray-400 mt-1">Gérez vos informations personnelles.</p>
    </div>

    <div class="bg-dark-card p-8 rounded-2xl border border-gray-800 mb-8">
        @include('profile.partials.update-profile-information-form')
    </div>

    <div class="bg-dark-card p-8 rounded-2xl border border-gray-800 mb-8">
        @include('profile.partials.update-password-form')
    </div>

    <div class="bg-red-900/20 p-8 rounded-2xl border border-red-900/50">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection