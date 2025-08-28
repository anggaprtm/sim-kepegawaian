<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Finalisasi Pengajuan ke Universitas') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Bagian Pengajuan ke Universitas -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">1. Pengajuan ke Universitas</h3>
                    <form action="{{ route('tendik.finalization.generate_letter') }}" method="POST">
                        @csrf
                        <p class="text-sm text-gray-600 mb-2">Pilih dosen yang akan diajukan secara kolektif ke Universitas.</p>
                        <div class="border rounded-md max-h-60 overflow-y-auto mb-4">
                            @forelse($forUniversity as $submission)
                            <label class="flex items-center p-3 border-b">
                                <input type="checkbox" name="submission_ids[]" value="{{ $submission->id }}" class="rounded">
                                <span class="ml-3">{{ $submission->dosen->name }} (Tujuan: {{ $submission->jabatan_fungsional_tujuan }})</span>
                            </label>
                            @empty
                            <p class="p-3 text-gray-500">Tidak ada pengajuan yang siap diajukan ke Universitas.</p>
                            @endforelse
                        </div>
                        <x-primary-button>Buat Surat Pengantar</x-primary-button>
                    </form>
                </div>
            </div>

            <!-- Bagian Input Hasil Akhir -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">2. Input Hasil dari Universitas & SK</h3>
                    <div class="space-y-4">
                        @forelse($pendingResult as $submission)
                        <div class="p-4 border rounded-md">
                            <p class="font-semibold">{{ $submission->dosen->name }}</p>
                            <form action="{{ route('tendik.finalization.process', $submission->id) }}" method="POST" enctype="multipart/form-data" class="mt-2 space-y-3">
                                @csrf
                                <div class="flex items-center space-x-4">
                                    <label><input type="radio" name="result" value="lulus" required> Lulus (SK Terbit)</label>
                                    <label><input type="radio" name="result" value="gagal"> Gagal</label>
                                </div>
                                <div>
                                    <x-input-label for="sk_file_{{ $submission->id }}" value="Unggah File SK (jika lulus)" />
                                    <input type="file" name="sk_file" id="sk_file_{{ $submission->id }}" class="mt-1 text-sm">
                                </div>
                                <div>
                                    <x-input-label for="catatan_penolakan_{{ $submission->id }}" value="Catatan (jika gagal)" />
                                    <textarea name="catatan_penolakan" id="catatan_penolakan_{{ $submission->id }}" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
                                </div>
                                <x-primary-button>Simpan Hasil</x-primary-button>
                            </form>
                        </div>
                        @empty
                        <p class="text-gray-500">Tidak ada pengajuan yang menunggu hasil dari Universitas.</p>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>