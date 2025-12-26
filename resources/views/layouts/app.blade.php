<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Sistema Académico') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gray-100 flex flex-col">
            <!-- Top Header Bar -->
            <header class="bg-primary-900 shadow-lg fixed w-full z-30 top-0">
                <div class="flex items-center justify-between h-16 px-4">
                    <!-- Left: Hamburger + Logo -->
                    <div class="flex items-center">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-300 hover:text-white focus:outline-none lg:hidden mr-3">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                        <a href="{{ route('dashboard') }}" class="flex items-center">
                            <x-application-logo class="h-8 w-auto fill-current text-white" />
                            <span class="ml-3 text-white font-bold text-lg">Sistema Académico</span>
                        </a>
                    </div>

                    <!-- Right: User Dropdown -->
                    <div class="flex items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="flex items-center px-3 py-2 text-sm font-medium text-gray-300 hover:text-white focus:outline-none transition">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-secondary-500 flex items-center justify-center text-primary-900 font-bold text-sm mr-2">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <div class="hidden md:block text-left">
                                            <div class="text-sm font-medium text-white">{{ Auth::user()->name }}</div>
                                            <div class="text-xs text-gray-400">{{ ucfirst(Auth::user()->role) }}</div>
                                        </div>
                                        <svg class="ml-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <div class="px-4 py-2 border-b">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Mi Perfil') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Cerrar Sesión') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </header>

            <div class="flex flex-1 pt-16">
                <!-- Sidebar Overlay (Mobile) -->
                <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

                <!-- Sidebar -->
                <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-20 w-64 bg-white shadow-lg transform transition-transform duration-300 ease-in-out lg:translate-x-0 pt-16 lg:pt-16">
                    <div class="h-full overflow-y-auto py-4">
                        @include('layouts.sidebar')
                    </div>
                </aside>

                <!-- Main Content -->
                <div class="flex-1 lg:ml-64 min-h-screen">
                    <!-- Page Heading -->
                    @isset($header)
                        <header class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset

                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <main class="p-4">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
