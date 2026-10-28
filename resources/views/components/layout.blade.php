<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gestión Veterinaria' }}</title>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
</head>
<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-100 min-h-screen flex flex-col font-sans antialiased">

    <!-- Navegación -->
    <header class="bg-white/95 dark:bg-slate-900/95 border-b border-slate-200 dark:border-slate-800 shadow-sm sticky top-0 z-10 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-6">
                <span class="text-xl font-bold text-indigo-600 dark:text-indigo-400 tracking-tight">🐾 Animals & Species</span>
                <nav class="flex gap-4 text-sm font-medium">
                    <a href="{{ route('animals.index') }}"
                       class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('animals.*') ? 'text-indigo-600 dark:text-indigo-500 font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                        Animales
                    </a>
                </nav>
                <nav class="flex gap-4 text-sm font-medium">
                    <a href="{{ route('species.index') }}"
                       class="transition-colors hover:text-indigo-600 dark:hover:text-indigo-400 {{ request()->routeIs('species.*') ? 'text-indigo-600 dark:text-indigo-500 font-bold' : 'text-slate-500 dark:text-slate-400' }}">
                        Especies
                    </a>
                </nav>
            </div>

            <div>
                <button onclick="
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                " type="button" class="p-2 text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-sm transition-colors" title="Cambiar tema">
                    <span class="dark:hidden">🌙</span>
                    <span class="hidden dark:inline">☀️</span>
                </button>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1">

        {{-- Mensajes Flash con la directiva @session --}}
        @session('success')
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-700 dark:text-emerald-300 flex items-center justify-between text-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $value }}</span>
                </div>
            </div>
        @endsession

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-700 dark:text-rose-300 text-sm shadow-sm">

                <div class="flex items-center gap-2">
                    <svg class="w-10 h-10 text-rose-600 dark:text-rose-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>Se han producido errores en el formulario:</span>
                </div>

                <div class="mt-2">
                    <ul class="ml-4 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @isset($title)
            <h1 class="mb-3 text-xl font-bold text-slate-800 dark:text-slate-100">{{ $title }}</h1>
        @endisset

        {{ $slot }}
    </main>

    <footer class="py-6 text-center text-xs text-slate-500 dark:text-slate-400 border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-950">
        Ejemplo didáctico • Laravel & Blade
    </footer>
</body>
</html>
