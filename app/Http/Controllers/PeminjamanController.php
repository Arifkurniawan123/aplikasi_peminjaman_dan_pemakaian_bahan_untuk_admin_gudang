<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pemakaian;
use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengajuanController extends Controller
{
    /**
     * Halaman utama Pengajuan Masuk
     * 2 tab: Peminjaman Alat & Pemakaian Bahan + filter status
     */
    public function index(Request $request)
    {
        $title  = 'Pengajuan Masuk';
        $tab    = $request->get('tab', 'alat');
        $filter = $request->get('filter', 'semua');

        if ($tab === 'bahan') {
            $query = Pemakaian::with(['mahasiswa.user', 'bahan'])->latest();

            if ($filter === 'menunggu') {
                $query->where('status', 'menunggu');
            } elseif ($filter === 'diserahkan') {
                $query->where('status', 'diserahkan');
            } elseif ($filter === 'selesai') {
                $query->whereIn('status', ['diserahkan', 'ditolak']);
            }

            $data = $query->get();
        } else {
            $query = Peminjaman::with(['mahasiswa.user', 'alat'])->latest();

            if ($filter === 'menunggu') {
                $query->where('status', 'menunggu');
            } elseif ($filter === 'dipinjam') {
                $query->where('status', 'dipinjam');
            } elseif ($filter === 'selesai') {
                $query->whereIn('status', ['dikembalikan', 'ditolak']);
            }

            $data = $query->get();
        }

        return view('components.admin.pengajuan.index', compact('title', 'tab', 'filter', 'data'));
    }

    // ==========================================================
    // FORM INPUT MANUAL
    // ==========================================================

    /**
     * Form input peminjaman alat (admin)
     */
    public function createAlat()
    {
        $title      = 'Buat Peminjaman Alat';
        $mahasiswas = Mahasiswa::with('user')->get();
        $alats      = Alat::where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('components.admin.pengajuan.create-alat', compact('title', 'mahasiswas', 'alats'));
    }

    /**
     * Form input pemakaian bahan (admin)
     */
    public function createBahan()
    {
        $title      = 'Buat Pemakaian Bahan';
        $mahasiswas = Mahasiswa::with('user')->get();
        $bahans     = Bahan::where('stok', '>', 0)->orderBy('nama_bahan')->get();

        return view('components.admin.pengajuan.create-bahan', compact('title', 'mahasiswas', 'bahans'));
    }

    // ==========================================================
    // PEMINJAMAN ALAT
    // ==========================================================

    /**
     * Admin input peminjaman manual → LANGSUNG 'dipinjam', stok turun
     */
    public function storeAlat(Request $request)
    {
        $request->validate([
            'mahasiswa_id'   => 'required|exists:mahasiswa,id',
            'alat_id'        => 'required|exists:alat,id',
            'jumlah'         => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'praktikum'      => 'required|string|max:255',
        ]);

        $alat = Alat::findOrFail($request->alat_id);

        // Cek stok cukup?
        if ($alat->stok < $request->jumlah) {
            return back()->with('error', "Stok {$alat->nama_alat} tidak cukup. Tersedia: {$alat->stok}");
        }

        DB::transaction(function () use ($request, $alat) {
            // 1. Simpan peminjaman → langsung 'dipinjam'
            Peminjaman::create([
                'mahasiswa_id'   => $request->mahasiswa_id,
                'alat_id'        => $request->alat_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'jumlah'         => $request->jumlah,
                'praktikum'      => $request->praktikum,
                'status'         => 'dipinjam',
                'keterangan'     => $request->keterangan,
            ]);

            // 2. Kurangi stok alat
            $alat->decrement('stok', $request->jumlah);
        });

        return redirect()->route('admin.pengajuan', ['tab' => 'alat'])
            ->with('success', 'Peminjaman alat berhasil dicatat.');
    }

    /**
     * Verifikasi pengajuan dari mahasiswa → stok turun
     */
    public function serahkanAlat($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!$peminjaman->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $alat = Alat::findOrFail($peminjaman->alat_id);

        if ($alat->stok < $peminjaman->jumlah) {
            return back()->with('error', "Stok {$alat->nama_alat} tidak cukup. Tersedia: {$alat->stok}");
        }

        DB::transaction(function () use ($peminjaman, $alat) {
            $alat->decrement('stok', $peminjaman->jumlah);
            $peminjaman->update(['status' => 'dipinjam']);
        });

        return back()->with('success', 'Alat berhasil diserahkan.');
    }

    /**
     * Tolak pengajuan (stok tidak berubah)
     */
    public function tolakAlat(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if (!$peminjaman->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $peminjaman->update([
            'status'     => 'ditolak',
            'keterangan' => $request->keterangan ?? 'Ditolak oleh admin',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    /**
     * Terima kembali alat → stok naik, isi kondisi
     */
    public function terimaKembali(Request $request, $id)
    {
        $request->validate([
            'kondisi_kembali' => 'required|in:baik,rusak ringan,rusak berat,hilang',
            'keterangan'      => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if (!$peminjaman->isDipinjam()) {
            return back()->with('error', 'Peminjaman ini belum dipinjam / sudah dikembalikan.');
        }

        DB::transaction(function () use ($request, $peminjaman) {
            // Kembalikan stok hanya kalau kondisi tidak 'hilang'
            if ($request->kondisi_kembali !== 'hilang') {
                Alat::where('id', $peminjaman->alat_id)
                    ->increment('stok', $peminjaman->jumlah);
            }

            $peminjaman->update([
                'status'          => 'dikembalikan',
                'tanggal_kembali' => now(),
                'kondisi_kembali' => $request->kondisi_kembali,
                'keterangan'      => $request->keterangan,
            ]);
        });

        return back()->with('success', 'Alat berhasil dikembalikan.');
    }

    // ==========================================================
    // PEMAKAIAN BAHAN
    // ==========================================================

    /**
     * Admin input pemakaian manual → LANGSUNG 'diserahkan', stok turun
     */
    public function storeBahan(Request $request)
    {
        $request->validate([
            'mahasiswa_id'  => 'required|exists:mahasiswa,id',
            'bahan_id'      => 'required|exists:bahan,id',
            'jumlah'        => 'required|integer|min:1',
            'tanggal_pakai' => 'required|date',
            'praktikum'     => 'required|string|max:255',
        ]);

        $bahan = Bahan::findOrFail($request->bahan_id);

        if ($bahan->stok < $request->jumlah) {
            return back()->with('error', "Stok {$bahan->nama_bahan} tidak cukup. Tersedia: {$bahan->stok} {$bahan->satuan}");
        }

        DB::transaction(function () use ($request, $bahan) {
            Pemakaian::create([
                'mahasiswa_id'  => $request->mahasiswa_id,
                'bahan_id'      => $request->bahan_id,
                'tanggal_pakai' => $request->tanggal_pakai,
                'praktikum'     => $request->praktikum,
                'jumlah'        => $request->jumlah,
                'status'        => 'diserahkan',
                'keterangan'    => $request->keterangan,
            ]);

            $bahan->decrement('stok', $request->jumlah);
        });

        return redirect()->route('admin.pengajuan', ['tab' => 'bahan'])
            ->with('success', 'Pemakaian bahan berhasil dicatat.');
    }

    /**
     * Verifikasi pengajuan bahan dari mahasiswa → stok turun
     */
    public function serahkanBahan($id)
    {
        $pemakaian = Pemakaian::findOrFail($id);

        if (!$pemakaian->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $bahan = Bahan::findOrFail($pemakaian->bahan_id);

        if ($bahan->stok < $pemakaian->jumlah) {
            return back()->with('error', "Stok {$bahan->nama_bahan} tidak cukup. Tersedia: {$bahan->stok} {$bahan->satuan}");
        }

        DB::transaction(function () use ($pemakaian, $bahan) {
            $bahan->decrement('stok', $pemakaian->jumlah);
            $pemakaian->update(['status' => 'diserahkan']);
        });

        return back()->with('success', 'Bahan berhasil diserahkan.');
    }

    /**
     * Tolak pengajuan bahan
     */
    public function tolakBahan(Request $request, $id)
    {
        $pemakaian = Pemakaian::findOrFail($id);

        if (!$pemakaian->isMenunggu()) {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }

        $pemakaian->update([
            'status'     => 'ditolak',
            'keterangan' => $request->keterangan ?? 'Ditolak oleh admin',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }
}