<x-layouts::app.sidebar :title="$title">
    <flux:main>

        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Catat pemakaian bahan oleh mahasiswa.
            </p>
        </div>

        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 max-w-2xl">

            <form method="POST" action="{{ route('admin.pengajuan.bahan.store') }}" class="space-y-5">
                @csrf

                {{-- Mahasiswa --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Mahasiswa <span class="text-red-500">*</span>
                    </label>
                    <select name="mahasiswa_id" required
                            class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        <option value="">-- Pilih Mahasiswa --</option>
                        @foreach($mahasiswas as $m)
                            <option value="{{ $m->id }}">
                                {{ $m->user->name ?? '-' }} ({{ $m->nim }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Bahan --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Bahan <span class="text-red-500">*</span>
                    </label>
                    <select name="bahan_id" required
                            class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        <option value="">-- Pilih Bahan --</option>
                        @foreach($bahans as $b)
                            <option value="{{ $b->id }}">
                                {{ $b->nama_bahan }} — stok: {{ $b->stok }} {{ $b->satuan }}
                                @if($b->biaya > 0) | Rp {{ number_format($b->biaya, 0, ',', '.') }}/{{ $b->satuan }} @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jumlah & Tanggal --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Jumlah <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}" min="1" required
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Tanggal Pakai <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="tanggal_pakai" value="{{ old('tanggal_pakai', date('Y-m-d')) }}" required
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    </div>
                </div>

                {{-- Praktikum --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Praktikum <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="praktikum" value="{{ old('praktikum') }}"
                           placeholder="Contoh: Farmakognosi"
                           class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Keterangan (opsional)
                    </label>
                    <textarea name="keterangan" rows="2"
                              placeholder="Catatan tambahan..."
                              class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                     focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">{{ old('keterangan') }}</textarea>
                </div>

                {{-- Info --}}
                <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 p-3 text-xs text-blue-800 dark:text-blue-200">
                    Pemakaian akan <b>langsung berstatus "Diserahkan"</b> dan stok bahan akan berkurang.
                </div>

                {{-- Tombol --}}
                <div class="flex gap-2 pt-5 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button type="submit" variant="primary" icon="check">Simpan</flux:button>
                    <flux:button :href="route('admin.pengajuan', ['tab' => 'bahan'])" variant="ghost" wire:navigate>Batal</flux:button>
                </div>

            </form>

        </div>

    </flux:main>
</x-layouts::app.sidebar>