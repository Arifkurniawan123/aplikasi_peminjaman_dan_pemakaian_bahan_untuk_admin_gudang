<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Kelola daftar mahasiswa.
                </p>
            </div>

            <flux:button :href="route('admin.mahasiswa.create')" variant="primary" icon="plus" wire:navigate>
                Tambah Mahasiswa
            </flux:button>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                    <tr class="border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 5%;">No</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">NIM</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 30%;">Nama</th>
                        <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">Prodi</th>
                        <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 25%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($mahasiswas as $i => $m)
                        <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                            <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                            <td class="px-4 py-3 font-mono text-zinc-700 dark:text-zinc-300">
                                {{ $m->nim }}
                            </td>
                            <td class="px-4 py-3 font-medium text-zinc-800 dark:text-zinc-100">
                                {{ $m->user->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                {{ $m->prodi ?? '-' }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-center gap-2">
                                    <flux:button
                                        :href="route('admin.mahasiswa.edit', $m->id)"
                                        size="sm"
                                        variant="ghost"
                                        icon="pencil"
                                        wire:navigate>
                                        Edit
                                    </flux:button>

                                    <form method="POST" action="{{ route('admin.mahasiswa.destroy', $m->id) }}"
                                          onsubmit="return confirm('Yakin hapus mahasiswa {{ $m->user->name ?? '' }}?')">
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
                            <td colspan="5" class="px-4 py-12 text-center text-zinc-400">
                                Belum ada data mahasiswa
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $mahasiswas->count() }} data
            </div>
        </div>

    </flux:main>
</x-layouts::app.sidebar>