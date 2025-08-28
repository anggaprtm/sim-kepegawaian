<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Data Tendik: {{ $tendik->name }}</h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- PERBAIKAN DI SINI --}}
                    <form method="POST" action="{{ route('admin.tendik.update', $tendik->id) }}">
                        @csrf @method('PUT')
                        @include('tendik.partials.form-fields', ['tendik' => $tendik])
                        <div class="flex items-center justify-end mt-4">
                            {{-- PERBAIKAN DI SINI --}}
                            <a href="{{ route('admin.tendik.index') }}" class="text-sm text-gray-600 mr-4">Batal</a>
                            <x-primary-button>Update</x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
