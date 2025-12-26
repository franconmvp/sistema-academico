<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Usuario') }}</h2></x-slot>
    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-primary-50 border-l-4 border-primary-500 p-4 mb-6">
                <p class="text-sm text-primary-700">
                    <strong>Rol:</strong> 
                    <span class="px-2 py-0.5 text-xs rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'docente' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ ucfirst($user->role) }}
                    </span>
                    @if($user->personal)
                        <br><span class="text-xs">Vinculado a: {{ $user->personal->nombre_completo }}</span>
                    @elseif($user->estudiante)
                        <br><span class="text-xs">Vinculado a: {{ $user->estudiante->nombre_completo }} (Estudiante)</span>
                    @endif
                </p>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" value="Nombre *" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="email" value="Email *" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password" value="Nueva Contraseña (dejar vacío para mantener)" />
                                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" value="Confirmar Nueva Contraseña" />
                                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-primary-600 shadow-sm focus:ring-primary-500" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-gray-600">Usuario activo</span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6 pt-6 border-t">
                            <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Cancelar</a>
                            <x-primary-button>{{ __('Actualizar Usuario') }}</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
