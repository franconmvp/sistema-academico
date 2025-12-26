<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Información Institucional') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.institution.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="codigo_modular" value="Código Modular *" />
                                <x-text-input id="codigo_modular" name="codigo_modular" type="text" class="mt-1 block w-full" :value="old('codigo_modular', $institution->codigo_modular ?? '')" required />
                                <x-input-error :messages="$errors->get('codigo_modular')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nombre" value="Nombre de la Institución *" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre', $institution->nombre ?? '')" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tipo_ies" value="Tipo de IES" />
                                <x-text-input id="tipo_ies" name="tipo_ies" type="text" class="mt-1 block w-full" :value="old('tipo_ies', $institution->tipo_ies ?? '')" placeholder="Ej: Instituto de Educación Superior Tecnológico" />
                                <x-input-error :messages="$errors->get('tipo_ies')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="dre" value="DRE (Dirección Regional de Educación)" />
                                <x-text-input id="dre" name="dre" type="text" class="mt-1 block w-full" :value="old('dre', $institution->dre ?? '')" />
                                <x-input-error :messages="$errors->get('dre')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="direccion" value="Dirección" />
                                <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $institution->direccion ?? '')" />
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="telefono" value="Teléfono" />
                                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $institution->telefono ?? '')" />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="correo" value="Correo Electrónico" />
                                <x-text-input id="correo" name="correo" type="email" class="mt-1 block w-full" :value="old('correo', $institution->correo ?? '')" />
                                <x-input-error :messages="$errors->get('correo')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="pagina_web" value="Página Web" />
                                <x-text-input id="pagina_web" name="pagina_web" type="url" class="mt-1 block w-full" :value="old('pagina_web', $institution->pagina_web ?? '')" placeholder="https://www.ejemplo.edu.pe" />
                                <x-input-error :messages="$errors->get('pagina_web')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="otros" value="Información Adicional" />
                                <textarea id="otros" name="otros" rows="3" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('otros', $institution->otros ?? '') }}</textarea>
                                <x-input-error :messages="$errors->get('otros')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.institution.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Guardar Cambios') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
