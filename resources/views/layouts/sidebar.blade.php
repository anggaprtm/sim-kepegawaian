<div :class="{'block': open, 'hidden': ! open}" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity sm:hidden" @click="open = false"></div>
<div :class="{'translate-x-0 ease-out': open, '-translate-x-full ease-in': ! open}" class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-transform duration-300 sm:translate-x-0 sm:relative sm:w-64 flex-shrink-0">
    <!-- Logo -->
    <div class="flex items-center justify-center h-16 bg-gray-900">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="block h-9 w-auto fill-current text-white" />
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-4">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            {{ __('Dashboard') }}
        </x-nav-link>

        <!-- Menu Superadmin -->
        @role('superadmin')
            <div class="mt-4 px-4 text-gray-400 text-xs uppercase tracking-wider">Admin</div>
            <x-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')">
                {{ __('Manajemen Dosen') }}
            </x-nav-link>
            <x-nav-link :href="route('admin.tendik.index')" :active="request()->routeIs('admin.tendik.*')">
                {{ __('Manajemen Tendik') }}
            </x-nav-link>
        @endrole

        <!-- Menu Dosen -->
        @role('dosen')
            <div class="mt-4 px-4 text-gray-400 text-xs uppercase tracking-wider">Layanan Dosen</div>
            <x-nav-link :href="route('dosen.promotion.index')" :active="request()->routeIs('dosen.promotion.*')">
                {{ __('Kenaikan Pangkat') }}
            </x-nav-link>
        @endrole

        <!-- Menu Tendik (Modular) -->
        @role('tendik')
            <div class="mt-4 px-4 text-gray-400 text-xs uppercase tracking-wider">Modul Layanan</div>
            <div x-data="{ open: {{ request()->routeIs('tendik.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-left text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none">
                    <span>Kenaikan Pangkat</span>
                    <svg class="h-5 w-5 transform transition-transform" :class="{'rotate-180': open}" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
                <div x-show="open" class="pl-4">
                    <x-nav-link :href="route('tendik.verification.index')" :active="request()->routeIs('tendik.verification.*')">
                        {{ __('Daftar Pengajuan') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tendik.pak_session.index')" :active="request()->routeIs('tendik.pak_session.*')">
                        {{ __('Sidang PAK') }}
                    </x-nav-link>
                     <x-nav-link :href="route('tendik.bpf_session.index')" :active="request()->routeIs('tendik.bpf_session.*')">
                        {{ __('Sidang BPF') }}
                    </x-nav-link>
                    <x-nav-link :href="route('tendik.finalization.index')" :active="request()->routeIs('tendik.finalization.*')">
                        {{ __('Finalisasi & SK') }}
                    </x-nav-link>
                </div>
            </div>
        @endrole
    </nav>
</div>
