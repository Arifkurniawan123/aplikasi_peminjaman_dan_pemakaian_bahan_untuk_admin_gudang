<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $title   = 'Data Satuan';
        $satuans = Satuan::latest()->get();

        return view('components.admin.satuan.index', compact('title', 'satuans'));
    }

    public function create()
    {
        $title = 'Tambah Satuan';

        return view('components.admin.satuan.create', compact('title'));
    }

    public function store(Request $request)
    {
        Satuan::create([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.satuan');
    }

    public function edit($id)
    {
        $title  = 'Edit Satuan';
        $satuan = Satuan::findOrFail($id);

        return view('components.admin.satuan.edit', compact('title', 'satuan'));
    }

    public function update(Request $request, $id)
    {
        Satuan::findOrFail($id)->update([
            'nama' => $request->nama,
            'tipe' => $request->tipe,
        ]);

        return redirect()->route('admin.satuan');
    }

    public function destroy($id)
    {
        Satuan::findOrFail($id)->delete();

        return redirect()->route('admin.satuan');
    }
}