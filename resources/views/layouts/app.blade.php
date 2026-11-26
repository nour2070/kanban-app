<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KanbanFlow') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-dark-bg text-white font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex relative">
        
        <!-- Overlay for mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 md:hidden" x-transition.opacity></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-dark-card border-r border-gray-800 flex-shrink-0 transform transition-transform duration-300 md:translate-x-0 overflow-y-auto custom-scrollbar flex flex-col">
            
            <!-- Logo -->
            <div class="flex justify-between items-center p-6 pb-4">
                <a href="{{ route('dashboard') }}" class="text-2xl font-bold text-violet-primary tracking-tight">
                    Kanban<span class="text-white">Flow</span>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-gray-400 hover:text-white transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 px-4 space-y-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('dashboard') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <!-- Kanban Board -->
                <a href="{{ route('kanban') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('kanban') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('kanban') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2"></path>
                    </svg>
                    <span class="font-medium text-sm">Kanban Board</span>
                </a>

                <!-- Projets -->
                <a href="{{ route('projects.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('projects.*') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('projects.*') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                    </svg>
                    <span class="font-medium text-sm">Projets</span>
                </a>

                <!-- Équipes -->
                <a href="{{ route('teams.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teams.*') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('teams.*') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    <span class="font-medium text-sm">Équipes</span>
                </a>

                <!-- Notifications -->
                <a href="{{ route('notifications.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('notifications.*') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <div class="relative">
                        <svg class="w-5 h-5 {{ request()->routeIs('notifications.*') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @php
                            $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
                        @endphp
                        @if($unreadCount > 0)
                            <span class="absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold shadow-lg shadow-red-500/50">{{ $unreadCount }}</span>
                        @endif
                    </div>
                    <span class="font-medium text-sm">Notifications</span>
                </a>

                <!-- Admin -->
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.*') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.*') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span class="font-medium text-sm">Administration</span>
                    </a>
                @endif
            </nav>

            <!-- Profile & Logout (Bottom) -->
            <div class="p-4 border-t border-gray-800 mt-auto">
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('profile.*') ? 'bg-violet-primary/10 text-violet-primary' : 'text-gray-400 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('profile.*') ? 'text-violet-primary' : 'group-hover:text-violet-primary' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="font-medium text-sm">Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-1">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-red-400 hover:text-red-300 hover:bg-red-500/10 transition-all duration-200 group">
                        <svg class="w-5 h-5 group-hover:text-red-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <span class="font-medium text-sm">Déconnexion</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col min-h-screen w-full">
            <!-- Navbar for Mobile -->
            <div class="md:hidden flex items-center justify-between bg-dark-card/80 backdrop-blur-md p-4 border-b border-gray-800 sticky top-0 z-30">
                <h1 class="text-xl font-bold text-violet-primary">Kanban<span class="text-white">Flow</span></h1>
                <button @click="sidebarOpen = true" class="text-gray-400 hover:text-white p-2 rounded-lg bg-gray-800/50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>

            <!-- Page Content -->
            <div class="p-4 md:p-8 overflow-y-auto w-full max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
    
    <livewire:chat-bot /> 
  
    <!-- Livewire Scripts -->
    @livewireScripts

    <!-- Stack Scripts -->
    @stack('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @auth
            window.Echo.private('user.{{ auth()->id() }}')
                .listen('TaskAssigned', (e) => {
                    console.log('🔔 Nouvelle notification!', e);
                    // نزيدو كود باش نحدثو الـ Badge
                    const badge = document.querySelector('.notification-badge');
                    if (badge) {
                        let count = parseInt(badge.innerText) || 0;
                        badge.innerText = count + 1;
                    }
                });
        @endauth
    });
</script>

</body>
</html>