<div class="mt-6 border-t border-gray-800 pt-4">
    <h4 class="text-lg font-bold mb-4">Commentaires ({{ count($comments) }})</h4>
    
    <!-- Liste des commentaires -->
    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto pr-2">
        @forelse($comments as $comment)
            <div class="bg-dark-bg p-3 rounded-lg border border-gray-800">
                <div class="flex justify-between items-center mb-1">
                    <span class="font-bold text-sm text-violet-400">{{ $comment->user->name }}</span>
                    <span class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-sm text-gray-300">{{ $comment->content }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-500">Aucun commentaire pour le moment.</p>
        @endforelse
    </div>

    <!-- Formulaire d'ajout -->
    <form wire:submit.prevent="addComment" class="flex gap-2">
        <input type="text" wire:model="content" placeholder="Écrire un commentaire..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white text-sm">
        <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-4 py-2 rounded-lg text-sm transition">Envoyer</button>
    </form>
    <button wire:click="$dispatch('openTaskModal', { taskId: {{ $task->id }} })" class="text-xs text-violet-400 mt-2 hover:text-violet-300">💬 Commentaires</button>
</div>