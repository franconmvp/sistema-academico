<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Regla de Promoción') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.reglas.update', $regla) }}">
                        @csrf @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="programa_estudio_id" value="Programa de Estudio *" />
                                <select id="programa_estudio_id" name="programa_estudio_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($programas as $programa)
                                        <option value="{{ $programa->id }}" {{ old('programa_estudio_id', $regla->programa_estudio_id) == $programa->id ? 'selected' : '' }}>{{ $programa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="turno_id" value="Turno *" />
                                <select id="turno_id" name="turno_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}" {{ old('turno_id', $regla->turno_id) == $turno->id ? 'selected' : '' }}>{{ $turno->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="ciclo" value="Ciclo *" />
                                <x-text-input id="ciclo" name="ciclo" type="number" class="mt-1 block w-full" :value="old('ciclo', $regla->ciclo)" min="1" max="12" required />
                            </div>
                            <div>
                                <x-input-label for="max_matriculados" value="Máximo de Matriculados *" />
                                <x-text-input id="max_matriculados" name="max_matriculados" type="number" class="mt-1 block w-full" :value="old('max_matriculados', $regla->max_matriculados)" min="1" max="100" required />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.reglas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Actualizar Regla') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
