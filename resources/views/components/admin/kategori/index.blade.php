<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Kelola kategori untuk alat & bahan.
                </p>
            </div>

            <flux:button :href="route('admin.kategori.create')" variant="primary" icon="plus" wire:navigate>
                Tambah Kategori
            </flux:button>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 w-12">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400">Nama</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400 w-32">Tipe</th>
                        <th class="px-4 py-3 text-right font-medium text-zinc-600 dark:text-zinc-400 w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $i => $k)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">{{ $k->nama }}</td>
                            <td class="px-4 py-3">
                                @if($k->tipe === 'alat')
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold
                                        bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                        Alat
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold
                                        bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                        Bahan
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <flux:button :href="route('admin.kategori.edit', $k->id)"
                                                 size="sm" variant="ghost" icon="pencil" wire:navigate>
                                        Edit
                                    </flux:button>

                                    <form method="POST" action="{{ route('admin.kategori.destroy', $k->id) }}"
                                          onsubmit="return confirm('Yakin hapus kategori {{ $k->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <flux:button type="submit" size="sm" variant="ghost" icon="trash" class="text-red-600">
                                            Hapus
                                        </flux:button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-12 text-center text-zinc-400">
                                Belum ada data kategori
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $kategoris->count() }} data
            </div>
        </div>

    </flux:main>
</x-layouts::app.sidebar>