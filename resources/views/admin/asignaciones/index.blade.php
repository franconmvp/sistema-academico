<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Asignación Docente') }}</h2>
            <a href="{{ route('admin.asignaciones.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nueva Asignación</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.asignaciones.index') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ request('periodo_id', $periodos->firstWhere('activo', true)?->id) == $periodo->id ? 'selected' : '' }}>
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
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aula</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($asignaciones as $asignacion)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $asignacion->personal->nombre_completo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</div>
                                        <div class="text-xs text-gray-500">{{ $asignacion->unidadDidactica->codigo }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->unidadDidactica->planEstudio->programaEstudio->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->turno->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $asignacion->aula ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.asignaciones.edit', $asignacion) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.asignaciones.destroy', $asignacion) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay asignaciones registradas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $asignaciones->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
