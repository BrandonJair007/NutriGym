<nav class="bg-white shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <!-- Logo Dinámico por Rol -->
            <div class="flex items-center space-x-3">
                @auth
                    @php
                        // Determinamos la ruta de inicio según el rol del usuario logueado
                        $homeRoute = match(Auth::user()->id_rol) {
                            1 => 'admin',
                            2 => 'nutriologo',
                            3 => 'entrenador',
                            4 => 'usuario',
                            default => '/'
                        };
                    @endphp
                    <a href="{{ Route::has($homeRoute) ? route($homeRoute) : url('/') }}" class="flex items-center space-x-3">
                        <x-application-logo class="h-8 w-auto text-indigo-600" />
                        <span class="hidden sm:block text-lg font-semibold text-gray-800">NutriGym</span>
                    </a>
                @else
                    <!-- Logo para usuarios no autenticados (Pantalla de Login/Registro) -->
                    <a href="{{ url('/') }}" class="flex items-center space-x-3">
                        <x-application-logo class="h-8 w-auto text-indigo-600" />
                        <span class="hidden sm:block text-lg font-semibold text-gray-800">NutriGym</span>
                    </a>
                @endauth
            </div>

            <!-- Menú Desktop -->
            <div class="hidden md:flex items-center space-x-1">
                @auth
                    <!-- Solo se muestra si hay una sesión activa en el servidor -->
                    <span class="px-4 py-2 text-sm font-medium text-gray-600">
                        👋 Hola, {{ Auth::user()->nombre }}
                    </span>

                    @if(Route::has('cuenta'))
                        <a href="{{ route('cuenta') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 rounded-lg transition">
                            👤 Mi Cuenta
                        </a>
                    @endif

                    <!-- Formulario POST: Único método seguro para cerrar sesión y limpiar la cabecera -->
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                            🚪 Cerrar sesión
                        </button>
                    </form>
                @else
                    <!-- Enlaces visibles solo cuando NO hay sesión -->
                    @if(Route::has('registrar_usuario'))
                        <a href="{{ route('registrar_usuario') }}" class="px-4 py-2 text-sm font-medium text-gray-700 hover:text-indigo-600 transition">
                            Registrarse
                        </a>
                    @endif
                    
                    @if(Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-medium text-indigo-600 font-bold hover:bg-gray-50 rounded-lg transition ml-2">
                            Iniciar Sesión
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Botón Menú Móvil -->
            <div class="md:hidden">
                <button id="mobile-menu-button" type="button" class="p-2 rounded-md text-gray-700 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menú Móvil -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200 shadow-lg pb-4">
            <div class="px-4 pt-2 space-y-2">
                @auth
                    <div class="py-3 border-b border-gray-100 mb-2">
                        <p class="text-sm font-bold text-indigo-600 uppercase tracking-wider">Perfil</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>

                    @if(Route::has('cuenta'))
                        <a href="{{ route('cuenta') }}" class="block px-4 py-2 text-base font-medium text-gray-700 hover:bg-indigo-50 rounded-lg">👤 Ver cuenta</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="block w-full">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:bg-red-50 rounded-lg transition">
                            🚪 Cerrar sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('registrar_usuario') }}" class="block px-4 py-3 text-base font-medium text-gray-700 hover:bg-indigo-50 rounded-lg">Registrarse</a>
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-base font-medium text-indigo-600 font-bold hover:bg-indigo-50 rounded-lg">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<script>
    // Control del despliegue del menú en móviles
    const mobileBtn = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileBtn && mobileMenu) {
        mobileBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
</script>