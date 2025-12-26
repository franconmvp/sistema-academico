<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel Docente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$personal)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Su cuenta de usuario no está vinculada a un registro de personal. Contacte al administrador.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <!-- Welcome Card -->
                <div class="bg-gradient-to-r from-primary-900 to-primary-700 overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-white">Bienvenido(a), {{ $personal->nombres }}</h3>
                                <p class="text-2xl font-bold text-secondary-400 mt-2">{{ $personal->nombre_completo }}</p>
                                <p class="text-gray-300 mt-1">{{ $personal->especialidad ?? 'Docente' }}</p>
                            </div>
                            @if($periodoActivo)
                                <div class="text-right">
                                    <p class="text-gray-300 text-sm">Período Activo</p>
                                    <p class="text-2xl font-bold text-white">{{ $periodoActivo->nombre }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-primary-100 text-primary-900">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Cursos Asignados</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $asignaciones->count() }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-secondary-100 text-secondary-700">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Total Estudiantes</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $asignaciones->sum(fn($a) => $a->matriculaDetalles->count()) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="p-3 rounded-full bg-green-100 text-green-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-500">Horas Semanales</p>
                                    <p class="text-2xl font-bold text-gray-900">
                                        {{ $asignaciones->sum(fn($a) => $a->unidadDidactica->horas_semanales) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Assigned Courses -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Mis Asignaciones - {{ $periodoActivo?->nombre }}</h3>
                            <a href="{{ route('docente.asignaciones') }}" class="text-sm text-primary-600 hover:text-primary-800">Ver todas</a>
                        </div>
                        
                        @if($asignaciones->isEmpty())
                            <p class="text-gray-500 text-center py-8">No tiene asignaciones para este período.</p>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($asignaciones as $asignacion)
                                    <div class="border rounded-lg p-4 hover:bg-gray-50">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h4 class="font-medium text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</h4>
                                                <p class="text-sm text-gray-500">{{ $asignacion->unidadDidactica->codigo }}</p>
                                                <p class="text-sm text-gray-500 mt-1">
                                                    Turno: {{ $asignacion->turno->nombre }} | 
                                                    {{ $asignacion->unidadDidactica->horas_semanales }} hrs/sem
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-xs rounded-full bg-primary-100 text-primary-800">
                                                Ciclo {{ $asignacion->unidadDidactica->ciclo }}
                                            </span>
                                        </div>
                                        <div class="mt-4 flex space-x-2">
                                            <a href="{{ route('docente.lista-estudiantes', $asignacion) }}" class="text-sm text-primary-600 hover:text-primary-800">
                                                Ver Estudiantes
                                            </a>
                                            <span class="text-gray-300">|</span>
                                            <a href="{{ route('docente.registrar-notas', $asignacion) }}" class="text-sm text-green-600 hover:text-green-800">
                                                Registrar Notas
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
