<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nuevo Programa de Estudio') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.programas.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="codigo" value="Código *" />
                                <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo')" required />
                                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nombre" value="Nombre *" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="duracion_semestres" value="Duración (semestres) *" />
                                <x-text-input id="duracion_semestres" name="duracion_semestres" type="number" class="mt-1 block w-full" :value="old('duracion_semestres', 6)" min="1" max="12" required />
                                <x-input-error :messages="$errors->get('duracion_semestres')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="descripcion" value="Descripción" />
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="activo" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('activo', true) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Programa activo</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.programas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Crear Programa') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
