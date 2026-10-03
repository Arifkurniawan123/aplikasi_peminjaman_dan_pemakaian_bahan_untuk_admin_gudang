<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $title     = 'Data Kategori';
        $kategoris = Kategori::latest()->get();

        return view('components.admin.kategori.index', compact('title', 'kategoris'));
    }

    public function create()
    {
        $title = 'Tambah Kategori';

        return view('components.admin.kategori.create', compact('title'));
    }

    public function store(Request $request)
    {
        Kategori::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.kategori');
    }

    public function edit($id)
    {
        $title    = 'Edit Kategori';
        $kategori = Kategori::findOrFail($id);

        return view('components.admin.kategori.edit', compact('title', 'kategori'));
    }

    public function update(Request $request, $id)
    {
        Kategori::findOrFail($id)->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.kategori');
    }

    public function destroy($id)
    {
        Kategori::findOrFail($id)->delete();

        return redirect()->route('admin.kategori');
    }
}