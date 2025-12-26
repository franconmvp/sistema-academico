<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Panel') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(!$estudiante)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                Su cuenta de usuario no está vinculada a un registro de estudiante. Contacte al administrador.
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
                                <h3 class="text-lg font-medium text-white">Bienvenido(a)</h3>
                                <p class="text-2xl font-bold text-secondary-400 mt-2">{{ $estudiante->nombre_completo }}</p>
                                <p class="text-gray-300 mt-1">{{ $estudiante->programaEstudio->nombre }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-300 text-sm">Código de Estudiante</p>
                                <p class="text-2xl font-bold text-white">{{ $estudiante->codigo_estudiante }}</p>
                                <p class="text-secondary-400 mt-2">Ciclo {{ $estudiante->ciclo_actual }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Quick Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Académica</h3>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Estado</dt>
                                    <dd>
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">
                                            {{ ucfirst($estudiante->estado) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Turno</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->turno->nombre }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Fecha Ingreso</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->fecha_ingreso->format('d/m/Y') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Plan de Estudio</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->planEstudio->nombre }}</dd>
                                </div>
                            </dl>
                            <div class="mt-6 pt-4 border-t">
                                <a href="{{ route('estudiante.mi-perfil') }}" class="text-primary-600 hover:text-primary-800 text-sm">
                                    Ver perfil completo →
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Current Enrollment -->
                    <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">
                                    Matrícula Actual
                                    @if($periodoActivo)
                                        <span class="text-sm font-normal text-gray-500">- {{ $periodoActivo->nombre }}</span>
                                    @endif
                                </h3>
                            </div>
                            
                            @if($matriculaActual && $matriculaActual->estado === 'aprobada')
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unidad Didáctica</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Créditos</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Nota</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($matriculaActual->detalles as $detalle)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $detalle->unidadDidactica->nombre }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->unidadDidactica->creditos }}</td>
                                                <td class="px-4 py-2 text-sm text-center font-medium {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-gray-500' }}">
                                                    {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <span class="px-2 py-0.5 text-xs rounded {{ $detalle->estado === 'aprobado' ? 'bg-green-100 text-green-800' : ($detalle->estado === 'cursando' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                        {{ ucfirst($detalle->estado) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('estudiante.ficha-matricula', $matriculaActual->id) }}" class="text-primary-600 hover:text-primary-800 text-sm">
                                        Ver ficha de matrícula →
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 text-center py-8">
                                    No tiene matrícula activa para el período actual.
                                </p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <a href="{{ route('estudiante.mis-notas') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Mis Notas</span>
                    </a>
                    <a href="{{ route('estudiante.historial-academico') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Historial</span>
                    </a>
                    <a href="{{ route('estudiante.mis-matriculas') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Matrículas</span>
                    </a>
                    <a href="{{ route('estudiante.mi-horario') }}" class="bg-white p-4 rounded-lg shadow hover:shadow-md transition flex items-center">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="ml-3 text-sm font-medium text-gray-700">Mi Horario</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
