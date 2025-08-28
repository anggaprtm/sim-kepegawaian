<!-- Mobile overlay -->
<div x-show="open" class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity sm:hidden" @click="open = false"></div>

<!-- Sidebar -->
<div :class="{
        'translate-x-0 ease-out': open,
        '-translate-x-full ease-in': !open,
        'sm:w-64': !isSidebarMinimized,
        'sm:w-20': isSidebarMinimized
     }"
     class="fixed inset-y-0 left-0 z-30 w-64 bg-gray-800 text-white transform transition-all duration-300 sm:translate-x-0 flex flex-col">

    <!-- Logo -->
    <div class="flex items-center h-16 bg-gray-900 flex-shrink-0 px-4">
        <a href="{{ route('dashboard') }}" class="flex items-center w-full" :class="{'justify-center': isSidebarMinimized}">
            <img src="https://placehold.co/40x40/FFFFFF/334155?text=SIK" alt="Logo" class="rounded-full flex-shrink-0">
            <span class="font-bold text-lg ml-2 overflow-hidden transition-all duration-200" :class="{'w-0 opacity-0': isSidebarMinimized, 'w-full opacity-100': !isSidebarMinimized}">SIMPEG</span>
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-4 flex-1 overflow-y-auto">
        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <x-slot name="icon"><i class="fa-solid fa-house fa-fw fa-lg"></i></x-slot>
            <span x-show="!isSidebarMinimized" class="mx-3">Dashboard</span>
        </x-nav-link>

        <!-- Menu Superadmin -->
        @role('superadmin')
            <div class="mt-4 px-4 mb-2 text-gray-400 text-xs uppercase tracking-wider" x-show="!isSidebarMinimized">Admin</div>
            <x-nav-link :href="route('admin.dosen.index')" :active="request()->routeIs('admin.dosen.*')">
                <x-slot name="icon"><i class="fa-solid fa-user-tie fa-fw fa-lg"></i></x-slot>
                <span x-show="!isSidebarMinimized" class="mx-3">Manajemen Dosen</span>
            </x-nav-link>
            <x-nav-link :href="route('admin.tendik.index')" :active="request()->routeIs('admin.tendik.*')">
                <x-slot name="icon"><i class="fa-solid fa-user-gear fa-fw fa-lg"></i></x-slot>
                <span x-show="!isSidebarMinimized" class="mx-3">Manajemen Tendik</span>
            </x-nav-link>
        @endrole

        <!-- Menu Dosen -->
        @role('dosen')
             <div class="mt-4 px-4 mb-2 text-gray-400 text-xs uppercase tracking-wider" x-show="!isSidebarMinimized">Layanan Dosen</div>
            <x-nav-link :href="route('dosen.promotion.index')" :active="request()->routeIs('dosen.promotion.*')">
                 <x-slot name="icon"><i class="fa-solid fa-arrow-trend-up fa-fw fa-lg"></i></x-slot>
                <span x-show="!isSidebarMinimized" class="mx-3">Kenaikan Pangkat</span>
            </x-nav-link>
        @endrole

        <!-- Menu Tendik (Modular) -->
        @role('tendik')
            <div class="mt-4 px-4 mb-2 text-gray-400 text-xs uppercase tracking-wider" x-show="!isSidebarMinimized">Modul Layanan</div>
            <div x-data="{ open: {{ request()->routeIs('tendik.promotion.*', 'tendik.pak_session.*', 'tendik.bpf_session.*', 'tendik.finalization.*') ? 'true' : 'false' }} }">
                <button @click="open = !open" class="w-full flex justify-between items-center px-4 py-2 text-left text-sm font-medium text-gray-300 hover:bg-gray-700 focus:outline-none">
                    <div class="flex items-center">
                        <i class="fa-solid fa-file-signature fa-fw fa-lg w-6 text-center"></i>
                        <span x-show="!isSidebarMinimized" class="mx-3">Kenaikan Pangkat</span>
                    </div>
                    <i x-show="!isSidebarMinimized" class="fa-solid fa-chevron-down text-xs transform transition-transform" :class="{'rotate-180': open}"></i>
                </button>
                <div x-show="open" class="bg-gray-700" x-transition>
                    <x-nav-link :href="route('tendik.promotion.index')" :active="request()->routeIs('tendik.promotion.*')">
                        <x-slot name="icon"><i class="fa-solid fa-list-check fa-fw fa-lg"></i></x-slot>
                        <span x-show="!isSidebarMinimized" class="mx-3">Daftar Pengajuan</span>
                    </x-nav-link>
                    <x-nav-link :href="route('tendik.pak_session.index')" :active="request()->routeIs('tendik.pak_session.*')">
                        <x-slot name="icon"><i class="fa-solid fa-users-viewfinder fa-fw fa-lg"></i></x-slot>
                        <span x-show="!isSidebarMinimized" class="mx-3">Sidang PAK</span>
                    </x-nav-link>
                     <x-nav-link :href="route('tendik.bpf_session.index')" :active="request()->routeIs('tendik.bpf_session.*')">
                        <x-slot name="icon"><i class="fa-solid fa-landmark fa-fw fa-lg"></i></x-slot>
                        <span x-show="!isSidebarMinimized" class="mx-3">Sidang BPF</span>
                    </x-nav-link>
                    <x-nav-link :href="route('tendik.finalization.index')" :active="request()->routeIs('tendik.finalization.*')">
                        <x-slot name="icon"><i class="fa-solid fa-award fa-fw fa-lg"></i></x-slot>
                        <span x-show="!isSidebarMinimized" class="mx-3">Finalisasi & SK</span>
                    </x-nav-link>
                </div>
            </div>
        @endrole
    </nav>
</div>