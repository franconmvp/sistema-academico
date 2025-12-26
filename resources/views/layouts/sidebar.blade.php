<nav class="px-4 space-y-1">
    <!-- Dashboard -->
    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
        <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-primary-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        Dashboard
    </a>

    @if(auth()->user()->isAdmin())
        <!-- Admin Menu -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Institución</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.institution.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.institution.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Información General
                </a>
                <a href="{{ route('admin.periodos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.periodos.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Períodos Lectivos
                </a>
                <a href="{{ route('admin.turnos.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.turnos.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Turnos
                </a>
                <a href="{{ route('admin.reglas.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reglas.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Reglas de Promoción
                </a>
            </div>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Académico</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.programas.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.programas.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Programas de Estudio
                </a>
                <a href="{{ route('admin.planes.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.planes.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Planes de Estudio
                </a>
                <a href="{{ route('admin.unidades.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.unidades.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Unidades Didácticas
                </a>
            </div>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Personal</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.personal.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.personal.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Personal Docente/Admin
                </a>
                <a href="{{ route('admin.asignaciones.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.asignaciones.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    Asignación Docente
                </a>
                <a href="{{ route('admin.horarios.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.horarios.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Horarios
                </a>
            </div>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Estudiantes</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.estudiantes.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.estudiantes.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Gestión de Estudiantes
                </a>
                <a href="{{ route('admin.matriculas.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.matriculas.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Matrículas
                </a>
            </div>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Reportes</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.reportes.matricula-semestral') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reportes.matricula-semestral') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Matrícula Semestral
                </a>
                <a href="{{ route('admin.reportes.notas-periodo') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reportes.notas-periodo') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Notas por Período
                </a>
                <a href="{{ route('admin.reportes.actas') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.reportes.actas') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Actas de Notas
                </a>
                <a href="{{ route('admin.certificados.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.certificados.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                    Certificados
                </a>
            </div>
        </div>

        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Sistema</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('admin.users.*') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Usuarios
                </a>
            </div>
        </div>
    @endif

    @if(auth()->user()->isDocente())
        <!-- Docente Menu -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Docente</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('docente.asignaciones') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('docente.asignaciones') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Mis Asignaciones
                </a>
                <a href="{{ route('docente.mi-horario') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('docente.mi-horario') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mi Horario
                </a>
            </div>
        </div>
    @endif

    @if(auth()->user()->isEstudiante())
        <!-- Estudiante Menu -->
        <div class="pt-4">
            <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider">Mi Información</p>
            <div class="mt-2 space-y-1">
                <a href="{{ route('estudiante.mi-perfil') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('estudiante.mi-perfil') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Mi Perfil
                </a>
                <a href="{{ route('estudiante.mis-matriculas') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('estudiante.mis-matriculas') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Mis Matrículas
                </a>
                <a href="{{ route('estudiante.mis-notas') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('estudiante.mis-notas') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Mis Notas
                </a>
                <a href="{{ route('estudiante.historial-academico') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('estudiante.historial-academico') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Historial Académico
                </a>
                <a href="{{ route('estudiante.mi-horario') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('estudiante.mi-horario') ? 'bg-primary-100 text-primary-900' : 'text-gray-700 hover:bg-gray-100' }}">
                    <svg class="mr-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Mi Horario
                </a>
            </div>
        </div>
    @endif
</nav>
