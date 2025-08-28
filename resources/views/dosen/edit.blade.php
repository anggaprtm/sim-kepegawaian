<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Dosen: ') . $dosen->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.dosen.update', $dosen->id) }}"> {{-- PERBAIKAN DI SINI --}}
                        @csrf
                        @method('PUT')
                        @include('dosen.partials.form-fields', ['dosen' => $dosen])
                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dosen.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4"> {{-- PERBAIKAN DI SINI --}}
                                Batal
                            </a>
                            <x-primary-button>
                                {{ __('Update') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
