<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Kelola satuan untuk alat & bahan.
                </p>
            </div>

            <flux:button :href="route('admin.satuan.create')" variant="primary" icon="plus" wire:navigate>
                Tambah Satuan
            </flux:button>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 5%;">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 40%;">Nama</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">Tipe</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 35%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($satuans as $i => $s)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">{{ $s->nama }}</td>
                            <td class="px-4 py-3">
                                @if($s->tipe === 'alat')
                                    <flux:badge color="blue" size="sm">Alat</flux:badge>
                                @else
                                    <flux:badge color="green" size="sm">Bahan</flux:badge>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <flux:button :href="route('admin.satuan.edit', $s->id)"
                                                 size="sm" variant="ghost" icon="pencil" wire:navigate>
                                        Edit
                                    </flux:button>

                                    <form method="POST" action="{{ route('admin.satuan.destroy', $s->id) }}"
                                          onsubmit="return confirm('Yakin hapus satuan {{ $s->nama }}?')">
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
                                Belum ada data satuan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $satuans->count() }} data
            </div>
        </div>

    </flux:main>
</x-layouts::app.sidebar>