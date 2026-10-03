<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Tambah banyak alat sekaligus. Klik "+ Tambah Baris" untuk menambah baris baru.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.alat.store') }}">
            @csrf

            <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6"
                 x-data="{ rows: [{}] }">

                {{-- HEADER KOLOM --}}
                <div class="flex gap-2 mb-3 text-xs font-medium text-zinc-600 dark:text-zinc-400">
                    <div style="width: 22%;">Nama Alat <span class="text-red-500">*</span></div>
                    <div style="width: 16%;">Kategori</div>
                    <div style="width: 10%;">Stok</div>
                    <div style="width: 16%;">Satuan</div>
                    <div style="width: 16%;">Ukuran</div>
                    <div style="width: 8%;"></div>
                </div>

                {{-- BARIS --}}
                <template x-for="(row, index) in rows" :key="index">
                    <div class="flex gap-2 mb-3 items-center">

                        {{-- Nama Alat --}}
                        <div style="width: 22%;">
                            <input type="text"
                                   :name="`items[${index}][nama_alat]`"
                                   placeholder="Contoh: Labu Ukur"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Kategori --}}
                        <div style="width: 16%;">
                            <select :name="`items[${index}][kategori]`"
                                    class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                                <option value="">-- Pilih --</option>
                                @foreach($kategoris as $k)
                                    <option value="{{ $k }}">{{ $k }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Stok --}}
                        <div style="width: 10%;">
                            <input type="number"
                                   :name="`items[${index}][stok]`"
                                   value="0" min="0"
                                   class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                          focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        </div>

                        {{-- Satuan --}}
                        <div style="width: 16%;">
                            <select :name="`items[${index}][satuan]`"
                                    class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                                <option value="">-- Pilih --</option>
                                @foreach($satuans as $s)
                                    <option value="{{ $s }}">{{ $s }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Ukuran --}}
                        <div style="width: 16%;">
                            <select :name="`items[${index}][ukuran_id]`"
                                    class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                                <option value="">-- Kosong --</option>
                                @foreach($ukurans as $u)
                                    <option value="{{ $u->id }}">{{ $u->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Hapus --}}
                        <div style="width: 8%;" class="flex justify-center">
                            <button type="button"
                                    @click="rows.splice(index, 1)"
                                    x-show="rows.length > 1"
                                    class="text-red-500 hover:text-red-700 font-bold px-2">
                                ✕
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

                <flux:button :href="route('admin.alat')" variant="ghost" wire:navigate>
                    Batal
                </flux:button>
            </div>

        </form>

    </flux:main>
</x-layouts::app.sidebar>