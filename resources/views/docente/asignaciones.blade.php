<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Asignaciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Period Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('docente.asignaciones') }}" class="flex items-end gap-4">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->nombre }} {{ $periodo->activo ? '(Activo)' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($asignaciones->isEmpty())
                        <p class="text-gray-500 text-center py-8">No tiene asignaciones para este período.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($asignaciones as $asignacion)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->unidadDidactica->codigo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->unidadDidactica->planEstudio->programaEstudio->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $asignacion->unidadDidactica->ciclo }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->turno->nombre }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $asignacion->unidadDidactica->horas_semanales }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('docente.lista-estudiantes', $asignacion) }}" class="text-primary-600 hover:text-primary-900 mr-3">Estudiantes</a>
                                            <a href="{{ route('docente.registrar-notas', $asignacion) }}" class="text-green-600 hover:text-green-900 mr-3">Notas</a>
                                            <a href="{{ route('docente.reporte-notas', $asignacion) }}" class="text-secondary-600 hover:text-secondary-900">Reporte</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
