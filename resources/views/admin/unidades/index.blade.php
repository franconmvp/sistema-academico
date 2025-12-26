<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Unidades Didácticas') }}</h2>
            <a href="{{ route('admin.unidades.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nueva Unidad</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.unidades.index') }}" class="flex gap-4 items-end">
                        <div class="flex-1">
                            <x-input-label for="plan_id" value="Plan de Estudio" />
                            <select id="plan_id" name="plan_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" onchange="this.form.submit()">
                                <option value="">Todos los planes</option>
                                @foreach($planes as $plan)
                                    <option value="{{ $plan->id }}" {{ request('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->programaEstudio->nombre }} - {{ $plan->nombre }}</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Plan</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ciclo</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Créditos</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($unidades as $unidad)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $unidad->codigo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-900">{{ $unidad->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-sm">{{ $unidad->planEstudio->programaEstudio->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">{{ $unidad->ciclo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">{{ $unidad->creditos }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-gray-500 text-center">{{ $unidad->horas_semanales }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.unidades.edit', $unidad) }}" class="text-primary-600 hover:text-primary-900 mr-3">Editar</a>
                                        <form action="{{ route('admin.unidades.destroy', $unidad) }}" method="POST" class="inline" onsubmit="return confirm('¿Está seguro?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay unidades registradas</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $unidades->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
