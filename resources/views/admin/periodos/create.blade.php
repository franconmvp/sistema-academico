<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nuevo Período Lectivo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.periodos.store') }}">
                        @csrf

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="anio" value="Año *" />
                                <x-text-input id="anio" name="anio" type="number" class="mt-1 block w-full" :value="old('anio', date('Y'))" min="2020" max="2050" required />
                                <x-input-error :messages="$errors->get('anio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="semestre" value="Semestre *" />
                                <select id="semestre" name="semestre" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="I" {{ old('semestre') == 'I' ? 'selected' : '' }}>I</option>
                                    <option value="II" {{ old('semestre') == 'II' ? 'selected' : '' }}>II</option>
                                </select>
                                <x-input-error :messages="$errors->get('semestre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="fecha_inicio" value="Fecha de Inicio *" />
                                <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio')" required />
                                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="fecha_fin" value="Fecha de Fin *" />
                                <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="old('fecha_fin')" required />
                                <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                            </div>

                            <div class="col-span-2">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="activo" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('activo') ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Establecer como período activo</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.periodos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Crear Período') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
