<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Matrículas') }}
            </h2>
            <a href="{{ route('admin.matriculas.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                Nueva Matrícula
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.matriculas.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div>
                            <x-input-label for="periodo_id" value="Período Lectivo" />
                            <select id="periodo_id" name="periodo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                @foreach($periodos as $periodo)
                                    <option value="{{ $periodo->id }}" {{ $periodoId == $periodo->id ? 'selected' : '' }}>{{ $periodo->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="aprobada" {{ request('estado') == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                                <option value="rechazada" {{ request('estado') == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="tipo" value="Tipo" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="prematricula" {{ request('tipo') == 'prematricula' ? 'selected' : '' }}>Prematrícula</option>
                                <option value="matricula" {{ request('tipo') == 'matricula' ? 'selected' : '' }}>Matrícula</option>
                            </select>
                        </div>
                        <div>
                            <x-primary-button>Filtrar</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($matriculas as $matricula)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->nombre_completo }}</div>
                                        <div class="text-sm text-gray-500">{{ $matricula->estudiante->codigo_estudiante }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $matricula->estudiante->programaEstudio->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $matricula->ciclo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $matricula->estudiante->turno->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $matricula->tipo === 'matricula' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($matricula->tipo) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $matricula->estado === 'aprobada' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $matricula->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $matricula->estado === 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ ucfirst($matricula->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $matricula->fecha_matricula->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.matriculas.show', $matricula) }}" class="text-gray-600 hover:text-gray-900 mr-2">Ver</a>
                                        <a href="{{ route('admin.matriculas.ficha', $matricula) }}" class="text-primary-600 hover:text-primary-900 mr-2">Ficha</a>
                                        @if($matricula->estado === 'pendiente')
                                            <form action="{{ route('admin.matriculas.aprobar', $matricula) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900 mr-2">Aprobar</button>
                                            </form>
                                            <form action="{{ route('admin.matriculas.rechazar', $matricula) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-900">Rechazar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">No hay matrículas registradas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $matriculas->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
