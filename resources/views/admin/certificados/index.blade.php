<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Certificados, Grados y Títulos') }}</h2>
            <a href="{{ route('admin.certificados.create') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Nuevo Certificado</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-4">
                    <form method="GET" action="{{ route('admin.certificados.index') }}" class="flex flex-wrap gap-4 items-end">
                        <div class="flex-1 min-w-[200px]">
                            <x-input-label for="search" value="Buscar Estudiante" />
                            <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Código o nombre..." />
                        </div>
                        <div>
                            <x-input-label for="tipo" value="Tipo" />
                            <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                <option value="">Todos</option>
                                <option value="certificado_estudios" {{ request('tipo') == 'certificado_estudios' ? 'selected' : '' }}>Certificado de Estudios</option>
                                <option value="certificado_modular" {{ request('tipo') == 'certificado_modular' ? 'selected' : '' }}>Certificado Modular</option>
                                <option value="grado" {{ request('tipo') == 'grado' ? 'selected' : '' }}>Grado</option>
                                <option value="titulo" {{ request('tipo') == 'titulo' ? 'selected' : '' }}>Título</option>
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
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N° Documento</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estudiante</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Emisión</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($certificados as $certificado)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $certificado->numero_documento }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $certificado->estudiante->nombre_completo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $certificado->tipo_label }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $certificado->fecha_emision->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $certificado->estado === 'emitido' ? 'bg-blue-100 text-blue-800' : ($certificado->estado === 'entregado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($certificado->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.certificados.show', $certificado) }}" class="text-primary-600 hover:text-primary-900 mr-3">Ver</a>
                                        @if($certificado->estado === 'emitido')
                                            <form action="{{ route('admin.certificados.entregar', $certificado) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-900">Entregar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay certificados registrados</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $certificados->withQueryString()->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
