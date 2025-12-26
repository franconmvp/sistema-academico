<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $personal->nombre_completo }}</h2>
            <a href="{{ route('admin.personal.edit', $personal) }}" class="inline-flex items-center px-4 py-2 bg-primary-900 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-800 transition">Editar</a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Personales</h3>
                            <dl class="space-y-2">
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">DNI:</dt><dd class="text-sm text-gray-900">{{ $personal->dni }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Nombres:</dt><dd class="text-sm text-gray-900">{{ $personal->nombres }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Apellidos:</dt><dd class="text-sm text-gray-900">{{ $personal->apellido_paterno }} {{ $personal->apellido_materno }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Teléfono:</dt><dd class="text-sm text-gray-900">{{ $personal->telefono ?? '-' }}</dd></div>
                            </dl>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Datos Laborales</h3>
                            <dl class="space-y-2">
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Tipo:</dt><dd class="text-sm text-gray-900">{{ ucfirst($personal->tipo) }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Cargo:</dt><dd class="text-sm text-gray-900">{{ $personal->cargo ?? '-' }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Especialidad:</dt><dd class="text-sm text-gray-900">{{ $personal->especialidad ?? '-' }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Condición:</dt><dd class="text-sm text-gray-900">{{ ucfirst($personal->condicion) }}</dd></div>
                                <div class="flex"><dt class="text-sm text-gray-500 w-32">Estado:</dt><dd><span class="px-2 py-1 text-xs rounded-full {{ $personal->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ $personal->activo ? 'Activo' : 'Inactivo' }}</span></dd></div>
                            </dl>
                        </div>
                    </div>
                    @if($personal->tipo === 'docente' && $personal->asignacionesDocente->count() > 0)
                        <div class="mt-6 pt-6 border-t">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Asignaciones Docente</h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Período</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unidad Didáctica</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($personal->asignacionesDocente as $asignacion)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-500">{{ $asignacion->periodoLectivo->nombre }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $asignacion->unidadDidactica->nombre }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
