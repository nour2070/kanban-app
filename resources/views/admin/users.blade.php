@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold">Gestion des Utilisateurs ⚙️</h2>
    <p class="text-gray-400 mt-1">Gérez les rôles des utilisateurs de la plateforme.</p>
</div>

@if(session('success'))
    <div class="bg-green-900/50 border border-green-500 text-green-300 p-4 rounded-lg mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-dark-card rounded-2xl border border-gray-800 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-gray-900/50 text-gray-400 text-sm">
            <tr>
                <th class="p-4">Nom</th>
                <th class="p-4">Email</th>
                <th class="p-4">Rôle</th>
                <th class="p-4">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-t border-gray-800 hover:bg-gray-800/20 transition">
                    <td class="p-4 font-medium">{{ $user->name }}</td>
                    <td class="p-4 text-gray-400">{{ $user->email }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-violet-900/50 text-violet-300' : 'bg-gray-800 text-gray-400' }}">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="p-4">
                        <form action="{{ route('admin.updateRole', $user) }}" method="POST" class="flex gap-2">
                            @csrf
                            <select name="role" class="bg-gray-900 border border-gray-700 rounded-lg px-3 py-1.5 text-sm text-white focus:border-violet-primary focus:ring-violet-primary">
                                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-4 py-1.5 rounded-lg text-sm transition">
                                Mettre à jour
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection