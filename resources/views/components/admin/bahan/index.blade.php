<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Kelola daftar bahan laboratorium.</p>
            </div>

            <flux:button :href="route('admin.bahan.create')" variant="primary" icon="plus" wire:navigate>
                Tambah Bahan
            </flux:button>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 4%;">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">Nama Bahan</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 12%;">Kategori</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 22%;">Stok</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 8%;">Satuan</th>
                        <th class="px-4 py-3 text-right font-medium text-zinc-600 dark:text-zinc-400" style="width: 14%;">Biaya</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bahans as $i => $b)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>

                            {{-- Nama Bahan --}}
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $b->nama_bahan }}
                            </td>

                            {{-- Kategori --}}
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                {{ $b->kategori ?? '-' }}
                            </td>

                            {{-- Stok --}}
                            <td class="px-4 py-3">
                                @if($b->stok_botol > 0)
                                    <div class="font-semibold text-zinc-800 dark:text-zinc-100">
                                        {{ $b->total_stok }} {{ $b->satuan }}
                                    </div>
                                    <div class="text-xs text-zinc-500 mt-0.5 space-y-0.5">
                                        <div>
                                            {{ $b->stok_botol }} botol utuh
                                            <span class="text-zinc-400">
                                                ({{ $b->stok_botol * $b->isi_per_botol }} {{ $b->satuan }})
                                            </span>
                                        </div>
                                        @if($b->stok > 0)
                                            <div>
                                                Botol terbuka, sisa
                                                <span class="text-zinc-400">
                                                    ({{ $b->stok }} {{ $b->satuan }})
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold
                                        {{ $b->stok <= 5
                                            ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                            : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' }}">
                                        {{ $b->stok }}
                                    </span>
                                @endif
                            </td>

                            {{-- Satuan --}}
                            <td class="px-4 py-3 text-center text-zinc-600 dark:text-zinc-400">
                                {{ $b->satuan }}
                            </td>

                            {{-- Biaya --}}
                            <td class="px-4 py-3 text-right text-zinc-700 dark:text-zinc-300">
                                @if($b->biaya > 0)
                                    <div class="font-semibold">
                                        Rp{{ number_format($b->biaya, 0, ',', '.') }}
                                    </div>
                                    <div class="text-xs text-zinc-500">
                                        / {{ $b->satuan }}
                                    </div>
                                @else
                                    <span class="text-zinc-400">—</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <flux:button
                                        :href="route('admin.bahan.edit', $b->id)"
                                        size="sm"
                                        variant="ghost"
                                        icon="pencil"
                                        wire:navigate>
                                        Edit
                                    </flux:button>

                                    <form method="POST" action="{{ route('admin.bahan.destroy', $b->id) }}"
                                          onsubmit="return confirm('Yakin hapus {{ $b->nama_bahan }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button
                                            type="submit"
                                            size="sm"
                                            variant="ghost"
                                            icon="trash"
                                            class="text-red-600">
                                            Hapus
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-zinc-400">
                                Belum ada data bahan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $bahans->count() }} data
            </div>

        </div>

    </flux:main>
</x-layouts::app.sidebar>