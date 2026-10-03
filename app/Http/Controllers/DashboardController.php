<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Mahasiswa;
use App\Models\Peminjaman;
use App\Models\Pemakaian;

class DashboardController extends Controller
{
    public function index()
    {
        $title='Dashboard-Admin';
        
        $stats = [
            'total_alat'         => Alat::count(),
            'total_bahan'        => Bahan::count(),
            'total_mahasiswa'    => Mahasiswa::count(),
            'pengajuan_menunggu' => Peminjaman::menunggu()->count()
                                  + Pemakaian::menunggu()->count(),
            'sedang_dipinjam'    => Peminjaman::dipinjam()->count(),
        ];

        $stokRendah = Alat::where('stok', '<=', 5)
            ->orderBy('stok')
            ->take(5)
            ->get();

        return view('components.admin.dashboard.index', compact('title','stats', 'stokRendah'));
    }
}