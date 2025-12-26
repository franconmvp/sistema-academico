<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nueva Matrícula') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(!$periodoActivo)
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                    <div class="flex">
                        <div class="ml-3">
                            <p class="text-sm text-yellow-700">
                                No hay período lectivo activo. <a href="{{ route('admin.periodos.index') }}" class="font-medium underline">Configure uno primero</a>.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.matriculas.store') }}">
                        @csrf

                        <input type="hidden" name="periodo_lectivo_id" value="{{ $periodoActivo?->id }}">

                        <div class="bg-primary-50 p-4 rounded-lg mb-6">
                            <p class="text-sm text-primary-800">
                                <strong>Período Lectivo:</strong> {{ $periodoActivo?->nombre ?? 'No disponible' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <x-input-label for="estudiante_id" value="Estudiante *" />
                                <select id="estudiante_id" name="estudiante_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione un estudiante...</option>
                                    @foreach($estudiantes as $estudiante)
                                        <option value="{{ $estudiante->id }}" data-ciclo="{{ $estudiante->ciclo_actual }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                            {{ $estudiante->codigo_estudiante }} - {{ $estudiante->nombre_completo }} ({{ $estudiante->programaEstudio->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('estudiante_id')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="ciclo" value="Ciclo a Matricular *" />
                                <select id="ciclo" name="ciclo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @for($i = 1; $i <= 6; $i++)
                                        <option value="{{ $i }}" {{ old('ciclo') == $i ? 'selected' : '' }}>Ciclo {{ $i }}</option>
                                    @endfor
                                </select>
                                <x-input-error :messages="$errors->get('ciclo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="tipo" value="Tipo de Matrícula *" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="prematricula" {{ old('tipo') == 'prematricula' ? 'selected' : '' }}>Prematrícula</option>
                                    <option value="matricula" {{ old('tipo') == 'matricula' ? 'selected' : '' }}>Matrícula Oficial</option>
                                </select>
                                <x-input-error :messages="$errors->get('tipo')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 mb-4 pt-4 border-t">Unidades Didácticas</h3>
                        
                        <div id="unidades-container" class="space-y-2 mb-6">
                            <p class="text-gray-500">Seleccione un estudiante y ciclo para ver las unidades disponibles.</p>
                        </div>

                        <x-input-error :messages="$errors->get('unidades')" class="mt-2" />

                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.matriculas.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button id="btn-submit" disabled>
                                {{ __('Registrar Matrícula') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loadUnidades() {
            const estudianteId = document.getElementById('estudiante_id').value;
            const ciclo = document.getElementById('ciclo').value;
            const container = document.getElementById('unidades-container');
            const btnSubmit = document.getElementById('btn-submit');

            if (!estudianteId || !ciclo) {
                container.innerHTML = '<p class="text-gray-500">Seleccione un estudiante y ciclo para ver las unidades disponibles.</p>';
                btnSubmit.disabled = true;
                return;
            }

            container.innerHTML = '<p class="text-gray-500">Cargando unidades...</p>';

            fetch(`{{ route('admin.matriculas.get-unidades') }}?estudiante_id=${estudianteId}&ciclo=${ciclo}`)
                .then(response => response.json())
                .then(unidades => {
                    if (unidades.length === 0) {
                        container.innerHTML = '<p class="text-yellow-600">No hay unidades didácticas para este ciclo.</p>';
                        btnSubmit.disabled = true;
                        return;
                    }

                    let html = '';
                    unidades.forEach(unidad => {
                        html += `
                            <label class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer">
                                <input type="checkbox" name="unidades[]" value="${unidad.id}" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" checked>
                                <div class="ml-3">
                                    <span class="font-medium text-gray-900">${unidad.nombre}</span>
                                    <span class="text-sm text-gray-500 ml-2">(${unidad.codigo})</span>
                                    <span class="text-sm text-gray-500 ml-2">- ${unidad.creditos} créditos, ${unidad.horas_semanales} hrs/sem</span>
                                </div>
                            </label>
                        `;
                    });
                    container.innerHTML = html;
                    btnSubmit.disabled = false;
                });
        }

        document.getElementById('estudiante_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const ciclo = selected.dataset.ciclo;
            if (ciclo) {
                document.getElementById('ciclo').value = ciclo;
            }
            loadUnidades();
        });

        document.getElementById('ciclo').addEventListener('change', loadUnidades);
    </script>
</x-app-layout>
