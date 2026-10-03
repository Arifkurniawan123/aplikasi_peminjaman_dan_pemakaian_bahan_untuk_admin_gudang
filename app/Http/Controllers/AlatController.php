<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Satuan;
use App\Models\Ukuran;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    public function index()
    {
        $title = 'Data Alat';
        $alats = Alat::with('ukuran')->latest()->get();

        return view('components.admin.alat.index', compact('title', 'alats'));
    }

    public function create()
    {
        $title     = 'Tambah Alat';
        $kategoris = Kategori::alat()->pluck('nama');
        $satuans   = Satuan::alat()->pluck('nama');
        $ukurans   = Ukuran::orderBy('id')->get();

        return view('components.admin.alat.create', compact('title', 'kategoris', 'satuans', 'ukurans'));
    }

    public function store(Request $request)
    {
        $items = $request->input('items', []);

        foreach ($items as $item) {
            // Skip baris kosong
            if (empty($item['nama_alat'])) {
                continue;
            }

            Alat::create([
                'nama_alat' => $item['nama_alat'],
                'kategori'  => $item['kategori'] ?? null,
                'stok'      => $item['stok'] ?? 0,
                'satuan'    => $item['satuan'] ?? null,
                'ukuran_id' => !empty($item['ukuran_id']) ? $item['ukuran_id'] : null,
            ]);
        }

        return redirect()->route('admin.alat');
    }

    public function edit($id)
    {
        $title     = 'Edit Alat';
        $alat      = Alat::findOrFail($id);
        $kategoris = Kategori::alat()->pluck('nama');
        $satuans   = Satuan::alat()->pluck('nama');
        $ukurans   = Ukuran::orderBy('id')->get();

        return view('components.admin.alat.edit', compact('title', 'alat', 'kategoris', 'satuans', 'ukurans'));
    }

    public function update(Request $request, $id)
    {
        Alat::findOrFail($id)->update([
            'nama_alat' => $request->nama_alat,
            'kategori'  => $request->kategori,
            'stok'      => $request->stok ?? 0,
            'satuan'    => $request->satuan,
            'ukuran_id' => $request->ukuran_id ?: null,
        ]);

        return redirect()->route('admin.alat');
    }

    public function destroy($id)
    {
        Alat::findOrFail($id)->delete();

        return redirect()->route('admin.alat');
    }
}