<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-2">Créer un compte </h2>
        <p class="text-gray-400">Rejoignez KanbanFlow et gérez vos projets.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Nom complet')" class="text-gray-300" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" class="text-gray-300" />
            <x-text-input id="email" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Mot de passe')" class="text-gray-300" />
            <x-text-input id="password" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-gray-300" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-900 border-gray-700 text-white focus:border-violet-primary focus:ring-violet-primary rounded-lg"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
        </div>

        <!-- Bouton w Lien Login -->
        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-gray-400 hover:text-white transition underline decoration-gray-600 hover:decoration-white" href="{{ route('login') }}">
                Déjà inscrit ?
            </a>

            <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-6 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30 font-semibold">
                S'inscrire
            </button>
        </div>
    </form>
</x-guest-layout>