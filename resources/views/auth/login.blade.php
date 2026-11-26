<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Bon retour </h2>
        <p class="text-gray-400">Connectez-vous pour gérer vos projets.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-gray-900 border-gray-700 text-violet-primary shadow-sm focus:ring-violet-primary" name="remember">
                <span class="ms-2 text-sm text-gray-400">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>
        <div class="flex items-center justify-between mt-6">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-400 hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-primary" href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
            <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-6 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30 font-semibold">
                Se connecter
            </button>
        </div>
        <div class="mt-6 text-center text-sm text-gray-400">
            Pas encore de compte ? 
            <a href="{{ route('register') }}" class="text-violet-primary hover:text-violet-300 font-semibold transition">S'inscrire</a>
        </div>
    </form>
</x-guest-layout>