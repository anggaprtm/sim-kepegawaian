<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Data Dosen Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                     <form method="POST" action="{{ route('admin.dosen.store') }}"> {{-- PERBAIKAN DI SINI --}}
                        @csrf
                        @include('dosen.partials.form-fields')
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dosen.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4"> {{-- PERBAIKAN DI SINI --}}
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Simpan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
