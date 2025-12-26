<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Notas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @forelse($matriculas as $matricula)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $matricula->periodoLectivo->nombre }}</h3>
                                <p class="text-sm text-gray-500">Ciclo {{ $matricula->ciclo }}</p>
                            </div>
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unidad Didáctica</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">N1</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">N2</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">N3</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">N4</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PP</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">EF</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">PF</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">RC</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Final</th>
                                    <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($matricula->detalles as $detalle)
                                    <tr>
                                        <td class="px-4 py-2">
                                            <div class="text-sm font-medium text-gray-900">{{ $detalle->unidadDidactica->nombre }}</div>
                                            <div class="text-xs text-gray-500">{{ $detalle->unidadDidactica->codigo }}</div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_1 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_2 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_3 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_4 ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center bg-gray-50">{{ $detalle->nota?->promedio_parcial ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->examen_final ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center bg-gray-50">{{ $detalle->nota?->promedio_final ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-500 text-center">{{ $detalle->nota?->nota_recuperacion ?? '-' }}</td>
                                        <td class="px-4 py-2 text-sm text-center font-bold {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-red-600' }} bg-gray-50">
                                            {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <span class="px-2 py-0.5 text-xs rounded {{ $detalle->nota?->estado === 'aprobado' ? 'bg-green-100 text-green-800' : ($detalle->nota?->estado === 'pendiente' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                                {{ $detalle->nota?->estado ? ucfirst($detalle->nota->estado) : 'Pendiente' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p class="mt-2 text-xs text-gray-500">N1-N4: Notas parciales | PP: Promedio Parcial | EF: Examen Final | PF: Promedio Final | RC: Recuperación</p>
                    </div>
                </div>
            @empty
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <p class="text-gray-500 text-center py-8">No hay notas disponibles.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
