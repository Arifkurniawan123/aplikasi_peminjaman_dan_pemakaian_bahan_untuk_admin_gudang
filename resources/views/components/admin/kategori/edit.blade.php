<x-layouts::app.sidebar :title="$title">
    <flux:main>

        <div class="mb-6">
            <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                Ubah data kategori: <span class="font-medium">{{ $kategori->nama }}</span>
            </p>
        </div>

        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 p-6 max-w-xl">

            <form method="POST" action="{{ route('admin.kategori.update', $kategori->id) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Nama Kategori <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama', $kategori->nama) }}"
                           class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                    @error('nama')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tipe --}}
                <div>
                    <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <select name="tipe"
                            class="w-full border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-3 py-2 text-sm
                                   focus:outline-none focus:ring-2 focus:ring-blue-500 dark:text-zinc-100">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="alat" @selected(old('tipe', $kategori->tipe) == 'alat')>Alat</option>
                        <option value="bahan" @selected(old('tipe', $kategori->tipe) == 'bahan')>Bahan</option>
                    </select>
                    @error('tipe')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol --}}
                <div class="flex gap-2 pt-5 border-t border-zinc-200 dark:border-zinc-700">
                    <flux:button type="submit" variant="primary" icon="check">Update</flux:button>
                    <flux:button :href="route('admin.kategori')" variant="ghost" wire:navigate>Batal</flux:button>
                </div>
            </form>

        </div>

    </flux:main>
</x-layouts::app.sidebar>