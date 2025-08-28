<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Sidang PAK: {{ $session->nama_sesi }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tombol Aksi -->
            <div class="mb-4 flex space-x-2">
                <a href="{{ route('tendik.pak_session.invitation', $session->id) }}" class="px-4 py-2 bg-blue-500 text-white rounded-md">Unduh Undangan</a>
                {{-- Tambah tombol presensi & notula --}}
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('tendik.pak_session.process', $session->id) }}" method="POST">
                        @csrf
                        <h3 class="text-lg font-medium mb-4">Daftar Peserta Sidang</h3>
                        <div class="space-y-3 mb-6">
                            @foreach($session->submissions as $submission)
                            <div class="p-3 border rounded-md flex justify-between items-center">
                                <span>{{ $submission->dosen->name }}</span>
                                @if($session->status == 'dijadwalkan')
                                <div class="flex space-x-4">
                                    <label><input type="radio" name="results[{{ $submission->id }}]" value="lulus" required> Lulus</label>
                                    <label><input type="radio" name="results[{{ $submission->id }}]" value="tidak_lulus"> Tidak Lulus</label>
                                </div>
                                @else
                                <span class="font-semibold">{{ Str::title(str_replace('_', ' ', $submission->status)) }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @if($session->status == 'dijadwalkan')
                        <div>
                            <x-input-label for="notula" value="Notula Sidang" />
                            <textarea name="notula" id="notula" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button>Simpan Hasil Sidang</x-primary-button>
                        </div>
                        @else
                        <div>
                            <h4 class="font-semibold">Notula Sidang:</h4>
                            <div class="mt-2 p-3 border bg-gray-50 rounded-md whitespace-pre-wrap">{{ $session->notula }}</div>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>