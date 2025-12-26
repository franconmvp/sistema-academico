<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nuevo Turno') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.turnos.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="nombre" value="Nombre *" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-1 block w-full" :value="old('nombre')" placeholder="Ej: Mañana" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="hora_inicio" value="Hora de Inicio" />
                                <x-text-input id="hora_inicio" name="hora_inicio" type="time" class="mt-1 block w-full" :value="old('hora_inicio')" />
                            </div>
                            <div>
                                <x-input-label for="hora_fin" value="Hora de Fin" />
                                <x-text-input id="hora_fin" name="hora_fin" type="time" class="mt-1 block w-full" :value="old('hora_fin')" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.turnos.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Crear Turno') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
