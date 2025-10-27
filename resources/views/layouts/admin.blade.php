{{-- DEBUG temporal --}}
<div class="text-xs text-slate-500">
  Rol actual: {{ strtolower(auth()->user()->rol->nombre ?? 'sin rol') }}
</div>

<!doctype html>
<html lang="es" class="h-full">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Admin – {{ config('app.name') }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-slate-100 text-slate-800">
  <div class="min-h-full" x-data="{ open:false }">
    <header class="bg-white shadow sticky top-0 z-40">
      <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
        <div class="flex items-center gap-3">
          <button class="lg:hidden p-2 rounded-md hover:bg-slate-100" @click="open=!open">
            <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <svg x-show="open" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </button>
          <div class="flex items-center gap-2">
            <div class="h-9 w-9 rounded-xl bg-indigo-600 text-white grid place-items-center shadow">AD</div>
            <span class="font-semibold">Panel Administrador</span>
          </div>
        </div>
        <div class="flex items-center gap-4">
          <div class="text-sm text-slate-600">
            Bienvenide, <span class="font-semibold">{{ auth()->user()->nombre }}</span>
          </div>
          <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="hidden">
  @csrf
</form>

<a href="#" 
   class="text-sm font-medium text-rose-600 hover:text-rose-700 hover:underline transition"
   onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
  <i class="fas fa-sign-out-alt mr-1"></i> Salir
</a>

        </div>
      </div>
    </header>

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 grid grid-cols-1 lg:grid-cols-12 gap-6" x-data="{ tab: 'resumen' }">
      <aside class="lg:col-span-3">
        <nav :class="open ? 'block' : 'hidden lg:block'" class="bg-white rounded-2xl border border-slate-200 p-2">
          <p class="px-3 py-2 text-xs uppercase tracking-wide text-slate-500">Navegación</p>
          <ul class="space-y-1">
            @php
              $items = [
                ['id'=>'resumen','label'=>'Resumen','icon'=>'M3 12h18M3 6h18M3 18h18'],
                ['id'=>'usuarios','label'=>'Usuarios','icon'=>'M16 11c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z M4 20v-1a4 4 0 014-4h4'],
                ['id'=>'roles','label'=>'Roles','icon'=>'M12 6v6l4 2'],
                ['id'=>'permisos','label'=>'Permisos','icon'=>'M5 12l5 5L20 7'],
                ['id'=>'personas','label'=>'Personas','icon'=>'M15 11a3 3 0 11-6 0 3 3 0 016 0z M4 20a8 8 0 1116 0'],
                ['id'=>'docentes','label'=>'Docentes','icon'=>'M12 14l9-5-9-5-9 5 9 5z'],
                ['id'=>'administrativos','label'=>'Administrativos','icon'=>'M3 7h18M5 10h14M7 13h10M9 16h6'],
                ['id'=>'asistencias','label'=>'Asistencias','icon'=>'M8 7V3m8 4V3M3 11h18M5 19h14'],
                ['id'=>'cuenta','label'=>'Mi cuenta','icon'=>'M15 11a3 3 0 11-6 0 3 3 0 016 0z M4 20a8 8 0 1116 0'],
              ];
            @endphp
            @foreach($items as $it)
              <li>
                <button @click="tab='{{ $it['id'] }}'; open=false"
                        :class="tab==='{{ $it['id'] }}' ? 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200' : 'text-slate-700 hover:bg-slate-50'"
                        class="w-full flex items-center gap-3 rounded-xl px-3 py-2 transition">
                  <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $it['icon'] }}"/>
                  </svg>
                  <span class="text-sm font-medium">{{ $it['label'] }}</span>
                </button>
              </li>
            @endforeach
          </ul>
        </nav>
      </aside>

      <main class="lg:col-span-9 space-y-6">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
