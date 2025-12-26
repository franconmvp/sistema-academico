<nav x-data="{ open: false }" class="bg-primary-900 border-b border-primary-800">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center flex-1 min-w-0">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <x-application-logo class="block h-8 w-auto fill-current text-white" />
                        <span class="ml-2 text-white font-bold text-sm hidden lg:block">Sistema Académico</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-2 sm:-my-px sm:ms-6 sm:flex flex-1 min-w-0">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('dashboard') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                        Dashboard
                    </a>

                    @if(auth()->user()->isAdmin())
                        <!-- Admin Menu -->
                        <div class="hidden sm:flex sm:items-center" x-data="{ open: false }">
                            <div class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-300 hover:text-white text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                                    Institución
                                    <svg class="ml-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <a href="{{ route('admin.institution.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Información General</a>
                                    <a href="{{ route('admin.periodos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Períodos Lectivos</a>
                                    <a href="{{ route('admin.turnos.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Turnos</a>
                                    <a href="{{ route('admin.reglas.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Reglas de Promoción</a>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center" x-data="{ open: false }">
                            <div class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-300 hover:text-white text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                                    Académico
                                    <svg class="ml-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <a href="{{ route('admin.programas.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Programas de Estudio</a>
                                    <a href="{{ route('admin.planes.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Planes de Estudio</a>
                                    <a href="{{ route('admin.unidades.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Unidades Didácticas</a>
                                </div>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center" x-data="{ open: false }">
                            <div class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-300 hover:text-white text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                                    Personal
                                    <svg class="ml-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <a href="{{ route('admin.personal.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Personal Docente/Admin</a>
                                    <a href="{{ route('admin.asignaciones.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asignación Docente</a>
                                    <a href="{{ route('admin.horarios.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Horarios</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.estudiantes.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.estudiantes.*') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Estudiantes
                        </a>

                        <a href="{{ route('admin.matriculas.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.matriculas.*') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Matrícula
                        </a>

                        <div class="hidden sm:flex sm:items-center" x-data="{ open: false }">
                            <div class="relative">
                                <button @click="open = !open" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-gray-300 hover:text-white text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                                    Reportes
                                    <svg class="ml-1 h-3 w-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" class="absolute left-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50">
                                    <a href="{{ route('admin.reportes.matricula-semestral') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Matrícula Semestral</a>
                                    <a href="{{ route('admin.reportes.notas-periodo') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Notas por Período</a>
                                    <a href="{{ route('admin.reportes.actas') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Actas</a>
                                    <a href="{{ route('admin.certificados.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Certificados</a>
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('admin.users.*') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Usuarios
                        </a>
                    @endif

                    @if(auth()->user()->isDocente())
                        <!-- Docente Menu -->
                        <a href="{{ route('docente.asignaciones') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('docente.asignaciones') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Mis Asignaciones
                        </a>
                        <a href="{{ route('docente.mi-horario') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('docente.mi-horario') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Mi Horario
                        </a>
                    @endif

                    @if(auth()->user()->isEstudiante())
                        <!-- Estudiante Menu -->
                        <a href="{{ route('estudiante.mi-perfil') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('estudiante.mi-perfil') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Mi Perfil
                        </a>
                        <a href="{{ route('estudiante.mis-matriculas') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('estudiante.mis-matriculas') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Mis Matrículas
                        </a>
                        <a href="{{ route('estudiante.mis-notas') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('estudiante.mis-notas') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Mis Notas
                        </a>
                        <a href="{{ route('estudiante.historial-academico') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('estudiante.historial-academico') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Historial
                        </a>
                        <a href="{{ route('estudiante.mi-horario') }}" class="inline-flex items-center px-1 pt-1 border-b-2 {{ request()->routeIs('estudiante.mi-horario') ? 'border-secondary-500 text-white' : 'border-transparent text-gray-300 hover:text-white hover:border-gray-300' }} text-xs font-medium leading-5 transition duration-150 ease-in-out whitespace-nowrap">
                            Horario
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-4 shrink-0">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-2 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-md text-gray-300 bg-primary-800 hover:text-white focus:outline-none transition ease-in-out duration-150">
                            <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>
                            <span class="ml-1.5 px-1.5 py-0.5 text-xs rounded-full {{ Auth::user()->isAdmin() ? 'bg-red-500' : (Auth::user()->isDocente() ? 'bg-blue-500' : 'bg-green-500') }} text-white">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                            <svg class="ml-1 fill-current h-3 w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Mi Perfil') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Cerrar Sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-primary-800 focus:outline-none focus:bg-primary-800 focus:text-white transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('admin.institution.index')" class="text-white">Institución</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.estudiantes.index')" class="text-white">Estudiantes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.matriculas.index')" class="text-white">Matrícula</x-responsive-nav-link>
            @endif

            @if(auth()->user()->isDocente())
                <x-responsive-nav-link :href="route('docente.asignaciones')" class="text-white">Mis Asignaciones</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('docente.mi-horario')" class="text-white">Mi Horario</x-responsive-nav-link>
            @endif

            @if(auth()->user()->isEstudiante())
                <x-responsive-nav-link :href="route('estudiante.mi-perfil')" class="text-white">Mi Perfil</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.mis-notas')" class="text-white">Mis Notas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('estudiante.historial-academico')" class="text-white">Historial Académico</x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-primary-700">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-white">
                    {{ __('Mi Perfil') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')" class="text-white"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Cerrar Sesión') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
