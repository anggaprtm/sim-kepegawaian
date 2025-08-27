<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Pengajuan Kenaikan Jabatan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($activeSubmission)
                        <div class="p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
                          Anda memiliki pengajuan yang masih aktif. Anda tidak dapat membuat pengajuan baru hingga pengajuan sebelumnya selesai diproses.
                        </div>
                    @elseif($nextJabatan)
                        <p class="mb-2">Jabatan Fungsional Anda saat ini: <strong>{{ $currentJabatan ?? 'Belum Memiliki Jabatan' }}</strong></p>
                        <p class="mb-4">Anda akan mengajukan kenaikan jabatan ke: <strong>{{ $nextJabatan }}</strong></p>
                        <form action="{{ route('dosen.promotion.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="jabatan_tujuan" value="{{ $nextJabatan }}">
                            <x-primary-button>Mulai Pengajuan</x-primary-button>
                        </form>
                    @else
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                          Selamat, Anda telah mencapai jenjang jabatan fungsional tertinggi!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>