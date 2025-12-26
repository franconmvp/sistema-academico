<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Planes de Estudio') }}</h2>
            <a href="{{ route('admin.planes.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nuevo Plan</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Año Inicio</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Unidades</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($planes as $plan)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $plan->codigo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $plan->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $plan->programaEstudio->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">{{ $plan->anio_inicio }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">{{ $plan->unidades_didacticas_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $plan->vigente ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $plan->vigente ? 'Vigente' : 'No vigente' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.planes.show', $plan) }}" class="text-gray-600 hover:text-gray-900 mr-3">Ver</a>
                                        <a href="{{ route('admin.planes.edit', $plan) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.planes.destroy', $plan) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay planes registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $planes->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
