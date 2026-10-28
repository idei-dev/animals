<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            <div class="py-6">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    @if (session('success'))
                        <div class="mb-6 flex items-center justify-between rounded-lg border border-emerald-500/40 bg-emerald-50 dark:bg-emerald-500/10 p-4 text-emerald-800 dark:text-emerald-200 shadow-sm" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('[role=alert]').remove()" class="ml-4 text-lg font-bold text-emerald-600 dark:text-emerald-400 hover:opacity-75" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-6 flex items-center justify-between rounded-lg border border-rose-500/40 bg-rose-50 dark:bg-rose-500/10 p-4 text-rose-800 dark:text-rose-200 shadow-sm" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-rose-600 dark:text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('[role=alert]').remove()" class="ml-4 text-lg font-bold text-rose-600 dark:text-rose-400 hover:opacity-75" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="mb-6 flex items-center justify-between rounded-lg border border-amber-500/40 bg-amber-50 dark:bg-amber-500/10 p-4 text-amber-800 dark:text-amber-200 shadow-sm" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('warning') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('[role=alert]').remove()" class="ml-4 text-lg font-bold text-amber-600 dark:text-amber-400 hover:opacity-75" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900 dark:text-gray-100">
                            {{ $slot }}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>