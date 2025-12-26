<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reporte de Matrícula Semestral') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.reportes.matricula-semestral') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>{{ $periodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Resumen de Matrículas</h3>
                        <p class="text-gray-500">Total: {{ $matriculas->count() }} estudiantes</p>
                    </div>
                    @foreach($matriculasPorPrograma as $programa => $matriculasPrograma)
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-800 mb-2 bg-gray-100 px-3 py-2 rounded">{{ $programa }} ({{ $matriculasPrograma->count() }} estudiantes)</h4>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Ciclo</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Turno</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">U.D.</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($matriculasPrograma as $index => $matricula)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $matricula->estudiante->codigo_estudiante }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $matricula->estudiante->nombre_completo }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $matricula->ciclo }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $matricula->estudiante->turno->nombre }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $matricula->detalles->count() }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $matricula->fecha_matricula->format('d/m/Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                    @if($matriculas->isEmpty())
                        <p class="text-gray-500 text-center py-8">No hay matrículas aprobadas para este período.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
