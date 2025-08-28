<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Pengajuan: {{ $submission->dosen->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Di sini kita akan menambahkan Stepper Riwayat di Tahap 3 --}}
            @include('tendik.promotion_module.partials.stepper')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Tindakan Selanjutnya: 
                        <span class="font-bold text-indigo-600">{{ Str::title(str_replace('_', ' ', $submission->status)) }}</span>
                    </h3>

                    {{-- Bagian ini akan secara dinamis menampilkan form yang sesuai --}}
                    @if($submission->status == 'diajukan_verifikasi')
                        @include('tendik.promotion_module.partials.verification-form')
                    @elseif($submission->status == 'berkas_disetujui')
                        @include('tendik.promotion_module.partials.assessor-form')
                    @else
                        <p class="text-gray-600">Tidak ada tindakan yang diperlukan pada tahap ini. Menunggu proses selanjutnya.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
