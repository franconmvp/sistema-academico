<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Gestión de Horarios') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.horarios.index') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>{{ $periodo->nombre }} {{ $periodo->activo ? '(Activo)' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Horarios</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($asignaciones as $asignacion)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asignacion->personal->nombre_completo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->turno->nombre }}</td>
                                    <td class="px-6 py-4">
                                        @if($asignacion->horarios->count() > 0)
                                            @foreach($asignacion->horarios as $horario)
                                                <span class="inline-block px-2 py-1 text-xs bg-gray-100 rounded mr-1 mb-1">
                                                    {{ ucfirst($horario->dia) }} {{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}-{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-gray-400 text-sm">Sin horario asignado</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.horarios.edit', $asignacion) }}" class="text-primary-600 hover:text-primary-900">Editar Horario</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay asignaciones</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
