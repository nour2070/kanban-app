<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'KanbanFlow') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-white antialiased bg-dark-bg">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
            <!-- Background Decor -->
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-violet-primary opacity-20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600 opacity-20 rounded-full blur-3xl"></div>

            <div class="relative z-10 mb-6">
                <a href="/">
                    <h1 class="text-4xl font-bold text-white">Kanban<span class="text-violet-primary">Flow</span></h1>
                </a>
            </div>

            <div class="relative z-10 w-full sm:max-w-md mt-6 px-8 py-10 bg-dark-card shadow-2xl overflow-hidden sm:rounded-2xl border border-gray-800">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>