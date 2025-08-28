<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Dosen') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-2">Selamat datang, {{ Auth::user()->name }}!</h3>
                    
                    @if($mySubmission)
                        <p class="mb-4">Berikut adalah status pengajuan kenaikan pangkat terakhir Anda:</p>
                        <div class="border rounded-lg p-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Pengajuan ke {{ $mySubmission->jabatan_fungsional_tujuan }}</p>
                                <p class="text-xl font-semibold">{{ Str::title(str_replace('_', ' ', $mySubmission->status)) }}</p>
                            </div>
                            <div class="flex items-center space-x-4 flex-shrink-0">
                                @if($mySubmission->status == 'sk_terbit' && $mySubmission->sk_file_path)
                                    <a href="{{ asset('storage/' . $mySubmission->sk_file_path) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 active:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Unduh SK
                                    </a>
                                @endif
                                <a href="{{ route('dosen.promotion.show', $mySubmission->id) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    @else
                        <p>Anda belum memiliki riwayat pengajuan kenaikan pangkat. Silakan mulai pengajuan baru melalui menu di samping.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>