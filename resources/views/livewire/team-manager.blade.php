<div>
    <div class="flex justify-between items-center mb-6">
        <h3 class="text-2xl font-bold">Équipe du Projet</h3>
        <button wire:click="$set('showModal', true)" class="bg-violet-primary hover:bg-violet-600 text-white px-4 py-2 rounded-lg transition">
            + Inviter un membre
        </button>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Chef de projet -->
        <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700 flex items-center gap-4">
            <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ $project->user->name }}" class="w-10 h-10 rounded-full">
            <div>
                <p class="font-bold">{{ $project->user->name }}</p>
                <p class="text-xs text-violet-400">Chef de projet</p>
            </div>
        </div>
        
        <!-- Membres -->
        @foreach($project->teams as $team)
            @foreach($team->users as $member)
                <div class="bg-gray-900/50 p-4 rounded-xl border border-gray-700 flex items-center gap-4">
                    <img src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ $member->name }}" class="w-10 h-10 rounded-full">
                    <div>
                        <p class="font-bold">{{ $member->name }}</p>
                        <p class="text-xs text-gray-400">{{ $team->name }}</p>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>

    <!-- Modal Inviter -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
            <div class="bg-dark-card p-6 rounded-2xl border border-gray-800 w-full max-w-md">
                <h3 class="text-xl font-bold mb-4">Inviter un membre</h3>
                <form wire:submit.prevent="inviteMember">
                    <div class="mb-4">
                        <label class="block text-sm text-gray-300 mb-2">Email du membre</label>
                        <input type="email" wire:model="email" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white" placeholder="membre@email.com">
                        @error('email') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm text-gray-300 mb-2">Nom de l'équipe</label>
                        <input type="text" wire:model="teamName" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-white" placeholder="Ex: Design Team">
                        @error('teamName') <span class="text-red-400 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="$set('showModal', false)" class="px-4 py-2 text-gray-400 hover:text-white">Annuler</button>
                        <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-4 py-2 rounded-lg">Inviter</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>