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
                    @elseif(!empty($possibleRanks))
                        <form action="{{ route('dosen.promotion.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <p class="mb-2">Jabatan Fungsional Anda saat ini: <strong>{{ $currentJabatan ?? 'Belum Memiliki Jabatan' }}</strong></p>
                                </div>
                                <div>
                                    <x-input-label for="jabatan_tujuan" :value="__('Pilih Jabatan Fungsional Tujuan')" />
                                    <select name="jabatan_tujuan" id="jabatan_tujuan" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                        <option value="" disabled selected>-- Pilih Jabatan --</option>
                                        @foreach($possibleRanks as $rank)
                                            <option value="{{ $rank }}">{{ $rank }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex justify-end">
                                    <x-primary-button>Mulai Pengajuan</x-primary-button>
                                </div>
                            </div>
                        </form>
                    @else
                        <div class="p-4 mb-4 text-sm text-blue-800 rounded-lg bg-blue-50" role="alert">
                          Selamat, Anda telah mencapai jenjang jabatan fungsional tertinggi atau tidak ada jenjang selanjutnya yang tersedia.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>