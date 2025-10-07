{{-- resources/views/tendik/surat_tugas/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Surat Tugas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium">Daftar Surat Tugas</h3>
                        <a href="{{ route('tendik.surat_tugas.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 ...">
                            + Buat Surat Baru
                        </a>
                    </div>
                    {{-- Tampilkan tabel surat tugas di sini --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>