<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Nueva Asignación Docente') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.asignaciones.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="personal_id" value="Docente *" />
                                <select id="personal_id" name="personal_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione un docente...</option>
                                    @foreach($docentes as $docente)
                                        <option value="{{ $docente->id }}" {{ old('personal_id') == $docente->id ? 'selected' : '' }}>{{ $docente->nombre_completo }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('personal_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="unidad_didactica_id" value="Unidad Didáctica *" />
                                <select id="unidad_didactica_id" name="unidad_didactica_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($unidades as $unidad)
                                        <option value="{{ $unidad->id }}" {{ old('unidad_didactica_id') == $unidad->id ? 'selected' : '' }}>{{ $unidad->planEstudio->programaEstudio->nombre }} - {{ $unidad->nombre }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('unidad_didactica_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="periodo_lectivo_id" value="Período Lectivo *" />
                                <select id="periodo_lectivo_id" name="periodo_lectivo_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    @foreach($periodos as $periodo)
                                        <option value="{{ $periodo->id }}" {{ old('periodo_lectivo_id', $periodos->firstWhere('activo', true)?->id) == $periodo->id ? 'selected' : '' }}>{{ $periodo->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="turno_id" value="Turno *" />
                                <select id="turno_id" name="turno_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione...</option>
                                    @foreach($turnos as $turno)
                                        <option value="{{ $turno->id }}" {{ old('turno_id') == $turno->id ? 'selected' : '' }}>{{ $turno->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <x-input-label for="aula" value="Aula" />
                                <x-text-input id="aula" name="aula" type="text" class="mt-1 block w-full" :value="old('aula')" placeholder="Ej: A-101" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.asignaciones.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Crear Asignación') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
