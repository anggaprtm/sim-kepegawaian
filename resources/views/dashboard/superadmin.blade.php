<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Superadmin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card Total Dosen -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">Total Dosen</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_dosen'] }}</p>
                </div>
                <!-- Card Total Tendik -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">Total Tendik</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_tendik'] }}</p>
                </div>
                <!-- Card Total Pengajuan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-sm font-medium text-gray-500">Total Pengajuan Diproses</h3>
                    <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $stats['total_pengajuan'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>