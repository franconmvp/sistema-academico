<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Registrar Nuevo Personal') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.personal.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="dni" value="DNI *" />
                                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni')" maxlength="8" required />
                                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="apellido_paterno" value="Apellido Paterno *" />
                                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" class="mt-1 block w-full" :value="old('apellido_paterno')" required />
                                <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="apellido_materno" value="Apellido Materno *" />
                                <x-text-input id="apellido_materno" name="apellido_materno" type="text" class="mt-1 block w-full" :value="old('apellido_materno')" required />
                                <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nombres" value="Nombres *" />
                                <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres')" required />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tipo" value="Tipo *" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="docente" {{ old('tipo') == 'docente' ? 'selected' : '' }}>Docente</option>
                                    <option value="administrativo" {{ old('tipo') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                                    <option value="jerarquico" {{ old('tipo') == 'jerarquico' ? 'selected' : '' }}>Jerárquico</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="condicion" value="Condición *" />
                                <select id="condicion" name="condicion" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="contratado" {{ old('condicion') == 'contratado' ? 'selected' : '' }}>Contratado</option>
                                    <option value="nombrado" {{ old('condicion') == 'nombrado' ? 'selected' : '' }}>Nombrado</option>
                                </select>
                                <x-input-error :messages="$errors->get('condicion')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="cargo" value="Cargo" />
                                <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" :value="old('cargo')" />
                            </div>
                            <div>
                                <x-input-label for="especialidad" value="Especialidad" />
                                <x-text-input id="especialidad" name="especialidad" type="text" class="mt-1 block w-full" :value="old('especialidad')" />
                            </div>
                            <div>
                                <x-input-label for="grado_academico" value="Grado Académico" />
                                <x-text-input id="grado_academico" name="grado_academico" type="text" class="mt-1 block w-full" :value="old('grado_academico')" />
                            </div>
                            <div>
                                <x-input-label for="telefono" value="Teléfono" />
                                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono')" />
                            </div>
                            <div>
                                <x-input-label for="fecha_nacimiento" value="Fecha Nacimiento" />
                                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento')" />
                            </div>
                            <div>
                                <x-input-label for="sexo" value="Sexo" />
                                <select id="sexo" name="sexo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Seleccione...</option>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                            </div>
                        </div>
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Cuenta de Usuario (Opcional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="email" value="Email Institucional" />
                                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                                <div class="flex items-center pt-6">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="crear_cuenta" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('crear_cuenta') ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-600">Crear cuenta de acceso (contraseña = DNI)</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.personal.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Registrar Personal') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
