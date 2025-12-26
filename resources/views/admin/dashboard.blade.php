<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-primary-100 text-primary-900">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Estudiantes Activos</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_estudiantes'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-secondary-100 text-secondary-700">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Docentes Activos</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_docentes'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Programas de Estudio</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_programas'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-red-100 text-red-600">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Matrículas Pendientes</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $stats['matriculas_pendientes'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Period Info -->
            @if($stats['periodo_activo'])
                <div class="bg-gradient-to-r from-primary-900 to-primary-700 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-white">Período Lectivo Activo</h3>
                                <p class="text-3xl font-bold text-secondary-400 mt-2">{{ $stats['periodo_activo']->nombre }}</p>
                                <p class="text-gray-300 mt-1">
                                    {{ $stats['periodo_activo']->fecha_inicio->format('d/m/Y') }} - {{ $stats['periodo_activo']->fecha_fin->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <a href="{{ route('admin.periodos.index') }}" class="inline-flex items-center px-4 py-2 bg-secondary-500 text-primary-900 font-medium rounded-md hover:bg-secondary-400 transition">
                                    Gestionar Períodos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No hay período lectivo activo. <a href="{{ route('admin.periodos.create') }}" class="font-medium underline">Crear uno ahora</a>
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Quick Actions -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <a href="{{ route('admin.estudiantes.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                                </svg>
                                <span class="ml-3 text-sm font-medium text-gray-700">Nuevo Estudiante</span>
                            </a>
                            <a href="{{ route('admin.matriculas.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="ml-3 text-sm font-medium text-gray-700">Nueva Matrícula</span>
                            </a>
                            <a href="{{ route('admin.personal.create') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="ml-3 text-sm font-medium text-gray-700">Nuevo Personal</span>
                            </a>
                            <a href="{{ route('admin.reportes.matricula-semestral') }}" class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="ml-3 text-sm font-medium text-gray-700">Ver Reportes</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Enrollments -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Últimas Matrículas</h3>
                            <a href="{{ route('admin.matriculas.index') }}" class="text-sm text-primary-600 hover:text-primary-800">Ver todas</a>
                        </div>
                        <div class="space-y-3">
                            @forelse($ultimasMatriculas as $matricula)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $matricula->estudiante->nombre_completo }}</p>
                                        <p class="text-sm text-gray-500">{{ $matricula->periodoLectivo->nombre }} - Ciclo {{ $matricula->ciclo }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $matricula->estado === 'aprobada' ? 'bg-green-100 text-green-800' : ($matricula->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst($matricula->estado) }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No hay matrículas recientes</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
