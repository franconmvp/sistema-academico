<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Horario') }} - {{ $asignacion->unidadDidactica->nombre }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <p class="text-sm text-primary-700"><strong>Docente:</strong> {{ $asignacion->personal->nombre_completo }}</p>
                <p class="text-sm text-primary-700"><strong>Turno:</strong> {{ $asignacion->turno->nombre }}</p>
            </div>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.horarios.update', $asignacion) }}">
                        @csrf @method('PUT')
                        <div id="horarios-container">
                            @forelse($asignacion->horarios as $index => $horario)
                                <div class="horario-row grid grid-cols-5 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                                    <div>
                                        <x-input-label value="Día *" />
                                        <select name="horarios[{{ $index }}][dia]" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                            @foreach($dias as $dia)
                                                <option value="{{ $dia }}" {{ $horario->dia == $dia ? 'selected' : '' }}>{{ ucfirst($dia) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label value="Hora Inicio *" />
                                        <x-text-input type="time" name="horarios[{{ $index }}][hora_inicio]" class="mt-1 block w-full" value="{{ \Carbon\Carbon::parse($horario->hora_inicio)->format('H:i') }}" required />
                                    </div>
                                    <div>
                                        <x-input-label value="Hora Fin *" />
                                        <x-text-input type="time" name="horarios[{{ $index }}][hora_fin]" class="mt-1 block w-full" value="{{ \Carbon\Carbon::parse($horario->hora_fin)->format('H:i') }}" required />
                                    </div>
                                    <div>
                                        <x-input-label value="Aula" />
                                        <x-text-input type="text" name="horarios[{{ $index }}][aula]" class="mt-1 block w-full" value="{{ $horario->aula }}" />
                                    </div>
                                    <div class="flex items-end">
                                        <button type="button" onclick="this.closest('.horario-row').remove()" class="px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">Eliminar</button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 mb-4" id="no-horarios">No hay horarios asignados. Use el botón para agregar.</p>
                            @endforelse
                        </div>
                        <button type="button" onclick="agregarHorario()" class="mb-6 inline-flex items-center px-4 py-2 bg-secondary-500 text-primary-900 font-medium rounded-md hover:bg-secondary-400 transition">
                            + Agregar Horario
                        </button>
                        <div class="flex items-center justify-end pt-6 border-t">
                            <a href="{{ route('admin.horarios.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Guardar Horarios') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        let horarioIndex = {{ $asignacion->horarios->count() }};
        const dias = @json($dias);
        function agregarHorario() {
            document.getElementById('no-horarios')?.remove();
            const container = document.getElementById('horarios-container');
            const html = `
                <div class="horario-row grid grid-cols-5 gap-4 mb-4 p-4 bg-gray-50 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Día *</label>
                        <select name="horarios[${horarioIndex}][dia]" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                            ${dias.map(d => `<option value="${d}">${d.charAt(0).toUpperCase() + d.slice(1)}</option>`).join('')}
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hora Inicio *</label>
                        <input type="time" name="horarios[${horarioIndex}][hora_inicio]" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hora Fin *</label>
                        <input type="time" name="horarios[${horarioIndex}][hora_fin]" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Aula</label>
                        <input type="text" name="horarios[${horarioIndex}][aula]" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" />
                    </div>
                    <div class="flex items-end">
                        <button type="button" onclick="this.closest('.horario-row').remove()" class="px-3 py-2 bg-red-100 text-red-700 rounded hover:bg-red-200">Eliminar</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', html);
            horarioIndex++;
        }
    </script>
</x-app-layout>
