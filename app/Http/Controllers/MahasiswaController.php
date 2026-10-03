<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
class MahasiswaController extends Controller
{
    public function index(){
        $title='Data Mahasiswa';

        $mahasiswas=Mahasiswa::latest()->get();

        return view('components.admin.mahasiswa.index',compact('title','mahasiswas'));

    }

    public function create(){
        $title='Tambah Mahasiswa';

        return view('components.admin.mahasiswa.create',compact('title'));

    }

    public function store(Request $request){
        Mahasiswa::create([
            'user_id'=>$request->user_id,
            'nim'=>$request->nim,
            'prodi'=>$request->prodi]);

            return redirect()->route('admin.mahasiswa');

    }

    public function edit($id)
    {
        $title    = 'Edit Mahasiswa';
        $mahasiswa = Mahasiswa::findOrFail($id);

        return view('components.admin.mahasiswa.edit', compact('title', 'mahasiswa'));
}

    public function update(Request $request, $id){
        Mahasiswa::findOrFail($id)->update([
            'user_id'=>$request->user_id,
            'nim'=>$request->nim,
            'prodi'=>$request->prodi
        ]);

        return redirect()->route('admin.mahasiswa');
    }

    public function destroy($id)
    {
        Mahasiswa::findOrFail($id)->delete();

        return redirect()->route('admin.mahasiswa');
    }
}