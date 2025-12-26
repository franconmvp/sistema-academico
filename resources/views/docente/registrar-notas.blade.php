<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Registrar Notas') }} - {{ $asignacion->unidadDidactica->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Course Info -->
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-primary-700"><strong>Período:</strong> {{ $asignacion->periodoLectivo->nombre }}</p>
                        <p class="text-sm text-primary-700"><strong>Turno:</strong> {{ $asignacion->turno->nombre }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-primary-700"><strong>Créditos:</strong> {{ $asignacion->unidadDidactica->creditos }}</p>
                        <p class="text-sm text-primary-700"><strong>Ciclo:</strong> {{ $asignacion->unidadDidactica->ciclo }}</p>
                    </div>
                </div>
            </div>

            @if($estudiantes->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-gray-500 text-center py-8">No hay estudiantes matriculados en esta unidad didáctica.</p>
                    </div>
                </div>
            @else
                <form method="POST" action="{{ route('docente.guardar-notas', $asignacion) }}">
                    @csrf
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°</th>
                                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota 1</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota 2</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota 3</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota 4</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Prom. Parcial</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ex. Final</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Prom. Final</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Recup.</th>
                                        <th class="px-3 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Definitiva</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($estudiantes->sortBy('matricula.estudiante.apellido_paterno') as $index => $detalle)
                                        <tr>
                                            <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-3 py-2 whitespace-nowrap">
                                                <input type="hidden" name="notas[{{ $index }}][matricula_detalle_id]" value="{{ $detalle->id }}">
                                                <div class="text-sm font-medium text-gray-900">{{ $detalle->matricula->estudiante->nombre_completo }}</div>
                                                <div class="text-xs text-gray-500">{{ $detalle->matricula->estudiante->codigo_estudiante }}</div>
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][nota_1]" value="{{ $detalle->nota?->nota_1 }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][nota_2]" value="{{ $detalle->nota?->nota_2 }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][nota_3]" value="{{ $detalle->nota?->nota_3 }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][nota_4]" value="{{ $detalle->nota?->nota_4 }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2 text-center text-sm font-medium text-gray-700 bg-gray-50">
                                                {{ $detalle->nota?->promedio_parcial ?? '-' }}
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][examen_final]" value="{{ $detalle->nota?->examen_final }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2 text-center text-sm font-medium text-gray-700 bg-gray-50">
                                                {{ $detalle->nota?->promedio_final ?? '-' }}
                                            </td>
                                            <td class="px-1 py-2">
                                                <input type="number" name="notas[{{ $index }}][nota_recuperacion]" value="{{ $detalle->nota?->nota_recuperacion }}" 
                                                    class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:border-primary-500 focus:ring-primary-500"
                                                    min="0" max="20" step="0.25">
                                            </td>
                                            <td class="px-1 py-2 text-center text-sm font-bold {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }} bg-gray-50">
                                                {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="px-6 py-4 bg-gray-50 border-t flex justify-between items-center">
                            <p class="text-sm text-gray-500">
                                Las notas se calculan automáticamente al guardar. Nota mínima aprobatoria: 13
                            </p>
                            <x-primary-button>
                                Guardar Notas
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
