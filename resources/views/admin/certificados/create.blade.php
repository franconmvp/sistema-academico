<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Emitir Certificado') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.certificados.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="estudiante_id" value="Estudiante *" />
                                <select id="estudiante_id" name="estudiante_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="">Seleccione un estudiante...</option>
                                    @foreach($estudiantes as $estudiante)
                                        <option value="{{ $estudiante->id }}" {{ old('estudiante_id') == $estudiante->id ? 'selected' : '' }}>
                                            {{ $estudiante->codigo_estudiante }} - {{ $estudiante->nombre_completo }} ({{ $estudiante->programaEstudio->nombre }})
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('estudiante_id')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="tipo" value="Tipo de Documento *" />
                                <select id="tipo" name="tipo" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="certificado_estudios" {{ old('tipo') == 'certificado_estudios' ? 'selected' : '' }}>Certificado de Estudios</option>
                                    <option value="certificado_modular" {{ old('tipo') == 'certificado_modular' ? 'selected' : '' }}>Certificado Modular</option>
                                    <option value="grado" {{ old('tipo') == 'grado' ? 'selected' : '' }}>Grado</option>
                                    <option value="titulo" {{ old('tipo') == 'titulo' ? 'selected' : '' }}>Título</option>
                                </select>
                            </div>
                            <div>
                                <x-input-label for="descripcion" value="Descripción / Observaciones" />
                                <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.certificados.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Emitir Certificado') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
