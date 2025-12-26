<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Personal') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.personal.update', $personal) }}">
                        @csrf @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="dni" value="DNI *" />
                                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $personal->dni)" maxlength="8" required />
                                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="apellido_paterno" value="Apellido Paterno *" />
                                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" class="mt-1 block w-full" :value="old('apellido_paterno', $personal->apellido_paterno)" required />
                            </div>
                            <div>
                                <x-input-label for="apellido_materno" value="Apellido Materno *" />
                                <x-text-input id="apellido_materno" name="apellido_materno" type="text" class="mt-1 block w-full" :value="old('apellido_materno', $personal->apellido_materno)" required />
                            </div>
                            <div>
                                <x-input-label for="nombres" value="Nombres *" />
                                <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', $personal->nombres)" required />
                            </div>
                            <div>
                                <x-input-label for="tipo" value="Tipo *" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="docente" {{ old('tipo', $personal->tipo) == 'docente' ? 'selected' : '' }}>Docente</option>
                                    <option value="administrativo" {{ old('tipo', $personal->tipo) == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                    <option value="jerarquico" {{ old('tipo', $personal->tipo) == 'jerarquico' ? 'selected' : '' }}>Jerárquico</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="condicion" value="Condición *" />
                                <select id="condicion" name="condicion" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="contratado" {{ old('condicion', $personal->condicion) == 'contratado' ? 'selected' : '' }}>Contratado</option>
                                    <option value="nombrado" {{ old('condicion', $personal->condicion) == 'nombrado' ? 'selected' : '' }}>Nombrado</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="cargo" value="Cargo" />
                                <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" :value="old('cargo', $personal->cargo)" />
                            </div>
                            <div>
                                <x-input-label for="especialidad" value="Especialidad" />
                                <x-text-input id="especialidad" name="especialidad" type="text" class="mt-1 block w-full" :value="old('especialidad', $personal->especialidad)" />
                            </div>
                            <div>
                                <x-input-label for="telefono" value="Teléfono" />
                                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $personal->telefono)" />
                            </div>
                            <div class="md:col-span-3">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="activo" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('activo', $personal->activo) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Personal activo</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.personal.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Actualizar Personal') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
