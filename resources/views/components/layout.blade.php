<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Gestión Veterinaria' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col font-sans antialiased">

    <!-- Navegación -->
    <header class="bg-slate-900/95 border-b border-slate-800 shadow-sm sticky top-0 z-10 backdrop-blur">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16">
            <div class="flex items-center gap-6">
                <span class="text-xl font-bold text-indigo-400 tracking-tight">🐾 Animals & Species</span>
                <nav class="flex gap-4 text-sm font-medium">
                    <a href="{{ route('species.index') }}"
                       class="transition-colors hover:text-indigo-400 {{ request()->routeIs('species.*') ? 'text-indigo-400 font-semibold' : 'text-slate-400' }}">
                        Especies
                    </a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full flex-1">

        {{-- Mensajes Flash con la directiva @session --}}
        @session('success')
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 flex items-center justify-between text-sm shadow-sm">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $value }}</span>
                </div>
            </div>
        @endsession

        {{ $slot }}
    </main>

    <footer class="py-6 text-center text-xs text-slate-500 border-t border-slate-800 bg-slate-950">
        Ejemplo didáctico • Laravel & Blade
    </footer>
</body>
</html>
