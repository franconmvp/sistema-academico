<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial Académico') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Promedio General</p>
                    <p class="text-3xl font-bold text-primary-600">{{ $estadisticas['promedio_general'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Créditos Aprobados</p>
                    <p class="text-3xl font-bold text-green-600">{{ $estadisticas['creditos_aprobados'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Total Créditos</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $estadisticas['total_creditos'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Materias Cursadas</p>
                    <p class="text-3xl font-bold text-gray-700">{{ $estadisticas['materias_cursadas'] }}</p>
                </div>
            </div>

            <!-- History by Period -->
            @forelse($matriculas as $matricula)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $matricula->periodoLectivo->nombre }}</h3>
                                <p class="text-sm text-gray-500">Ciclo {{ $matricula->ciclo }}</p>
                            </div>
                            <a href="{{ route('estudiante.ficha-matricula', $matricula->id) }}" class="text-primary-600 hover:text-primary-800 text-sm">
                                Ver ficha →
                            </a>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unidad Didáctica</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Créditos</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Nota 1</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Nota 2</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Nota 3</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PP</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">EF</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PF</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Final</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($matricula->detalles as $detalle)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-500">{{ $detalle->unidadDidactica->codigo }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-900">{{ $detalle->unidadDidactica->nombre }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->unidadDidactica->creditos }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_1 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_2 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_3 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->promedio_parcial ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->examen_final ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->promedio_final ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-center font-bold {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-0.5 text-xs rounded {{ $detalle->estado === 'aprobado' ? 'bg-green-100 text-green-800' : ($detalle->estado === 'cursando' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                {{ ucfirst($detalle->estado) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-gray-500 text-center py-8">No hay historial académico disponible.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
