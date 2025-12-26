<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $plan->nombre }}</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.unidades.create', ['plan_id' => $plan->id]) }}" class="inline-flex items-center px-4 py-2 bg-secondary-500 border border-transparent rounded-md font-semibold text-xs text-primary-900 uppercase tracking-widest hover:bg-secondary-400 transition">Nueva Unidad</a>
                <a href="{{ route('admin.planes.edit', $plan) }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Editar</a>
            </div>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div><p class="text-sm text-gray-500">Código</p><p class="text-lg font-medium">{{ $plan->codigo }}</p></div>
                        <div><p class="text-sm text-gray-500">Programa</p><p class="text-lg font-medium">{{ $plan->programaEstudio->nombre }}</p></div>
                        <div><p class="text-sm text-gray-500">Año Inicio</p><p class="text-lg font-medium">{{ $plan->anio_inicio }}</p></div>
                        <div><p class="text-sm text-gray-500">Estado</p><span class="px-2 py-1 text-xs rounded-full {{ $plan->vigente ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $plan->vigente ? 'Vigente' : 'No vigente' }}</span></div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Unidades Didácticas por Ciclo</h3>
                    @for($ciclo = 1; $ciclo <= $plan->programaEstudio->duracion_semestres; $ciclo++)
                        @php $unidadesCiclo = $plan->unidadesDidacticas->where('ciclo', $ciclo); @endphp
                        <div class="mb-6">
                            <h4 class="font-medium text-gray-700 mb-2 bg-gray-100 px-3 py-2 rounded">Ciclo {{ $ciclo }} ({{ $unidadesCiclo->sum('creditos') }} créditos)</h4>
                            @if($unidadesCiclo->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Créditos</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Horas</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach($unidadesCiclo as $unidad)
                                            <tr>
                                                <td class="px-4 py-2 text-sm text-gray-500">{{ $unidad->codigo }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-900">{{ $unidad->nombre }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $unidad->creditos }}</td>
                                                <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $unidad->horas_semanales }}</td>
                                                <td class="px-4 py-2 text-center"><span class="px-2 py-0.5 text-xs rounded {{ $unidad->tipo === 'obligatorio' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">{{ ucfirst($unidad->tipo) }}</span></td>
                                                <td class="px-4 py-2 text-right text-sm">
                                                    <a href="{{ route('admin.unidades.edit', $unidad) }}" class="text-primary-600 hover:text-primary-900">Editar</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-gray-500 text-sm px-4">No hay unidades registradas para este ciclo.</p>
                            @endif
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
