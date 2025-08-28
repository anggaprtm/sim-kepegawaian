<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Jadwalkan Sidang PAK Baru') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tendik.pak_session.store') }}" method="POST">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <x-input-label for="nama_sesi" value="Nama Sesi / Batch" />
                                <x-text-input id="nama_sesi" name="nama_sesi" type="text" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_sidang" value="Tanggal Sidang" />
                                <x-text-input id="tanggal_sidang" name="tanggal_sidang" type="date" class="mt-1 block w-full" required />
                            </div>
                            <div>
                                <x-input-label value="Pilih Dosen untuk Dijadwalkan" />
                                <div class="mt-2 border rounded-md max-h-60 overflow-y-auto">
                                    @forelse($availableSubmissions as $submission)
                                    <label class="flex items-center p-3 border-b">
                                        <input type="checkbox" name="submission_ids[]" value="{{ $submission->id }}" class="rounded">
                                        <span class="ml-3">{{ $submission->dosen->name }} (Tujuan: {{ $submission->jabatan_fungsional_tujuan }})</span>
                                    </label>
                                    @empty
                                    <p class="p-3 text-gray-500">Tidak ada pengajuan yang siap untuk dijadwalkan.</p>
                                    @endforelse
                                </div>
                            </div>
                            <div class="flex items-center justify-end">
                                <x-primary-button>Jadwalkan Sidang</x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
