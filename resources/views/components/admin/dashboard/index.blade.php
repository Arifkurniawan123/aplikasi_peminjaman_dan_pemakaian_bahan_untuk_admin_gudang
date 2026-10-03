<x-layouts::app.sidebar :title="$title">
    <flux:main>
        {{-- HEADER --}}
        <div class="mb-4">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <br>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Ringkasan data peminjaman dan pemakaian.</p>
        </div>

        {{-- KARTU STATISTIK --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-6">

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">Total Alat</div>
                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100 mt-1">
                    {{ $stats['total_alat'] }}
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">Total Bahan</div>
                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100 mt-1">
                    {{ $stats['total_bahan'] }}
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">Total Mahasiswa</div>
                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100 mt-1">
                    {{ $stats['total_mahasiswa'] }}
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">Pengajuan Menunggu</div>
                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100 mt-1">
                    {{ $stats['pengajuan_menunggu'] }}
                </div>
            </div>

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-4">
                <div class="text-xs text-zinc-500 dark:text-zinc-400">Sedang Dipinjam</div>
                <div class="text-2xl font-semibold text-zinc-800 dark:text-zinc-100 mt-1">
                    {{ $stats['sedang_dipinjam'] }}
                </div>
            </div>

        </div>

        {{-- TABEL STOK RENDAH --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900">

            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700 flex items-center gap-2">
                <span class="text-lg"></span>
                <span class="font-semibold text-zinc-800 dark:text-zinc-100">Stok Alat Rendah (≤5)</span>
            </div>

            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 w-12">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400">Nama Alat</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400">Kategori</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 w-24">Stok</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 w-24">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stokRendah as $i => $a)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">{{ $a->nama_alat }}</td>
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ $a->kategori ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="inline-flex px-2 py-0.5 rounded text-xs font-semibold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                    {{ $a->stok }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ $a->satuan }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-zinc-400">
                                Semua stok aman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>

    </flux:main>
</x-layouts::app.sidebar>
