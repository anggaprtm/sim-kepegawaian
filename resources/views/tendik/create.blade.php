<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Data Tendik</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tendik.store') }}">
                        @csrf
                        @include('tendik.partials.form-fields')
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tendik.index') }}" class="text-sm text-gray-600 mr-4">Batal</a>
                            <x-primary-button>Simpan</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>