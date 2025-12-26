<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Personal Docente y Administrativo') }}</h2>
            <a href="{{ route('admin.personal.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nuevo Personal</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.personal.index') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="tipo" value="Tipo" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="docente" {{ request('tipo') == 'docente' ? 'selected' : '' }}>Docente</option>
                                <option value="administrativo" {{ request('tipo') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                <option value="jerarquico" {{ request('tipo') == 'jerarquico' ? 'selected' : '' }}>Jerárquico</option>
                            </select>
                        </div>
                        <div><x-primary-button>Filtrar</x-primary-button></div>
                    </form>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DNI</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre Completo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cargo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Condición</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($personal as $p)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->dni }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $p->nombre_completo }}</div>
                                        <div class="text-sm text-gray-500">{{ $p->especialidad }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($p->tipo) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $p->cargo ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ ucfirst($p->condicion) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $p->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $p->activo ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.personal.show', $p) }}" class="text-gray-600 hover:text-gray-900 mr-3">Ver</a>
                                        <a href="{{ route('admin.personal.edit', $p) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.personal.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay personal registrado</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $personal->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
