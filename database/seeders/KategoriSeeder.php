<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // ===== ALAT =====
            ['Alat Gelas',     'alat'],
            ['Alat Ukur',      'alat'],
            ['Alat Pemanas',   'alat'],
            ['Alat Logam',     'alat'],
            ['Alat Pendukung', 'alat'],

            // ===== BAHAN =====
            ['Cairan',         'bahan'],
            ['Padat',          'bahan'],
            ['Serbuk',         'bahan'],
            ['Gas',            'bahan'],
        ];

        foreach ($data as $d) {
            Kategori::create([
                'nama' => $d[0],
                'tipe' => $d[1],
            ]);
        }
    }
}