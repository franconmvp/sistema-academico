<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Información Institucional') }}
            </h2>
            <a href="{{ route('admin.institution.edit') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                Editar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($institution)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Datos Generales</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Código Modular</dt>
                                        <dd class="mt-1 text-lg text-gray-900">{{ $institution->codigo_modular }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Nombre de la Institución</dt>
                                        <dd class="mt-1 text-lg text-gray-900">{{ $institution->nombre }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Tipo de IES</dt>
                                        <dd class="mt-1 text-gray-900">{{ $institution->tipo_ies ?? 'No especificado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">DRE</dt>
                                        <dd class="mt-1 text-gray-900">{{ $institution->dre ?? 'No especificado' }}</dd>
                                    </div>
                                </dl>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b">Contacto</h3>
                                <dl class="space-y-3">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                        <dd class="mt-1 text-gray-900">{{ $institution->direccion ?? 'No especificado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                        <dd class="mt-1 text-gray-900">{{ $institution->telefono ?? 'No especificado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                                        <dd class="mt-1 text-gray-900">{{ $institution->correo ?? 'No especificado' }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Página Web</dt>
                                        <dd class="mt-1 text-gray-900">
                                            @if($institution->pagina_web)
                                                <a href="{{ $institution->pagina_web }}" target="_blank" class="text-primary-600 hover:underline">{{ $institution->pagina_web }}</a>
                                            @else
                                                No especificado
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                        @if($institution->otros)
                            <div class="mt-6 pt-6 border-t">
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Información Adicional</h3>
                                <p class="text-gray-700">{{ $institution->otros }}</p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay información registrada</h3>
                            <p class="mt-1 text-sm text-gray-500">Comienza configurando los datos de tu institución.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.institution.edit') }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">
                                    Configurar Institución
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
