<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="flex items-center mb-6 pb-6 border-b">
                        <div class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-2xl font-bold text-primary-600">
                                {{ strtoupper(substr($estudiante->nombres, 0, 1)) }}{{ strtoupper(substr($estudiante->apellido_paterno, 0, 1)) }}
                            </span>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $estudiante->nombre_completo }}</h3>
                            <p class="text-gray-500">{{ $estudiante->codigo_estudiante }}</p>
                            <span class="mt-2 inline-flex px-3 py-1 text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ ucfirst($estudiante->estado) }}
                            </span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Datos Personales -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Datos Personales</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">DNI</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->dni }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->fecha_nacimiento?->format('d/m/Y') ?? 'No registrado' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Sexo</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->sexo === 'M' ? 'Masculino' : ($estudiante->sexo === 'F' ? 'Femenino' : 'No registrado') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->telefono ?? 'No registrado' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->direccion ?? 'No registrado' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Email Personal</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->email_personal ?? 'No registrado' }}</dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Datos Académicos -->
                        <div>
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Datos Académicos</h4>
                            <dl class="space-y-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Programa de Estudio</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->programaEstudio->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Plan de Estudio</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->planEstudio->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Ciclo Actual</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->ciclo_actual }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Turno</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->turno->nombre }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Fecha de Ingreso</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ $estudiante->fecha_ingreso->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="mt-6 pt-6 border-t text-sm text-gray-500">
                        <p>Si desea actualizar su información personal, contacte a la oficina de administración.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
