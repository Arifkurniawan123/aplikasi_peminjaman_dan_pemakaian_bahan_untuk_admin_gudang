<x-layouts::app.sidebar :title="$title">
    <flux:main>

        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Ubah data bahan: <span class="font-medium">{{ $bahan->nama_bahan }}</span>
            </p>
        </div>

        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 max-w-3xl">

            <form method="POST" action="{{ route('admin.bahan.update', $bahan->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Bahan --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Nama Bahan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_bahan"
                           value="{{ old('nama_bahan', $bahan->nama_bahan) }}"
                           class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                </div>

                {{-- Kategori --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select name="kategori"
                            class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k }}" @selected(old('kategori', $bahan->kategori) == $k)>
                                {{ $k }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Grid: Sisa, Botol, Isi/Botol, Satuan --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Sisa (ml/gr)
                        </label>
                        <input type="number" name="stok"
                               value="{{ old('stok', $bahan->stok) }}" min="0"
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Botol Utuh
                        </label>
                        <input type="number" name="stok_botol"
                               value="{{ old('stok_botol', $bahan->stok_botol) }}" min="0"
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Isi per Botol
                        </label>
                        <input type="number" name="isi_per_botol"
                               value="{{ old('isi_per_botol', $bahan->isi_per_botol) }}" min="0"
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="satuan"
                                class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                            <option value="">-- Pilih --</option>
                            @foreach($satuans as $s)
                                <option value="{{ $s }}" @selected(old('satuan', $bahan->satuan) == $s)>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Biaya --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Biaya per Satuan (Rp)
                    </label>
                    <input type="number" name="biaya"
                           value="{{ old('biaya', $bahan->biaya) }}"
                           min="0" step="0.01"
                           placeholder="Contoh: 5000"
                           class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    <p class="text-xs text-zinc-500 mt-1">
                        Harga per 1 satuan (misal: Rp5.000 per mL). Total = jumlah × biaya.
                    </p>
                </div>

                {{-- Preview Total Nilai Stok --}}
                @if($bahan->biaya > 0)
                    <div class="rounded-lg bg-blue-50 dark:bg-blue-900/20 p-3 text-sm text-blue-800 dark:text-blue-200">
                        Total nilai stok saat ini:
                        <b>
                            Rp{{ number_format($bahan->stok * $bahan->biaya, 0, ',', '.') }}
                        </b>
                        <span class="text-xs">({{ $bahan->stok }} {{ $bahan->satuan }} × Rp{{ number_format($bahan->biaya, 0, ',', '.') }})</span>
                    </div>
                @endif

                {{-- Tombol --}}
                <div class="flex gap-2 pt-5 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button type="submit" variant="primary" icon="check">Update</flux:button>
                    <flux:button :href="route('admin.bahan')" variant="ghost" wire:navigate>Batal</flux:button>
                </div>

            </form>

        </div>

    </flux:main>
</x-layouts::app.sidebar>