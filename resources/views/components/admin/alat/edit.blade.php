<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Ubah data alat: <span class="font-medium">{{ $alat->nama_alat }}</span>
            </p>
        </div>

        {{-- FORM --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 max-w-2xl">

            <form method="POST" action="{{ route('admin.alat.update', $alat->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Alat --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Nama Alat <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_alat" value="{{ old('nama_alat', $alat->nama_alat) }}"
                           class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    @error('nama_alat')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
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
                            <option value="{{ $k }}" @selected(old('kategori', $alat->kategori) == $k)>
                                {{ $k }}
                            </option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Stok & Satuan --}}
                <div class="grid grid-cols-2 gap-4">

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Stok <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stok" value="{{ old('stok', $alat->stok) }}" min="0"
                               class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                      focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        @error('stok')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <select name="satuan"
                                class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                       focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                            <option value="">-- Pilih Satuan --</option>
                            @foreach($satuans as $s)
                                <option value="{{ $s }}" @selected(old('satuan', $alat->satuan) == $s)>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                        @error('satuan')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Ukuran --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Ukuran (opsional)
                    </label>
                    <select name="ukuran_id"
                            class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        <option value="">-- Kosong --</option>
                        @foreach($ukurans as $u)
                            <option value="{{ $u->id }}" @selected(old('ukuran_id', $alat->ukuran_id) == $u->id)>
                                {{ $u->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('ukuran_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- TOMBOL --}}
                <div class="flex gap-2 pt-5 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button type="submit" variant="primary" icon="check">
                        Update
                    </flux:button>

                    <flux:button :href="route('admin.alat')" variant="ghost" wire:navigate>
                        Batal
                    </flux:button>
                </div>

            </form>

        </div>

    </flux:main>
</x-layouts::app.sidebar>