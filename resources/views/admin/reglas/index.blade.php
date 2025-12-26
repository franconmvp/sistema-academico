<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Reglas de Promoción') }}</h2>
            <a href="{{ route('admin.reglas.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nueva Regla</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <p class="text-sm text-primary-700">Las reglas de promoción definen el número máximo de estudiantes que pueden matricularse por programa, turno y ciclo.</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.reglas.index') }}" class="flex gap-4 items-end">
                        <div>
                            <x-input-label for="programa_id" value="Programa" />
                            <select id="programa_id" name="programa_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="">Todos</option>
                                @foreach($programas as $programa)
                                    <option value="{{ $programa->id }}" {{ request('programa_id') == $programa->id ? 'selected' : '' }}>{{ $programa->nombre }}</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Programa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turno</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Máx. Matriculados</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($reglas as $regla)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $regla->programaEstudio->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $regla->turno->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $regla->ciclo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">{{ $regla->max_matriculados }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.reglas.edit', $regla) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.reglas.destroy', $regla) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay reglas registradas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $reglas->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
