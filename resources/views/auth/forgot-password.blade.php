<x-guest-layout>
    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-primary-900">Recuperar Contraseña</h2>
        <p class="text-sm text-gray-600 mt-2">
            ¿Olvidaste tu contraseña? No hay problema. Ingresa tu correo electrónico y te enviaremos un enlace para restablecerla.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Correo Electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus placeholder="usuario@instituto.edu.pe" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a href="{{ route('login') }}" class="text-sm text-primary-600 hover:text-primary-800 hover:underline">
                Volver al inicio de sesión
            </a>
            <x-primary-button>
                Enviar Enlace
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
