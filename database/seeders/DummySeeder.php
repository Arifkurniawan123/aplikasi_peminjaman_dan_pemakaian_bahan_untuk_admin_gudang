<?php

namespace Database\Seeders;

use App\Models\Alat;
use App\Models\Bahan;
use App\Models\Mahasiswa;
use App\Models\Pemakaian;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        // ============ USERS ============
        $admin = User::create([
            'name'     => 'Admin Gudang',
            'email'    => 'admin@test.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        $mhs1User = User::create([
            'name'     => 'Budi Santoso',
            'email'    => 'budi@test.com',
            'password' => Hash::make('password'),
            'role'     => 'mahasiswa',
        ]);

        $mhs2User = User::create([
            'name'     => 'Sari Dewi',
            'email'    => 'sari@test.com',
            'password' => Hash::make('password'),
            'role'     => 'mahasiswa',
        ]);

        // ============ MAHASISWA ============
        $mhs1 = Mahasiswa::create([
            'user_id' => $mhs1User->id,
            'nim'     => '21001',
            'prodi'   => 'D3 Farmasi',
        ]);

        $mhs2 = Mahasiswa::create([
            'user_id' => $mhs2User->id,
            'nim'     => '21002',
            'prodi'   => 'D3 Farmasi',
        ]);

        // ============ ALAT ============
        $alats = [
            ['nama_alat' => 'Mortar',              'kategori' => 'Alat Gelas',    'stok' => 15, 'satuan' => 'pcs'],
            ['nama_alat' => 'Gelas Ukur 100ml',    'kategori' => 'Alat Gelas',    'stok' => 3,  'satuan' => 'pcs'],
            ['nama_alat' => 'Gelas Ukur 250ml',    'kategori' => 'Alat Gelas',    'stok' => 8,  'satuan' => 'pcs'],
            ['nama_alat' => 'Bunsen',              'kategori' => 'Alat Pemanas',  'stok' => 5,  'satuan' => 'unit'],
            ['nama_alat' => 'Timbangan Analitik',  'kategori' => 'Alat Ukur',     'stok' => 2,  'satuan' => 'unit'],
            ['nama_alat' => 'Pipet Tetes',         'kategori' => 'Alat Gelas',    'stok' => 50, 'satuan' => 'pcs'],
            ['nama_alat' => 'Erlenmeyer 250ml',    'kategori' => 'Alat Gelas',    'stok' => 4,  'satuan' => 'pcs'],
            ['nama_alat' => 'Tabung Reaksi',       'kategori' => 'Alat Gelas',    'stok' => 30, 'satuan' => 'pcs'],
            ['nama_alat' => 'Rak Tabung Reaksi',   'kategori' => 'Alat Pendukung','stok' => 10, 'satuan' => 'pcs'],
            ['nama_alat' => 'Penjepit Kayu',       'kategori' => 'Alat Pendukung','stok' => 20, 'satuan' => 'pcs'],
        ];

        foreach ($alats as $a) {
            Alat::create($a);
        }

        // ============ BAHAN ============
        $bahans = [
            ['nama_bahan' => 'Etanol 96%',       'kategori' => 'Cairan',  'stok' => 50, 'satuan' => 'ml'],
            ['nama_bahan' => 'Aquades',          'kategori' => 'Cairan',  'stok' => 100,'satuan' => 'ml'],
            ['nama_bahan' => 'Kertas Saring',    'kategori' => 'Padat',   'stok' => 100,'satuan' => 'lembar'],
            ['nama_bahan' => 'NaCl',             'kategori' => 'Padat',   'stok' => 500,'satuan' => 'gram'],
            ['nama_bahan' => 'Glukosa',          'kategori' => 'Padat',   'stok' => 250,'satuan' => 'gram'],
            ['nama_bahan' => 'Asam Sulfat',      'kategori' => 'Cairan',  'stok' => 200,'satuan' => 'ml'],
            ['nama_bahan' => 'NaOH',             'kategori' => 'Padat',   'stok' => 300,'satuan' => 'gram'],
            ['nama_bahan' => 'Kertas Lakmus',    'kategori' => 'Padat',   'stok' => 50, 'satuan' => 'lembar'],
        ];

        foreach ($bahans as $b) {
            Bahan::create($b);
        }

        // ============ CONTOH TRANSAKSI ============
        $alatPertama = Alat::first();
        $bahanPertama = Bahan::first();

        Peminjaman::create([
            'mahasiswa_id'    => $mhs1->id,
            'alat_id'         => $alatPertama->id,
            'tanggal_pinjam'  => now()->subDays(2),
            'jumlah'          => 2,
            'praktikum'       => 'Farmakognosi',
            'status'          => 'dipinjam',
            'keterangan'      => null,
        ]);

        Peminjaman::create([
            'mahasiswa_id'    => $mhs2->id,
            'alat_id'         => $alatPertama->id,
            'tanggal_pinjam'  => now()->subDay(),
            'jumlah'          => 1,
            'praktikum'       => 'Kimia Farmasi',
            'status'          => 'menunggu',
        ]);

        Pemakaian::create([
            'mahasiswa_id'   => $mhs1->id,
            'bahan_id'       => $bahanPertama->id,
            'tanggal_pakai'  => now(),
            'semester'       => '3',
            'praktikum'      => 'Farmakognosi',
            'jumlah'         => 100,
            'status'         => 'menunggu',
        ]);
    }
}