<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\Kategori;
use App\Models\Satuan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    public function index()
    {
        $title  = 'Data Bahan';
        $bahans = Bahan::latest()->get();

        return view('components.admin.bahan.index', compact('title', 'bahans'));
    }

    public function create()
    {
        $title     = 'Tambah Bahan';
        $kategoris = Kategori::bahan()->pluck('nama');
        $satuans   = Satuan::bahan()->pluck('nama');

        return view('components.admin.bahan.create', compact('title', 'kategoris', 'satuans'));
    }

    public function store(Request $request)
    {
        $items = $request->input('items', []);

        foreach ($items as $item) {
            if (empty($item['nama_bahan'])) {
                continue;
            }

            Bahan::create([
                'nama_bahan'    => $item['nama_bahan'],
                'kategori'      => $item['kategori'] ?? null,
                'stok'          => $item['stok'] ?? 0,
                'stok_botol'    => $item['stok_botol'] ?? 0,
                'isi_per_botol' => $item['isi_per_botol'] ?? 0,
                'satuan'        => $item['satuan'] ?? null,
                'biaya'         => !empty($item['biaya']) ? $item['biaya'] : 0,
            ]);
        }

        return redirect()->route('admin.bahan');
    }

    public function edit($id)
    {
        $title     = 'Edit Bahan';
        $bahan     = Bahan::findOrFail($id);
        $kategoris = Kategori::bahan()->pluck('nama');
        $satuans   = Satuan::bahan()->pluck('nama');

        return view('components.admin.bahan.edit', compact('title', 'bahan', 'kategoris', 'satuans'));
    }

    public function update(Request $request, $id)
    {
        Bahan::findOrFail($id)->update([
            'nama_bahan'    => $request->nama_bahan,
            'kategori'      => $request->kategori,
            'stok'          => $request->stok ?? 0,
            'stok_botol'    => $request->stok_botol ?? 0,
            'isi_per_botol' => $request->isi_per_botol ?? 0,
            'satuan'        => $request->satuan,
            'biaya'         => $request->biaya ?: 0,
        ]);

        return redirect()->route('admin.bahan');
    }

    public function destroy($id)
    {
        Bahan::findOrFail($id)->delete();

        return redirect()->route('admin.bahan');
    }
}