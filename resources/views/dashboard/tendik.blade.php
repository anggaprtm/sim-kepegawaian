<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Tenaga Kependidikan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card Perlu Verifikasi -->
                <a href="{{ route('tendik.promotion.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between hover:bg-gray-50 transition">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Perlu Verifikasi Berkas</h3>
                        <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $stats['perlu_verifikasi'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Pengajuan</p>
                </a>

                <!-- Card Perlu Asesor -->
                <a href="{{ route('tendik.promotion.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between hover:bg-gray-50 transition">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Perlu Penugasan Asesor</h3>
                        <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $stats['perlu_asesor'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Pengajuan</p>
                </a>

                <!-- Card Perlu Sidang PAK -->
                <a href="{{ route('tendik.pak_session.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between hover:bg-gray-50 transition">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Siap Sidang PAK</h3>
                        <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $stats['perlu_sidang_pak'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Pengajuan</p>
                </a>

                <!-- Card Perlu Sidang BPF -->
                <a href="{{ route('tendik.bpf_session.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col justify-between hover:bg-gray-50 transition">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500">Siap Sidang BPF</h3>
                        <p class="mt-1 text-3xl font-semibold text-indigo-600">{{ $stats['perlu_sidang_bpf'] }}</p>
                    </div>
                    <p class="text-sm text-gray-500 mt-4">Pengajuan</p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
