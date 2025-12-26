<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $programa->nombre }}</h2>
            <a href="{{ route('admin.programas.edit', $programa) }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Editar</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div><p class="text-sm text-gray-500">Código</p><p class="text-lg font-medium">{{ $programa->codigo }}</p></div>
                        <div><p class="text-sm text-gray-500">Duración</p><p class="text-lg font-medium">{{ $programa->duracion_semestres }} semestres</p></div>
                        <div><p class="text-sm text-gray-500">Planes de Estudio</p><p class="text-lg font-medium">{{ $programa->planesEstudio->count() }}</p></div>
                        <div><p class="text-sm text-gray-500">Estudiantes</p><p class="text-lg font-medium">{{ $programa->estudiantes->count() }}</p></div>
                    </div>
                    @if($programa->descripcion)<p class="mt-4 text-gray-600">{{ $programa->descripcion }}</p>@endif
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Planes de Estudio</h3>
                    @forelse($programa->planesEstudio as $plan)
                        <div class="border rounded-lg p-4 mb-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $plan->nombre }}</h4>
                                    <p class="text-sm text-gray-500">Código: {{ $plan->codigo }} | Desde: {{ $plan->anio_inicio }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full {{ $plan->vigente ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $plan->vigente ? 'Vigente' : 'No vigente' }}
                                </span>
                            </div>
                            <div class="mt-3">
                                <p class="text-sm text-gray-600 mb-2">Unidades Didácticas: {{ $plan->unidadesDidacticas->count() }}</p>
                                <a href="{{ route('admin.planes.show', $plan) }}" class="text-primary-600 hover:text-primary-800 text-sm">Ver detalle →</a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No hay planes de estudio registrados.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
