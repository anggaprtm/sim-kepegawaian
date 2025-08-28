<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pilih Asesor untuk: {{ $submission->dosen->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tendik.assessor.store', $submission->id) }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="assessor_ids" value="Pilih 1 atau 2 Asesor" />
                                <select name="assessor_ids[]" id="assessor_ids" multiple class="block mt-1 w-full border-gray-300 rounded-md shadow-sm" size="5">
                                    @foreach($assessors as $assessor)
                                        <option value="{{ $assessor->id }}">{{ $assessor->name }} ({{ $assessor->nip }})</option>
                                    @endforeach
                                </select>
                                <small class="text-gray-500">Gunakan Ctrl/Cmd + Klik untuk memilih lebih dari satu.</small>
                                @error('assessor_ids')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="start_date" value="Tanggal Mulai Penilaian" />
                                    <x-text-input type="date" name="start_date" id="start_date" class="mt-1 block w-full" required />
                                    @error('start_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <x-input-label for="end_date" value="Tanggal Selesai Penilaian" />
                                    <x-text-input type="date" name="end_date" id="end_date" class="mt-1 block w-full" required />
                                    @error('end_date')<p class="text-sm text-red-500 mt-1">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            <div class="flex items-center justify-end">
                                <x-primary-button>Simpan dan Buat Surat Tugas</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>