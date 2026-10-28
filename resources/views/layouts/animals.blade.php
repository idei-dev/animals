<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Animales') | {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-slate-900 font-sans text-slate-800 dark:text-slate-100 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="border-b border-slate-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight text-slate-900 dark:text-white transition hover:text-indigo-600 dark:hover:text-sky-300">
                        {{ config('app.name', 'Registro') }}
                    </a>

                    <div class="flex items-center gap-3">
                        <div x-data="{
                            darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                            toggle() {
                                this.darkMode = !this.darkMode;
                                if (this.darkMode) {
                                    document.documentElement.classList.add('dark');
                                    localStorage.setItem('theme', 'dark');
                                } else {
                                    document.documentElement.classList.remove('dark');
                                    localStorage.setItem('theme', 'light');
                                }
                            }
                        }">
                            <button @click="toggle()" type="button" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-800 rounded-lg text-sm transition-colors" title="Cambiar tema">
                                <svg x-show="darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd" />
                                </svg>
                                <svg x-show="!darkMode" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                                </svg>
                            </button>
                        </div>
                        @yield('header-actions')
                    </div>
                </div>
            </header>

            @hasSection('page-header')
                <section class="border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
                    <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                        @yield('page-header')
                    </div>
                </section>
            @endif

            <main class="flex-1">
                <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    @php
                        $rawTimeout = session('timeout') ?? session('timer') ?? session('temporizador') ?? session('tiempo') ?? 3000;
                        $timeoutMs = (is_numeric($rawTimeout) && $rawTimeout < 100) ? (int)$rawTimeout * 1000 : (int)$rawTimeout;
                    @endphp

                    @if (session('success'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4 text-emerald-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-emerald-400 hover:text-emerald-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-rose-500/40 bg-rose-500/10 p-4 text-rose-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-rose-400 hover:text-rose-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-amber-500/40 bg-amber-500/10 p-4 text-amber-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('warning')}}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-amber-400 hover:text-amber-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-slate-500 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    @yield('footer', 'Registro de animales')
                    <span>{{ now()->year }} &copy; {{ config('app.name', 'Laravel') }}</span>
                </div>
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const alerts = document.querySelectorAll('.flash-alert');
                alerts.forEach(alert => {
                    const timeout = parseInt(alert.dataset.timeout, 10) || 3000;
                    setTimeout(() => {
                        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => alert.remove(), 500);
                    }, timeout);
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>