<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Actas de Notas') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.reportes.actas') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="">Todos</option>
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Acta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($actas as $acta)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $acta->numero_acta }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $acta->asignacionDocente->unidadDidactica->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acta->asignacionDocente->personal->nombre_completo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acta->asignacionDocente->turno->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $acta->fecha_generacion->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $acta->estado === 'aprobada' ? 'bg-green-100 text-green-800' : ($acta->estado === 'generada' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                            {{ ucfirst($acta->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.reportes.ver-acta', $acta) }}" class="text-primary-600 hover:text-primary-900">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay actas generadas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $actas->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
