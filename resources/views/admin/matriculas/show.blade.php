<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de Matrícula') }}
            </h2>
            <a href="{{ route('admin.matriculas.ficha', $matricula) }}" class="inline-flex items-center px-4 py-2 bg-secondary-500 border border-transparent rounded-md font-semibold text-xs text-primary-900 uppercase tracking-widest hover:bg-secondary-400 transition">
                Imprimir Ficha
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Estudiante</h3>
                            <dl class="space-y-2">
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Código:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->codigo_estudiante }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Nombre:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->nombre_completo }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">DNI:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->dni }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Programa:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->programaEstudio->nombre }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Turno:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->estudiante->turno->nombre }}</dd>
                                </div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Matrícula</h3>
                            <dl class="space-y-2">
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Período:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->periodoLectivo->nombre }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Ciclo:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->ciclo }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Tipo:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ ucfirst($matricula->tipo) }}</dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Estado:</dt>
                                    <dd>
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $matricula->estado === 'aprobada' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $matricula->estado === 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                            {{ $matricula->estado === 'rechazada' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ ucfirst($matricula->estado) }}
                                        </span>
                                    </dd>
                                </div>
                                <div class="flex">
                                    <dt class="text-sm text-gray-500 w-32">Fecha:</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $matricula->fecha_matricula->format('d/m/Y') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Unidades Didácticas Matriculadas</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidad Didáctica</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Créditos</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Horas</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Docente</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Nota</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($matricula->detalles as $detalle)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $detalle->unidadDidactica->codigo }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detalle->unidadDidactica->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $detalle->unidadDidactica->creditos }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">{{ $detalle->unidadDidactica->horas_semanales }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $detalle->asignacionDocente?->personal?->nombre_completo ?? 'Sin asignar' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-center font-medium {{ ($detalle->nota?->nota_definitiva ?? 0) >= 13 ? 'text-green-600' : 'text-gray-500' }}">
                                        {{ $detalle->nota?->nota_definitiva ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $detalle->estado === 'aprobado' ? 'bg-green-100 text-green-800' : '' }}
                                            {{ $detalle->estado === 'cursando' ? 'bg-blue-100 text-blue-800' : '' }}
                                            {{ $detalle->estado === 'desaprobado' ? 'bg-red-100 text-red-800' : '' }}
                                        ">
                                            {{ ucfirst($detalle->estado) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @if($matricula->estado === 'pendiente')
                        <div class="mt-6 pt-6 border-t flex justify-end space-x-4">
                            <form action="{{ route('admin.matriculas.rechazar', $matricula) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 transition">
                                    Rechazar Matrícula
                                </button>
                            </form>
                            <form action="{{ route('admin.matriculas.aprobar', $matricula) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 transition">
                                    Aprobar Matrícula
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
