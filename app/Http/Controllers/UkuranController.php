<?php

namespace App\Http\Controllers;

use App\Models\Ukuran;
use Illuminate\Http\Request;

class UkuranController extends Controller
{
    public function index()
    {
        $title   = 'Data Ukuran';
        $ukurans = Ukuran::latest()->get();

        return view('components.admin.ukuran.index', compact('title', 'ukurans'));
    }

    public function create()
    {
        $title = 'Tambah Ukuran';

        return view('components.admin.ukuran.create', compact('title'));
    }

    public function store(Request $request)
    {
        Ukuran::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.ukuran');
    }

    public function edit($id)
    {
        $title  = 'Edit Ukuran';
        $ukuran = Ukuran::findOrFail($id);

        return view('components.admin.ukuran.edit', compact('title', 'ukuran'));
    }

    public function update(Request $request, $id)
    {
        Ukuran::findOrFail($id)->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.ukuran');
    }

    public function destroy($id)
    {
        Ukuran::findOrFail($id)->delete();

        return redirect()->route('admin.ukuran');
    }
}