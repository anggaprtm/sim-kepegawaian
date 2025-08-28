<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div x-data="{ isSidebarMinimized: false, open: false }" class="min-h-screen bg-gray-100">
            <div class="flex min-h-screen">
                <!-- Sidebar -->
                @include('layouts.sidebar')

                <!-- Main content -->
                <div class="flex-1 flex flex-col transition-all duration-300" :class="{'sm:ml-20': isSidebarMinimized, 'sm:ml-64': !isSidebarMinimized}">
                    <!-- Top bar -->
                    <header class="bg-white shadow-sm">
                        <div class="mx-auto py-4 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                            <!-- Hamburger (untuk mobile) & Toggle (untuk desktop) -->
                            <div class="flex items-center">
                                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none sm:hidden">
                                    <i class="fa-solid fa-bars text-xl"></i>
                                </button>
                                <button @click="isSidebarMinimized = !isSidebarMinimized" class="hidden sm:inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                                    <i class="fa-solid fa-bars text-xl"></i>
                                </button>
                            </div>

                            <!-- Settings Dropdown -->
                            <div class="flex items-center">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <div>{{ Auth::user()->name }}</div>
                                            <div class="ms-1"><i class="fa-solid fa-chevron-down text-xs"></i></div>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('profile.edit')">{{ __('Profile') }}</x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        </div>
                    </header>

                    <!-- Page Heading -->
                    @if (isset($header))
                        <div class="bg-white shadow">
                            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </div>
                    @endif

                    <!-- Page Content -->
                    <main class="flex-1">
                        {{ $slot }}
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>