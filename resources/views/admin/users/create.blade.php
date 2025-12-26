<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Crear Usuario') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" value="Nombre *" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" value="Email *" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password" value="Contraseña *" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" value="Confirmar Contraseña *" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="role" value="Rol *" />
                                <select id="role" name="role" class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm" required>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrador</option>
                                    <option value="docente" {{ old('role') == 'docente' ? 'selected' : '' }}>Docente</option>
                                    <option value="estudiante" {{ old('role') == 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                                </select>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Usuario activo</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Crear Usuario') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
