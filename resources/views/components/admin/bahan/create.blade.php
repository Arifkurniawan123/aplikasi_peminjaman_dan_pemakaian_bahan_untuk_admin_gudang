<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Tambah banyak bahan sekaligus. Klik "+ Tambah Baris" untuk menambah baris baru.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.bahan.store') }}">
            @csrf

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6"
                 x-data="{ rows: [{}] }">

                {{-- HEADER KOLOM --}}
                <div class="flex gap-2 mb-3 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                    <div style="width: 22%;">Nama Bahan <span class="text-red-500">*</span></div>
                    <div style="width: 13%;">Kategori</div>
                    <div style="width: 9%;">Sisa</div>
                    <div style="width: 8%;">Botol</div>
                    <div style="width: 9%;">Isi/Botol</div>
                    <div style="width: 9%;">Satuan</div>
                    <div style="width: 13%;">Biaya (Rp)</div>
                    <div style="width: 17%;"></div>
                </div>

                {{-- BARIS --}}
                <template x-for="(row, index) in rows" :key="index">
                    <div class="flex gap-2 mb-3 items-center">

                        {{-- Nama Bahan --}}
                        <div style="width: 22%;">
                            <input type="text"
                                   :name="`items[${index}][nama_bahan]`"
                                   placeholder="Etanol 96%"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Kategori --}}
                        <div style="width: 13%;">
                            <select :name="`items[${index}][kategori]`"
                                    class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                                <option value="">-- Pilih --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Sisa --}}
                        <div style="width: 9%;">
                            <input type="number"
                                   :name="`items[${index}][stok]`"
                                   placeholder="500"
                                   value="0" min="0"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Botol --}}
                        <div style="width: 8%;">
                            <input type="number"
                                   :name="`items[${index}][stok_botol]`"
                                   placeholder="2"
                                   value="0" min="0"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Isi per Botol --}}
                        <div style="width: 9%;">
                            <input type="number"
                                   :name="`items[${index}][isi_per_botol]`"
                                   placeholder="1000"
                                   value="0" min="0"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Satuan --}}
                        <div style="width: 9%;">
                            <select :name="`items[${index}][satuan]`"
                                    class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                                <option value="">--</option>
                                @foreach($satuans as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Biaya --}}
                        <div style="width: 13%;">
                            <input type="number"
                                   :name="`items[${index}][biaya]`"
                                   placeholder="0"
                                   value="0" min="0" step="0.01"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Hapus --}}
                        <div style="width: 17%;" class="flex justify-center">
                            <button type="button"
                                    @click="rows.splice(index, 1)"
                                    x-show="rows.length > 1"
                                    class="text-red-500 hover:text-red-700 font-bold px-2">
                                ✕ Hapus
                            </button>
                        </div>

                    </div>
                </template>

                {{-- TOMBOL TAMBAH BARIS --}}
                <button type="button"
                        @click="rows.push({})"
                        class="mt-3 text-blue-600 hover:text-blue-800 dark:text-blue-400 text-sm font-medium
                               flex items-center gap-1 border border-dashed border-blue-400 dark:border-blue-600
                               rounded-lg px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/20">
                    <span class="text-lg leading-none">+</span>
                    <span>Tambah Baris</span>
                </button>

            </div>

            {{-- TOMBOL SIMPAN / BATAL --}}
            <div class="mt-4 flex gap-2">
                <flux:button type="submit" variant="primary" icon="check">
                    Simpan Semua
                </flux:button>

                <flux:button :href="route('admin.bahan')" variant="ghost" wire:navigate>
                    Batal
                </flux:button>
            </div>

        </form>

    </flux:main>
</x-layouts::app.sidebar>