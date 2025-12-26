<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Estudiante') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.estudiantes.update', $estudiante) }}">
                        @csrf
                        @method('PUT')

                        <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Académicos</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <x-input-label for="codigo_estudiante" value="Código de Estudiante *" />
                                <x-text-input id="codigo_estudiante" name="codigo_estudiante" type="text" class="mt-1 block w-full" :value="old('codigo_estudiante', $estudiante->codigo_estudiante)" required />
                                <x-input-error :messages="$errors->get('codigo_estudiante')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="programa_estudio_id" value="Programa de Estudio *" />
                                <select id="programa_estudio_id" name="programa_estudio_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($programas as $programa)
                                        <option value="{{ $programa->id }}" {{ old('programa_estudio_id', $estudiante->programa_estudio_id) == $programa->id ? 'selected' : '' }}>{{ $programa->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('programa_estudio_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="plan_estudio_id" value="Plan de Estudio *" />
                                <select id="plan_estudio_id" name="plan_estudio_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($planes as $plan)
                                        <option value="{{ $plan->id }}" {{ old('plan_estudio_id', $estudiante->plan_estudio_id) == $plan->id ? 'selected' : '' }}>{{ $plan->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('plan_estudio_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="turno_id" value="Turno *" />
                                <select id="turno_id" name="turno_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}" {{ old('turno_id', $estudiante->turno_id) == $turno->id ? 'selected' : '' }}>{{ $turno->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('turno_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ciclo_actual" value="Ciclo Actual *" />
                                <x-text-input id="ciclo_actual" name="ciclo_actual" type="number" class="mt-1 block w-full" :value="old('ciclo_actual', $estudiante->ciclo_actual)" min="1" max="12" required />
                                <x-input-error :messages="$errors->get('ciclo_actual')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="estado" value="Estado *" />
                                <select id="estado" name="estado" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="activo" {{ old('estado', $estudiante->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="egresado" {{ old('estado', $estudiante->estado) == 'egresado' ? 'selected' : '' }}>Egresado</option>
                                    <option value="retirado" {{ old('estado', $estudiante->estado) == 'retirado' ? 'selected' : '' }}>Retirado</option>
                                    <option value="suspendido" {{ old('estado', $estudiante->estado) == 'suspendido' ? 'selected' : '' }}>Suspendido</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mb-4 pt-4 border-t">Datos Personales</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="dni" value="DNI *" />
                                <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full" :value="old('dni', $estudiante->dni)" maxlength="8" required />
                                <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido_paterno" value="Apellido Paterno *" />
                                <x-text-input id="apellido_paterno" name="apellido_paterno" type="text" class="mt-1 block w-full" :value="old('apellido_paterno', $estudiante->apellido_paterno)" required />
                                <x-input-error :messages="$errors->get('apellido_paterno')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="apellido_materno" value="Apellido Materno *" />
                                <x-text-input id="apellido_materno" name="apellido_materno" type="text" class="mt-1 block w-full" :value="old('apellido_materno', $estudiante->apellido_materno)" required />
                                <x-input-error :messages="$errors->get('apellido_materno')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="nombres" value="Nombres *" />
                                <x-text-input id="nombres" name="nombres" type="text" class="mt-1 block w-full" :value="old('nombres', $estudiante->nombres)" required />
                                <x-input-error :messages="$errors->get('nombres')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="fecha_nacimiento" value="Fecha de Nacimiento" />
                                <x-text-input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="mt-1 block w-full" :value="old('fecha_nacimiento', $estudiante->fecha_nacimiento?->format('Y-m-d'))" />
                                <x-input-error :messages="$errors->get('fecha_nacimiento')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="sexo" value="Sexo" />
                                <select id="sexo" name="sexo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                    <option value="">Seleccione...</option>
                                    <option value="M" {{ old('sexo', $estudiante->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old('sexo', $estudiante->sexo) == 'F' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                <x-input-error :messages="$errors->get('sexo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="telefono" value="Teléfono" />
                                <x-text-input id="telefono" name="telefono" type="text" class="mt-1 block w-full" :value="old('telefono', $estudiante->telefono)" />
                                <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="direccion" value="Dirección" />
                                <x-text-input id="direccion" name="direccion" type="text" class="mt-1 block w-full" :value="old('direccion', $estudiante->direccion)" />
                                <x-input-error :messages="$errors->get('direccion')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email_personal" value="Email Personal" />
                                <x-text-input id="email_personal" name="email_personal" type="email" class="mt-1 block w-full" :value="old('email_personal', $estudiante->email_personal)" />
                                <x-input-error :messages="$errors->get('email_personal')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.estudiantes.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>
                                {{ __('Actualizar Estudiante') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
