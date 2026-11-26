
<div
    wire:click="openTaskModal({{ $task->id }})"
    class="bg-dark-bg p-4 rounded-xl border
    @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done')
        border-red-500/50 shadow-[0_0_10px_rgba(239,68,68,0.2)]
    @else
        border-gray-700
    @endif
    cursor-pointer hover:border-violet-primary transition shadow-sm"
    data-id="{{ $task->id }}"
>
    {{-- Titre et priorité --}}
    <div class="flex justify-between items-start mb-2">

        <h4 class="font-medium text-white text-sm">
            {{ $task->title }}
        </h4>

        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full text-white
            @if($task->priority == 'Urgente')
                bg-red-500
            @elseif($task->priority == 'Haute')
                bg-orange-500
            @elseif($task->priority == 'Moyenne')
                bg-yellow-500
            @else
                bg-green-500
            @endif
        ">
            {{ $task->priority }}
        </span>

    </div>

    {{-- Description --}}
    @if($task->description)
        <p class="text-xs text-gray-400 mt-2 line-clamp-2">
            {{ $task->description }}
        </p>
    @endif

    {{-- Date limite et membre assigné --}}
    <div class="flex justify-between items-center mt-4">

        <div class="flex items-center gap-2 text-xs
            @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done')
                text-red-400 font-bold
            @else
                text-gray-400
            @endif
        ">

            @if($task->deadline && \Carbon\Carbon::parse($task->deadline)->isPast() && $task->status !== 'done')

                <span>
                    ⚠️ Retard :
                    {{ \Carbon\Carbon::parse($task->deadline)->format('d/m/Y') }}
                </span>

            @else

                <span>
                    📅
                    {{ $task->deadline
                        ? \Carbon\Carbon::parse($task->deadline)->format('d/m/Y')
                        : 'Pas de date'
                    }}
                </span>

            @endif

        </div>

        {{-- Avatar du membre --}}
        @if($task->user)

            <img
                src="https://api.dicebear.com/7.x/adventurer/svg?seed={{ urlencode($task->user->name) }}"
                title="{{ $task->user->name }}"
                alt="Avatar"
                class="w-6 h-6 rounded-full bg-gray-700"
            >

        @else

            <div class="w-6 h-6 rounded-full bg-gray-700 flex items-center justify-center text-xs text-white">
                ?
            </div>

        @endif

    </div>

    {{-- Indication pour ouvrir les détails --}}
    <div class="mt-3 pt-2 border-t border-gray-700/50 text-[10px] text-gray-500">
        Cliquer pour voir les détails et les commentaires
    </div>

</div>
