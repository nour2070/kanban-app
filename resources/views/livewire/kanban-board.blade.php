<div>
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
        <div>
            <h2 class="text-3xl font-bold">Kanban Board 🚀</h2>
            <p class="text-gray-400 mt-1">Déplacez les tâches entre les colonnes.</p>
        </div>

        <div class="flex items-center gap-4 w-full md:w-auto">
            <div class="relative w-full md:w-56">
                <select wire:model.live="projectId" class="bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-2.5 focus:border-violet-primary focus:ring-violet-primary w-full transition-all cursor-pointer">
                    <option value="">Sélectionner un projet</option>
                    @foreach($projects as $project)
                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="relative w-full md:w-64">
                <input type="text" wire:model.live="search" placeholder="Rechercher une tâche..." class="bg-gray-900/50 border border-gray-700 text-white rounded-lg px-4 py-2.5 pl-10 focus:border-violet-primary focus:ring-violet-primary w-full transition-all">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            <button wire:click="$set('showModal', true)" class="bg-violet-primary hover:bg-violet-600 text-white px-5 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30 whitespace-nowrap flex items-center gap-2">
                <span>+</span> Ajouter une tâche
            </button>
        </div>
    </div>

    @if(!$projectId)
        <div class="bg-dark-card p-8 rounded-2xl border border-gray-800 text-center">
            <p class="text-gray-400 mb-4">Vous devez créer ou sélectionner un projet.</p>
            <a href="{{ route('projects.create') }}" class="text-violet-primary hover:text-violet-300 font-semibold">Créer un projet →</a>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6" wire:ignore>
            @foreach(['todo' => 'To Do', 'in-progress' => 'In Progress', 'review' => 'Review', 'done' => 'Done'] as $statusKey => $statusLabel)
                <div class="bg-dark-card/80 backdrop-blur-md p-4 rounded-2xl border border-gray-800 flex flex-col h-full">
                    <h3 class="text-lg font-bold mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full @if($statusKey == 'todo') bg-blue-500 @elseif($statusKey == 'in-progress') bg-yellow-500 @elseif($statusKey == 'review') bg-purple-500 @else bg-green-500 @endif"></span>
                            {{ $statusLabel }}
                        </div>
                        <span class="text-xs bg-gray-800/80 text-gray-300 px-2 py-1 rounded-md border border-gray-700">{{ $tasks->where('status', $statusKey)->count() }}</span>
                    </h3>

                    <div id="col-{{ $statusKey }}" data-status="{{ $statusKey }}" class="space-y-3 min-h-[200px] flex-1 sortable-zone" ondrop="drop(event, '{{ $statusKey }}')" ondragover="event.preventDefault()">
                        @foreach($tasks->where('status', $statusKey) as $task)
                            <div draggable="true" ondragstart="drag(event, '{{ $task->id }}')" data-id="{{ $task->id }}" class="task-item bg-dark-bg p-4 rounded-xl border border-gray-800 hover:border-violet-primary/50 cursor-grab active:cursor-grabbing transition-colors group relative">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-white text-sm group-hover:text-violet-primary transition-colors">{{ $task->title }}</h4>
                                    <span class="text-[10px] px-2 py-0.5 rounded-full font-semibold
                                        @if($task->priority == 'Urgente') bg-red-500/20 text-red-400
                                        @elseif($task->priority == 'Haute') bg-orange-500/20 text-orange-400
                                        @elseif($task->priority == 'Moyenne') bg-blue-500/20 text-blue-400
                                        @else bg-gray-500/20 text-gray-400 @endif">
                                        {{ $task->priority }}
                                    </span>
                                </div>

                                <p class="text-xs text-gray-400 mb-3 line-clamp-2">{{ $task->description ?? 'Pas de description.' }}</p>

                                <!-- Attachment Display -->
                                @if($task->attachment)
                                    <div class="mb-2">
                                        <a href="{{ Storage::url($task->attachment) }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-violet-primary hover:text-violet-300 transition">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                            Pièce jointe
                                        </a>
                                    </div>
                                @endif

                                <div class="flex justify-between items-center mt-auto pt-3 border-t border-gray-800/50">
                                    <div class="flex items-center gap-1 text-xs text-gray-500">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $task->deadline ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') : 'N/A' }}
                                    </div>
                                    <button wire:click="openTaskModal({{ $task->id }})" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-0"></button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Modal Ajouter Tâche -->
    @if($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-dark-card p-6 rounded-2xl border border-gray-800 w-full max-w-md shadow-2xl relative">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold">Ajouter une tâche</h3>
                    <button wire:click="$set('showModal', false)" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form wire:submit.prevent="addTask">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Titre</label>
                        <input type="text" wire:model="title" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary" placeholder="Ex: Développer la page Login">
                        @error('title') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                        <textarea wire:model="description" rows="3" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary" placeholder="Détails de la tâche..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Priorité</label>
                            <select wire:model="priority" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary">
                                <option value="Basse">Basse</option>
                                <option value="Moyenne">Moyenne</option>
                                <option value="Haute">Haute</option>
                                <option value="Urgente">Urgente</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Deadline</label>
                            <input type="date" wire:model="deadline" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Assigner à</label>
                        <select wire:model="assignedTo" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary">
                            <option value="">Moi-même (Chef de projet)</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                            @endforeach
                        </select>
                        @error('assignedTo') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- NOUVEAU : Champ d'upload de fichier -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Pièce jointe (Optionnel)</label>
                        <input type="file" wire:model="attachment" class="w-full bg-gray-900/50 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-violet-primary focus:ring-violet-primary file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-primary/10 file:text-violet-primary hover:file:bg-violet-primary/20">
                        @error('attachment') <span class="text-red-400 text-sm mt-1 block">{{ $message }}</span> @enderror
                        <div wire:loading wire:target="attachment" class="text-violet-primary text-sm mt-2">Téléchargement en cours...</div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-800">
                        <button type="button" wire:click="$set('showModal', false)" class="px-5 py-2.5 text-gray-400 hover:text-white transition">Annuler</button>
                        <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-6 py-2.5 rounded-lg transition shadow-lg shadow-violet-primary/30 font-medium">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- Modal Tâche (Commentaires) -->
    @if($selectedTask)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-dark-card p-6 rounded-2xl border border-gray-800 w-full max-w-lg shadow-2xl relative">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-bold">{{ $selectedTask->title }}</h3>
                    <button wire:click="closeTaskModal" class="text-gray-400 hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <p class="text-gray-400 text-sm mb-4">{{ $selectedTask->description ?? 'Pas de description.' }}</p>
                
                <!-- Attachment Display in Modal -->
                @if($selectedTask->attachment)
                    <div class="mb-4">
                        <a href="{{ Storage::url($selectedTask->attachment) }}" target="_blank" class="inline-flex items-center gap-2 text-sm text-violet-primary hover:text-violet-300 transition bg-violet-primary/10 px-3 py-2 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                            Voir la pièce jointe
                        </a>
                    </div>
                @endif

                <div class="mt-6 border-t border-gray-800 pt-4">
                    <h4 class="text-lg font-bold mb-4">Commentaires ({{ $selectedTask->comments->count() }})</h4>
                    <div class="space-y-3 mb-4 max-h-60 overflow-y-auto pr-2">
                        @forelse($selectedTask->comments as $comment)
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
                    <form wire:submit.prevent="addComment" class="flex gap-2">
                        <input type="text" wire:model="newComment" placeholder="Écrire un commentaire..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2 text-white text-sm">
                        <button type="submit" class="bg-violet-primary hover:bg-violet-600 text-white px-4 py-2 rounded-lg text-sm transition">Envoyer</button>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function drag(event, taskId) {
        event.dataTransfer.setData("text/plain", taskId);
    }

    function drop(event, newStatus) {
        event.preventDefault();
        const taskId = event.dataTransfer.getData("text/plain");
        if (taskId) {
            Livewire.dispatch('updateTaskStatus', { taskId: taskId, newStatus: newStatus });
        }
    }
</script>