<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nueva Unidad Didáctica') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.unidades.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="plan_estudio_id" value="Plan de Estudio *" />
                                <select id="plan_estudio_id" name="plan_estudio_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($planes as $plan)
                                        <option value="{{ $plan->id }}" {{ old('plan_estudio_id', $planSeleccionado ?? '') == $plan->id ? 'selected' : '' }}>{{ $plan->programaEstudio->nombre }} - {{ $plan->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('plan_estudio_id')" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="codigo" value="Código *" />
                                    <x-text-input id="codigo" name="codigo" type="text" class="mt-1 block w-full" :value="old('codigo')" required />
                                    <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="ciclo" value="Ciclo *" />
                                    <x-text-input id="ciclo" name="ciclo" type="number" class="mt-1 block w-full" :value="old('ciclo', 1)" min="1" max="12" required />
                                </div>
                            </div>
                            <div>
                                <x-input-label for="nombre" value="Nombre *" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div>
                                    <x-input-label for="creditos" value="Créditos *" />
                                    <x-text-input id="creditos" name="creditos" type="number" class="mt-1 block w-full" :value="old('creditos', 3)" min="1" max="10" required />
                                </div>
                                <div>
                                    <x-input-label for="horas_semanales" value="Horas/Semana *" />
                                    <x-text-input id="horas_semanales" name="horas_semanales" type="number" class="mt-1 block w-full" :value="old('horas_semanales', 4)" min="1" max="40" required />
                                </div>
                                <div>
                                    <x-input-label for="tipo" value="Tipo *" />
                                    <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                        <option value="obligatorio" {{ old('tipo') == 'obligatorio' ? 'selected' : '' }}>Obligatorio</option>
                                        <option value="electivo" {{ old('tipo') == 'electivo' ? 'selected' : '' }}>Electivo</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <x-input-label for="descripcion" value="Descripción" />
                                <textarea id="descripcion" name="descripcion" rows="2" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.unidades.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Crear Unidad') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
