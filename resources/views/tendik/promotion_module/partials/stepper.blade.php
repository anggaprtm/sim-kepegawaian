<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Proses Pengajuan</h3>
        <ol class="relative border-l border-gray-200">
            @forelse($submission->logs as $log)
            <li class="mb-10 ml-6">
                <span class="absolute flex items-center justify-center w-6 h-6 bg-blue-100 rounded-full -left-3 ring-8 ring-white">
                    <svg class="w-3 h-3 text-blue-800" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path></svg>
                </span>
                <h4 class="flex items-center mb-1 text-base font-semibold text-gray-900">
                    {{ Str::title(str_replace('_', ' ', $log->status_sekarang)) }}
                    @if($loop->first)
                    <span class="bg-blue-100 text-blue-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded ml-3">Terkini</span>
                    @endif
                </h4>
                <time class="block mb-2 text-sm font-normal leading-none text-gray-400">
                    Diproses pada {{ $log->created_at->translatedFormat('l, d F Y \p\u\k\u\l H:i') }} oleh {{ $log->processor->name ?? 'Sistem' }}
                </time>
                @if($log->catatan)
                <p class="mb-4 text-sm font-normal text-gray-500 p-3 bg-gray-50 rounded-md border">
                    <strong>Catatan:</strong> {{ $log->catatan }}
                </p>
                @endif
            </li>
            @empty
            <li class="ml-6">
                <p class="text-sm text-gray-500">Belum ada riwayat proses.</p>
            </li>
            @endforelse
        </ol>
    </div>
</div>
