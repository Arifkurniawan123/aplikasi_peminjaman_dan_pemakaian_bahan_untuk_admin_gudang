<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">Kelola daftar alat laboratorium.</p>
            </div>

            <flux:button :href="route('admin.alat.create')" variant="primary" icon="plus" wire:navigate>
                Tambah Alat
            </flux:button>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">

            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 5%;">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 25%;">Nama Alat</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 15%;">Kategori</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 8%;">Stok</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 10%;">Satuan</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 12%;">Ukuran</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alats as $i => $a)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">{{ $a->nama_alat }}</td>
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">{{ $a->kategori ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="inline-flex px-2 py-0.5 rounded text-xs font-semibold
                                    {{ $a->stok <= 5
                                        ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'
                                        : 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' }}">
                                    {{ $a->stok }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-center text-zinc-600 dark:text-zinc-400">
                                {{ $a->satuan ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-center text-zinc-600 dark:text-zinc-400">
                                {{ $a->ukuran->nama ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <flux:button
                                        :href="route('admin.alat.edit', $a->id)"
                                        size="sm"
                                        variant="ghost"
                                        icon="pencil"
                                        wire:navigate>
                                        Edit
                                    </flux:button>

                                    <form method="POST" action="{{ route('admin.alat.destroy', $a->id) }}"
                                          onsubmit="return confirm('Yakin hapus {{ $a->nama_alat }}?')">
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
                                Belum ada data alat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $alats->count() }} data
            </div>

        </div>

    </flux:main>
</x-layouts::app.sidebar>