<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestión de Estudiantes') }}
            </h2>
            <a href="{{ route('admin.estudiantes.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                Nuevo Estudiante
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.estudiantes.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="search" value="Buscar" />
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Código, DNI o nombre..." />
                        </div>
                        <div>
                            <x-input-label for="programa_id" value="Programa" />
                            <select id="programa_id" name="programa_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                @foreach($programas as $programa)
                                    <option value="{{ $programa->id }}" {{ request('programa_id') == $programa->id ? 'selected' : '' }}>{{ $programa->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="estado" value="Estado" />
                            <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                <option value="egresado" {{ request('estado') == 'egresado' ? 'selected' : '' }}>Egresado</option>
                                <option value="retirado" {{ request('estado') == 'retirado' ? 'selected' : '' }}>Retirado</option>
                                <option value="suspendido" {{ request('estado') == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($estudiantes as $estudiante)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $estudiante->codigo_estudiante }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $estudiante->nombre_completo }}</div>
                                        <div class="text-sm text-gray-500">DNI: {{ $estudiante->dni }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $estudiante->programaEstudio->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $estudiante->ciclo_actual }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $estudiante->turno->nombre ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $estudiante->estado === 'activo' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $estudiante->estado === 'egresado' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $estudiante->estado === 'retirado' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $estudiante->estado === 'suspendido' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        ">
                                            {{ ucfirst($estudiante->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.estudiantes.show', $estudiante) }}" class="text-gray-600 hover:text-gray-900 mr-3">Ver</a>
                                        <a href="{{ route('admin.estudiantes.edit', $estudiante) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.estudiantes.destroy', $estudiante) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro de eliminar este estudiante?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay estudiantes registrados</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $estudiantes->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
