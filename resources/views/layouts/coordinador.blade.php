<!doctype html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Panel Coordinador – {{ config('app.name') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <style>[x-cloak]{display:none!important}</style>
</head>
<body class="h-full bg-slate-100 text-slate-800">
<div class="min-h-full" x-data="{ open:false }">

  {{-- Header --}}
  <header class="bg-white shadow sticky top-0 z-40">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <button class="lg:hidden p-2 rounded-md hover:bg-slate-100" @click="open=!open" aria-label="Abrir menú">
          <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
          <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <div class="flex items-center gap-2">
          <div class="h-9 w-9 rounded-xl bg-emerald-600 text-white grid place-items-center shadow">CO</div>
          <span class="font-semibold">Panel Coordinador</span>
        </div>
      </div>

      <div class="flex items-center gap-4">
        <div class="text-sm text-slate-600">
          Bienvenido, <span class="font-semibold">{{ auth()->user()->nombre }}</span>
        </div>
        {{-- Logout (POST) --}}
        <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">@csrf</form>
        <a href="#"
           class="text-sm font-medium text-rose-600 hover:text-rose-700 hover:underline transition"
           onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
          Salir
        </a>
      </div>
    </div>
  </header>

  {{-- Layout principal con sidebar + contenido --}}
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6">
    {{-- Sidebar --}}
    <aside class="lg:col-span-3">
      <nav :class="open ? 'block' : 'hidden lg:block'" class="bg-white rounded-2xl border border-slate-200 p-2">
        <p class="px-3 py-2 text-xs uppercase tracking-wide text-slate-500">Navegación</p>
        <ul class="space-y-1">
          <li>
            <a href="{{ route('coordinador.dashboard') }}"
               class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition
                 {{ request()->routeIs('coordinador.dashboard') ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12h18M3 6h18M3 18h18"/>
              </svg>
              <span class="text-sm font-medium">Resumen</span>
            </a>
          </li>

          {{-- Mostrar Aulas solo si tiene permiso (opcional) --}}
          @if(method_exists(auth()->user(),'canPermiso') ? auth()->user()->canPermiso('gestionar-aulas') : true)
          <li>
            <a href="{{ route('aulas.index') }}"
               class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition
                 {{ request()->routeIs('aulas.*') ? 'bg-emerald-50 text-emerald-700 ring-1 ring-emerald-200' : 'text-slate-700 hover:bg-slate-50' }}">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
              <span class="text-sm font-medium">Aulas</span>
            </a>
          </li>
          @endif

          {{-- Más secciones, cuando las tengas --}}
          <li>
            <a href="#" class="w-full flex items-center gap-3 rounded-xl px-3 py-2 text-slate-400 cursor-not-allowed">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6l4 2"/>
              </svg>
              <span class="text-sm font-medium">Grupos (pronto)</span>
            </a>
          </li>
          <li>
            <a href="#" class="w-full flex items-center gap-3 rounded-xl px-3 py-2 text-slate-400 cursor-not-allowed">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 12l5 5L20 7"/>
              </svg>
              <span class="text-sm font-medium">Materias (pronto)</span>
            </a>
          </li>

          <li>
            <a href="{{ route('coordinador.dashboard') }}#cuenta"
               class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition text-slate-700 hover:bg-slate-50">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                      d="M15 11a3 3 0 11-6 0a3 3 0 016 0z M4 20a8 8 0 1116 0"/>
              </svg>
              <span class="text-sm font-medium">Mi cuenta</span>
            </a>
          </li>
        </ul>
      </nav>
    </aside>

    {{-- Contenido --}}
    <main class="lg:col-span-9 space-y-6">
      @yield('content')
    </main>
  </div>
</div>
</body>
</html>
