<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mis Matrículas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @forelse($matriculas as $matricula)
                        <div class="mb-6 border rounded-lg p-4 {{ $matricula->estado === 'aprobada' ? 'border-green-200 bg-green-50' : ($matricula->estado === 'pendiente' ? 'border-yellow-200 bg-yellow-50' : 'border-gray-200') }}">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900">{{ $matricula->periodoLectivo->nombre }}</h3>
                                    <p class="text-sm text-gray-500">Ciclo {{ $matricula->ciclo }} | {{ ucfirst($matricula->tipo) }}</p>
                                    <p class="text-sm text-gray-500">Fecha: {{ $matricula->fecha_matricula->format('d/m/Y') }}</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 text-xs rounded-full 
                                        {{ $matricula->estado === 'aprobada' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $matricula->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $matricula->estado === 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                                    ">
                                        {{ ucfirst($matricula->estado) }}
                                    </span>
                                    @if($matricula->estado === 'aprobada')
                                        <a href="{{ route('estudiante.ficha-matricula', $matricula->id) }}" class="inline-flex items-center px-3 py-1 bg-primary-600 text-white text-xs rounded hover:bg-primary-700">
                                            Ver Ficha
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4">
                                <p class="text-sm text-gray-600 mb-2">Unidades Didácticas: {{ $matricula->detalles->count() }}</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($matricula->detalles as $detalle)
                                        <span class="px-2 py-1 bg-white border border-gray-200 rounded text-xs text-gray-700">
                                            {{ $detalle->unidadDidactica->nombre }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-8">No tiene matrículas registradas.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
