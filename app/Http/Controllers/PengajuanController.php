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
    // ==========================================================
    // HALAMAN UTAMA
    // ==========================================================

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
           $query = Peminjaman::with(['mahasiswa.user', 'alat.ukuran'])->latest();
            if ($filter === 'menunggu') {
                $query->where('status', 'menunggu');
            } elseif ($filter === 'dipinjam') {
                $query->whereIn('status', ['dipinjam', 'sebagian']);
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

    public function createAlat()
    {
        $title      = 'Buat Peminjaman Alat';
        $mahasiswas = Mahasiswa::with('user')->get();
        $alats      = Alat::where('stok', '>', 0)->orderBy('nama_alat')->get();

        return view('components.admin.pengajuan.create-alat', compact('title', 'mahasiswas', 'alats'));
    }

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

    public function storeAlat(Request $request)
    {
        $alat = Alat::findOrFail($request->alat_id);

        if ($alat->stok < $request->jumlah) {
            return back()->with('error', "Stok {$alat->nama_alat} tidak cukup. Tersedia: {$alat->stok}");
        }

        DB::transaction(function () use ($request, $alat) {
            Peminjaman::create([
                'mahasiswa_id'   => $request->mahasiswa_id,
                'alat_id'        => $request->alat_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'jumlah'         => $request->jumlah,
                'jumlah_kembali' => 0,
                'praktikum'      => $request->praktikum,
                'status'         => 'dipinjam',
                'keterangan'     => $request->keterangan,
            ]);

            $alat->decrement('stok', $request->jumlah);
        });

        return redirect()->route('admin.pengajuan', ['tab' => 'alat'])
            ->with('success', 'Peminjaman alat berhasil dicatat.');
    }

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
     * Terima kembali alat (support partial return)
     */
    public function terimaKembali(Request $request, $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->isSelesai()) {
            return back()->with('error', 'Peminjaman ini sudah selesai.');
        }

        $sisa = $peminjaman->sisaBelumKembali();
        $jumlahKembali = (int) $request->input('jumlah_kembali', $sisa);

        if ($jumlahKembali < 1 || $jumlahKembali > $sisa) {
            return back()->with('error', "Jumlah kembali harus antara 1 sampai {$sisa}.");
        }

        DB::transaction(function () use ($request, $peminjaman, $jumlahKembali) {
            // Kembalikan stok (kecuali kondisi hilang)
            if ($request->kondisi_kembali !== 'hilang') {
                Alat::where('id', $peminjaman->alat_id)
                    ->increment('stok', $jumlahKembali);
            }

            $peminjaman->jumlah_kembali += $jumlahKembali;

            if ($peminjaman->sudahKembaliSemua()) {
                $peminjaman->status = 'dikembalikan';
                $peminjaman->tanggal_kembali = now();
            } else {
                $peminjaman->status = 'sebagian';
            }

            if ($request->kondisi_kembali) {
                $peminjaman->kondisi_kembali = $request->kondisi_kembali;
            }
            if ($request->keterangan) {
                $peminjaman->keterangan = $request->keterangan;
            }

            $peminjaman->save();
        });

        $pesan = $peminjaman->sudahKembaliSemua()
            ? 'Semua alat berhasil dikembalikan.'
            : "Alat dikembalikan sebagian ({$jumlahKembali}).";

        return back()->with('success', $pesan);
    }

    // ==========================================================
    // PEMAKAIAN BAHAN
    // ==========================================================

    public function storeBahan(Request $request)
    {
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