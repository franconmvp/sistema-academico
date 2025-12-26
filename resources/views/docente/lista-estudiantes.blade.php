<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lista de Estudiantes') }} - {{ $asignacion->unidadDidactica->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Info -->
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-primary-700"><strong>Código:</strong> {{ $asignacion->unidadDidactica->codigo }}</p>
                        <p class="text-sm text-primary-700"><strong>Período:</strong> {{ $asignacion->periodoLectivo->nombre }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-primary-700"><strong>Turno:</strong> {{ $asignacion->turno->nombre }}</p>
                        <p class="text-sm text-primary-700"><strong>Total Estudiantes:</strong> {{ $estudiantes->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($estudiantes->isEmpty())
                        <p class="text-gray-500 text-center py-8">No hay estudiantes matriculados en esta unidad didáctica.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">N° Mat.</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($estudiantes->sortBy('matricula.estudiante.apellido_paterno') as $index => $detalle)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detalle->matricula->estudiante->codigo_estudiante }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detalle->matricula->estudiante->nombre_completo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detalle->matricula->estudiante->dni }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $detalle->numero_matricula }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-bold {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                            <span class="px-2 py-1 text-xs rounded-full 
                                                {{ $detalle->estado === 'aprobado' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $detalle->estado === 'cursando' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $detalle->estado === 'desaprobado' ? 'bg-red-100 text-red-800' : '' }}
                                            ">
                                                {{ ucfirst($detalle->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <div class="mt-6 pt-6 border-t flex justify-end space-x-4">
                        <a href="{{ route('docente.asignaciones') }}" class="text-gray-600 hover:text-gray-900">Volver</a>
                        <a href="{{ route('docente.registrar-notas', $asignacion) }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                            Registrar Notas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
