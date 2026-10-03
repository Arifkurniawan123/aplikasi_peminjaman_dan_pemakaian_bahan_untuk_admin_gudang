<x-layouts::app.sidebar :title="$title">
    <flux:main>

        {{-- HEADER --}}
        <div class="flex justify-between items-start mb-6">
            <div>
                <h1 class="text-lg font-semibold text-zinc-800 dark:text-zinc-100">{{ $title }}</h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                    Kelola pengajuan peminjaman alat & pemakaian bahan.
                </p>
            </div>

            @if($tab === 'bahan')
                <flux:button :href="route('admin.pengajuan.bahan.create')" variant="primary" icon="plus" wire:navigate>
                    Buat Pemakaian
                </flux:button>
            @else
                <flux:button :href="route('admin.pengajuan.alat.create')" variant="primary" icon="plus" wire:navigate>
                    Buat Peminjaman
                </flux:button>
            @endif
        </div>

        {{-- FLASH --}}
        @if(session('success'))
            <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 border border-green-300 dark:border-green-800">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 border border-red-300 dark:border-red-800">
                {{ session('error') }}
            </div>
        @endif

        {{-- TAB UTAMA --}}
        <div class="flex gap-2 mb-4 border-b border-zinc-200 dark:border-zinc-700">
            <a href="{{ route('admin.pengajuan', ['tab' => 'alat']) }}"
               class="px-4 py-2 text-sm font-medium border-b-2 transition
                      {{ $tab === 'alat'
                          ? 'border-blue-600 text-blue-600 dark:text-blue-400'
                          : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                Peminjaman Alat
            </a>
            <a href="{{ route('admin.pengajuan', ['tab' => 'bahan']) }}"
               class="px-4 py-2 text-sm font-medium border-b-2 transition
                      {{ $tab === 'bahan'
                          ? 'border-blue-600 text-blue-600 dark:text-blue-400'
                          : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}">
                Pemakaian Bahan
            </a>
        </div>

        {{-- FILTER --}}
        <div class="flex gap-2 mb-4">
            <a href="{{ route('admin.pengajuan', ['tab' => $tab, 'filter' => 'semua']) }}"
               class="px-3 py-1 rounded-full text-xs font-medium transition
                      {{ $filter === 'semua' ? 'bg-blue-600 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400' }}">
                Semua
            </a>
            <a href="{{ route('admin.pengajuan', ['tab' => $tab, 'filter' => 'menunggu']) }}"
               class="px-3 py-1 rounded-full text-xs font-medium transition
                      {{ $filter === 'menunggu' ? 'bg-yellow-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400' }}">
                Menunggu
            </a>

            @if($tab === 'alat')
                <a href="{{ route('admin.pengajuan', ['tab' => $tab, 'filter' => 'dipinjam']) }}"
                   class="px-3 py-1 rounded-full text-xs font-medium transition
                          {{ $filter === 'dipinjam' ? 'bg-blue-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400' }}">
                    Sedang Dipinjam
                </a>
            @else
                <a href="{{ route('admin.pengajuan', ['tab' => $tab, 'filter' => 'diserahkan']) }}"
                   class="px-3 py-1 rounded-full text-xs font-medium transition
                          {{ $filter === 'diserahkan' ? 'bg-green-500 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400' }}">
                    Sudah Diserahkan
                </a>
            @endif

            <a href="{{ route('admin.pengajuan', ['tab' => $tab, 'filter' => 'selesai']) }}"
               class="px-3 py-1 rounded-full text-xs font-medium transition
                      {{ $filter === 'selesai' ? 'bg-zinc-600 text-white' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-800 dark:text-zinc-400' }}">
                Selesai
            </a>
        </div>

        {{-- TABEL --}}
        <div class="rounded-lg border border-zinc-200 dark:border-zinc-700 bg-white dark:bg-zinc-900 overflow-x-auto">

            @if($tab === 'alat')
                {{-- ========== TABEL PEMINJAMAN ALAT ========== --}}
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 4%;">No</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 13%;">Mahasiswa</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 20%;">Alat</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 6%;">Jumlah</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 7%;">Kembali</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 10%;">Praktikum</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 10%;">Tgl Pinjam</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 11%;">Status</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 19%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $p)
                            <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-zinc-800 dark:text-zinc-100">
                                        {{ $p->mahasiswa->user->name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $p->mahasiswa->nim ?? '-' }}
                                    </div>
                                </td>
                                {{-- Kolom Alat: nama + ukuran + satuan --}}
                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                    <div class="font-medium">{{ $p->alat->nama_alat ?? '-' }}</div>
                                    <div class="text-xs text-zinc-500">
                                        @if($p->alat->ukuran)
                                            {{ $p->alat->ukuran->nama }}
                                        @endif
                                        @if($p->alat->satuan)
                                            @if($p->alat->ukuran) · @endif
                                            {{ $p->alat->satuan }}
                                        @endif
                                        @if(!$p->alat->ukuran && !$p->alat->satuan)
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-center text-zinc-700 dark:text-zinc-300">
                                    {{ $p->jumlah }}
                                </td>
                                <td class="px-4 py-3 text-center text-zinc-700 dark:text-zinc-300">
                                    {{ $p->jumlah_kembali }} / {{ $p->jumlah }}
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                    {{ $p->praktikum ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                    {{ $p->tanggal_pinjam?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge :color="$p->status_color" size="sm">
                                        {{ $p->status_label }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center">
                                        @if($p->isMenunggu())
                                            <div class="flex gap-1">
                                                <form method="POST" action="{{ route('admin.pengajuan.alat.serahkan', $p->id) }}">
                                                    @csrf
                                                    <flux:button type="submit" size="sm" variant="primary" icon="check">
                                                        Serahkan
                                                    </flux:button>
                                                </form>
                                                <form method="POST" action="{{ route('admin.pengajuan.alat.tolak', $p->id) }}"
                                                      onsubmit="return confirm('Yakin tolak pengajuan ini?')">
                                                    @csrf
                                                    <flux:button type="submit" size="sm" variant="ghost" icon="x-mark" class="text-red-600">
                                                        Tolak
                                                    </flux:button>
                                                </form>
                                            </div>
                                        @elseif($p->isAktif())
                                            <form method="POST"
                                                  action="{{ route('admin.pengajuan.alat.kembali', $p->id) }}"
                                                  class="flex items-center gap-1 flex-wrap justify-center">
                                                @csrf
                                                <input type="number" name="jumlah_kembali"
                                                       value="{{ $p->sisaBelumKembali() }}"
                                                       min="1" max="{{ $p->sisaBelumKembali() }}"
                                                       class="w-12 border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-1 py-1 text-xs
                                                              focus:outline-none focus:ring-2 focus:ring-green-500"
                                                       title="Jumlah yang dikembalikan">
                                                <select name="kondisi_kembali" required
                                                        class="border border-zinc-300 dark:border-zinc-600 dark:bg-zinc-800 rounded-lg px-1 py-1 text-xs
                                                               focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    <option value="baik">Baik</option>
                                                    <option value="rusak ringan">R. Ringan</option>
                                                    <option value="rusak berat">R. Berat</option>
                                                    <option value="hilang">Hilang</option>
                                                </select>
                                                <button type="submit"
                                                        class="inline-flex items-center px-2 py-1 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-medium"
                                                        title="Kembalikan">
                                                    ✓
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-zinc-400">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-zinc-400">
                                    Belum ada data pengajuan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            @else
                {{-- ========== TABEL PEMAKAIAN BAHAN ========== --}}
                <table class="w-full text-sm">
                    <thead class="bg-zinc-50 dark:bg-zinc-900/50">
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 4%;">No</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 14%;">Mahasiswa</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 13%;">Bahan</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 8%;">Jumlah</th>
                            <th class="px-4 py-3 text-right font-medium text-zinc-600 dark:text-zinc-400" style="width: 11%;">Biaya</th>
                            <th class="px-4 py-3 text-right font-medium text-zinc-600 dark:text-zinc-400" style="width: 12%;">Total</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 11%;">Praktikum</th>
                            <th class="px-4 py-3 text-left font-medium text-zinc-600 dark:text-zinc-400" style="width: 10%;">Status</th>
                            <th class="px-4 py-3 text-center font-medium text-zinc-600 dark:text-zinc-400" style="width: 17%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $p)
                            <tr class="border-b border-zinc-100 dark:border-zinc-700/50 hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                                <td class="px-4 py-3 text-zinc-500">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-zinc-800 dark:text-zinc-100">
                                        {{ $p->mahasiswa->user->name ?? '-' }}
                                    </div>
                                    <div class="text-xs text-zinc-500">
                                        {{ $p->mahasiswa->nim ?? '-' }}
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-zinc-700 dark:text-zinc-300">
                                    {{ $p->bahan->nama_bahan ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-center text-zinc-700 dark:text-zinc-300">
                                    {{ $p->jumlah }} {{ $p->bahan->satuan ?? '' }}
                                </td>
                                <td class="px-4 py-3 text-right text-zinc-600 dark:text-zinc-400">
                                    Rp {{ number_format($p->bahan->biaya ?? 0, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-right font-semibold text-zinc-800 dark:text-zinc-100">
                                    Rp {{ number_format(($p->bahan->biaya ?? 0) * $p->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-3 text-zinc-600 dark:text-zinc-400">
                                    {{ $p->praktikum }}
                                </td>
                                <td class="px-4 py-3">
                                    <flux:badge :color="$p->status_color" size="sm">
                                        {{ $p->status_label }}
                                    </flux:badge>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        @if($p->isMenunggu())
                                            <form method="POST" action="{{ route('admin.pengajuan.bahan.serahkan', $p->id) }}">
                                                @csrf
                                                <flux:button type="submit" size="sm" variant="primary" icon="check">
                                                    Serahkan
                                                </flux:button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.pengajuan.bahan.tolak', $p->id) }}"
                                                  onsubmit="return confirm('Yakin tolak pengajuan ini?')">
                                                @csrf
                                                <flux:button type="submit" size="sm" variant="ghost" icon="x-mark" class="text-red-600">
                                                    Tolak
                                                </flux:button>
                                            </form>
                                        @else
                                            <span class="text-xs text-zinc-400">—</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-zinc-400">
                                    Belum ada data pengajuan
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

            {{-- FOOTER --}}
            <div class="px-4 py-3 border-t border-zinc-200 dark:border-zinc-700 text-xs text-zinc-500 dark:text-zinc-400">
                Menampilkan {{ $data->count() }} data
            </div>
        </div>

    </flux:main>
</x-layouts::app.sidebar>