<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Crear Usuario') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <p class="text-sm text-primary-700">
                    <strong>Nota:</strong> Los usuarios se crean a partir del personal registrado.
                    <br>• Personal de tipo <strong>Docente</strong> → Rol <strong>Docente</strong>
                    <br>• Personal de tipo <strong>Administrativo/Jerárquico</strong> → Rol <strong>Admin</strong>
                    <br>• La contraseña inicial será el <strong>DNI</strong> del personal.
                </p>
            </div>

            @if($personal->isEmpty())
                <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
                    <p class="text-sm text-yellow-700">
                        No hay personal sin cuenta de usuario. Primero debe 
                        <a href="{{ route('admin.personal.create') }}" class="underline font-medium">registrar personal</a>.
                    </p>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="personal_id" value="Seleccionar Personal *" />
                                <select id="personal_id" name="personal_id" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required {{ $personal->isEmpty() ? 'disabled' : '' }}>
                                    <option value="">Seleccione un personal...</option>
                                    @foreach($personal as $p)
                                        <option value="{{ $p->id }}" data-tipo="{{ $p->tipo }}" {{ old('personal_id') == $p->id ? 'selected' : '' }}>
                                            {{ $p->nombre_completo }} ({{ ucfirst($p->tipo) }}) - DNI: {{ $p->dni }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('personal_id')" class="mt-2" />
                            </div>

                            <div id="rol-info" class="hidden bg-gray-50 p-3 rounded-md">
                                <p class="text-sm text-gray-700">Rol asignado: <strong id="rol-asignado"></strong></p>
                            </div>

                            <div>
                                <x-input-label for="email" value="Email de Acceso *" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required placeholder="usuario@instituto.edu.pe" />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button {{ $personal->isEmpty() ? 'disabled' : '' }}>{{ __('Crear Usuario') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">¿Crear usuario para estudiante?</h3>
                <p class="text-sm text-gray-600">Los usuarios de estudiantes se crean desde el módulo de 
                    <a href="{{ route('admin.estudiantes.index') }}" class="text-primary-600 hover:underline">Estudiantes</a> 
                    (en el registro o edición del estudiante).
                </p>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('personal_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const tipo = selected.dataset.tipo;
            const rolInfo = document.getElementById('rol-info');
            const rolAsignado = document.getElementById('rol-asignado');
            
            if (tipo) {
                rolInfo.classList.remove('hidden');
                rolAsignado.textContent = tipo === 'docente' ? 'Docente' : 'Administrador';
            } else {
                rolInfo.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>
