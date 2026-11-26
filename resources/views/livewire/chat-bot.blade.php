<div class="fixed bottom-6 right-6 z-50">
    <div x-data="{ open: false }" class="relative">
        <!-- Bouton Chat -->
        <button @click="open = !open" class="bg-violet-primary hover:bg-violet-600 text-white w-16 h-16 rounded-full shadow-[0_0_20px_rgba(124,58,237,0.4)] flex items-center justify-center transition-all duration-300 hover:scale-110">
            <svg x-show="!open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
            <svg x-show="open" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Fenêtre Chat -->
        <div x-show="open" x-transition class="absolute bottom-24 right-0 w-[380px] bg-dark-card rounded-2xl border border-gray-800 shadow-2xl overflow-hidden flex flex-col">
            <!-- Header -->
            <div class="bg-gradient-to-r from-violet-600 to-violet-800 p-4">
                <h3 class="text-white font-bold text-lg">Support Chat 💬</h3>
                <p class="text-violet-200 text-sm">Nous sommes là pour vous aider.</p>
            </div>

            <!-- Messages (Scrollable) -->
            <div class="h-80 overflow-y-auto p-4 space-y-4 flex flex-col">
                @forelse($messages as $msg)
<div wire:key="msg-{{ $msg->id }}" class="flex {{ $msg->is_from_admin ? 'justify-start' : 'justify-end' }}">                        <div class="max-w-[85%] p-3.5 rounded-2xl text-sm leading-relaxed {{ $msg->is_from_admin ? 'bg-gray-800 text-gray-200 rounded-bl-none' : 'bg-violet-primary text-white rounded-br-none shadow-lg shadow-violet-primary/20' }}">
                            {{ $msg->message }}
                        </div>
                    </div>
                @empty
                    <div class="text-center mt-10">
                        <p class="text-gray-400 text-sm mb-4">Bonjour ! Comment puis-je vous aider aujourd'hui ?</p>
                    </div>
                @endforelse
            </div>

            <!-- Suggestions (Dima ybanou) -->
            <div class="px-4 pb-3 flex flex-wrap gap-2">
                <button wire:click="sendSuggestion('Comment créer un projet ?')" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full border border-gray-700 transition">Créer un projet</button>
                <button wire:click="sendSuggestion('Comment ajouter une tâche ?')" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full border border-gray-700 transition">Ajouter une tâche</button>
                <button wire:click="sendSuggestion('Comment inviter un membre ?')" class="bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs px-3 py-1.5 rounded-full border border-gray-700 transition">Inviter un membre</button>
            </div>

            <!-- Formulaire -->
            <form wire:submit.prevent="sendMessage" class="p-4 border-t border-gray-800 flex gap-2 bg-dark-card">
                <input type="text" wire:model="message" placeholder="Écrivez votre message..." class="flex-1 bg-gray-900 border border-gray-700 rounded-xl px-4 py-3 text-white text-sm focus:border-violet-primary focus:ring-violet-primary transition">
                <button type="submit" class="bg-violet-primary text-white p-3 rounded-xl hover:bg-violet-600 transition shadow-lg shadow-violet-primary/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                </button>
            </form>
        </div>
    </div>
</div>