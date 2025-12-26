<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Perfil del Estudiante') }}
            </h2>
            <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Profile Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-center">
                            <div class="w-24 h-24 bg-primary-100 rounded-full mx-auto flex items-center justify-center">
                                <span class="text-3xl font-bold text-primary-600">{{ strtoupper(substr($estudiante->nombres, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido_paterno, 0, 1)) }}</span>
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">{{ $estudiante->nombre_completo }}</h3>
                            <p class="text-sm text-gray-500">{{ $estudiante->codigo_estudiante }}</p>
                            <span class="mt-2 inline-flex px-3 py-1 text-xs leading-5 font-semibold rounded-full 
                                {{ $estudiante->estado === 'activo' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $estudiante->estado === 'egresado' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $estudiante->estado === 'retirado' ? 'bg-red-100 text-red-800' : '' }}
                            ">
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                        </div>
                        <div class="mt-6 border-t pt-4">
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">DNI</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->dni }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Programa</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->programaEstudio->nombre ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Plan</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->planEstudio->nombre ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Ciclo Actual</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->ciclo_actual }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Turno</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->turno->nombre ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Fecha Ingreso</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $estudiante->fecha_ingreso->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Academic History -->
                <div class="lg:col-span-2 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Historial de Matrículas</h3>
                        
                        @forelse($estudiante->matriculas as $matricula)
                            <div class="mb-6 border rounded-lg p-4">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-medium text-gray-900">{{ $matricula->periodoLectivo->nombre }}</span>
                                        <span class="text-gray-500 ml-2">Ciclo {{ $matricula->ciclo }}</span>
                                    </div>
                                    <span class="px-2 py-1 text-xs rounded-full {{ $matricula->estado === 'aprobada' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($matricula->estado) }}
                                    </span>
                                </div>
                                
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unidad Didáctica</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Créditos</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Nota Final</th>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($matricula->detalles as $detalle)
                                            <tr>
                                                <td class="px-3 py-2 text-sm text-gray-900">{{ $detalle->unidadDidactica->nombre }}</td>
                                                <td class="px-3 py-2 text-sm text-gray-500 text-center">{{ $detalle->unidadDidactica->creditos }}</td>
                                                <td class="px-3 py-2 text-sm text-center font-medium {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }}">
                                                    {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                                </td>
                                                <td class="px-3 py-2 text-center">
                                                    <span class="px-2 py-0.5 text-xs rounded {{ $detalle->estado === 'aprobado' ? 'bg-green-100 text-green-800' : ($detalle->estado === 'cursando' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                        {{ ucfirst($detalle->estado) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">No hay matrículas registradas</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
