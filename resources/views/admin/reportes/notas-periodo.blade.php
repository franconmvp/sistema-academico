<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Notas por Período') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.reportes.notas-periodo') }}" class="flex gap-4 items-end">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($asignaciones as $asignacion)
                        <div class="mb-8 border rounded-lg overflow-hidden">
                            <div class="bg-primary-50 px-4 py-3 border-b flex justify-between items-center">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</h4>
                                    <p class="text-sm text-gray-500">{{ $asignacion->unidadDidactica->planEstudio->programaEstudio->nombre }} | Turno: {{ $asignacion->turno->nombre }} | Docente: {{ $asignacion->personal->nombre_completo }}</p>
                                </div>
                                <a href="{{ route('admin.reportes.generar-acta', $asignacion) }}" class="text-sm text-primary-600 hover:text-primary-800" onclick="return confirm('¿Generar acta para esta asignación?')">Generar Acta</a>
                            </div>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">N°</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estudiante</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PP</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">EF</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PF</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Final</th>
                                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($asignacion->matriculaDetalles->sortBy('matricula.estudiante.apellido_paterno') as $index => $detalle)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $index + 1 }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $detalle->matricula->estudiante->nombre_completo }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->promedio_parcial ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->examen_final ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->promedio_final ?? '-' }}</td>
                                            <td class="px-4 py-2 text-sm text-center font-bold {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }}">{{ $detalle->nota?->nota_definitiva ?? '-' }}</td>
                                            <td class="px-4 py-2 text-center"><span class="px-2 py-0.5 text-xs rounded {{ $detalle->nota?->estado === 'aprobado' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $detalle->nota?->estado ? ucfirst($detalle->nota->estado) : 'Pendiente' }}</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No hay asignaciones para este período.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
