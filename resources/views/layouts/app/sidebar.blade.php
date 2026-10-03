<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white dark:bg-zinc-800">

    <flux:sidebar sticky collapsible="mobile"
        class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">

        <flux:sidebar.header>
            <x-app-logo :sidebar="true" href="{{ route('admin.dashboard') }}" wire:navigate />
            <flux:sidebar.collapse class="lg:hidden" />
        </flux:sidebar.header>

        <flux:sidebar.nav>

            {{-- DASHBOARD --}}
            <flux:sidebar.group :heading="__('Dashboard')" class="grid">
                <flux:sidebar.item icon="home" :href="route('admin.dashboard')"
                    :current="request()->routeIs('admin.dashboard')" wire:navigate>
                    Dashboard
                </flux:sidebar.item>
            </flux:sidebar.group>

            {{-- MASTER DATA --}}
            <flux:sidebar.group :heading="__('Master Data')" class="grid">
                <flux:sidebar.item icon="cube" :href="route('admin.alat')"
                    :current="request()->routeIs('admin.alat*')" wire:navigate>
                    Alat
                </flux:sidebar.item>

                <flux:sidebar.item icon="beaker" :href="route('admin.bahan')"
                    :current="request()->routeIs('admin.bahan*')" wire:navigate>
                    Bahan
                </flux:sidebar.item>

                <flux:sidebar.item icon="tag" :href="route('admin.kategori')"
                    :current="request()->routeIs('admin.kategori*')" wire:navigate>
                    Kategori
                </flux:sidebar.item>

                <flux:sidebar.item icon="scale" :href="route('admin.satuan')"
                    :current="request()->routeIs('admin.satuan*')" wire:navigate>
                    Satuan
                </flux:sidebar.item>
                <flux:sidebar.item icon="adjustments-horizontal" :href="route('admin.ukuran')"
                    :current="request()->routeIs('admin.ukuran*')" wire:navigate>
                    Ukuran
                </flux:sidebar.item>

                <flux:sidebar.item icon="users" :href="route('admin.mahasiswa')"
                    :current="request()->routeIs('admin.mahasiswa*')" wire:navigate>
                    Mahasiswa
                </flux:sidebar.item>
            </flux:sidebar.group>

            {{-- TRANSAKSI --}}
            <flux:sidebar.group :heading="__('Transaksi')" class="grid">
                <flux:sidebar.item icon="inbox-arrow-down" :href="route('admin.pengajuan')"
                    :current="request()->routeIs('admin.pengajuan*')" wire:navigate>
                    Pengajuan Masuk
                </flux:sidebar.item>

                <flux:sidebar.item icon="document-text" href="#" :current="request()->routeIs('admin.laporan*')"
                    wire:navigate>
                    Laporan
                </flux:sidebar.item>
            </flux:sidebar.group>

        </flux:sidebar.nav>

        <flux:spacer />

        <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500">
            Sistem Peminjaman
        </div>

    </flux:sidebar>

    {{ $slot }}

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>
