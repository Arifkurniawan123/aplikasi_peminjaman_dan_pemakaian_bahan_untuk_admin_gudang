<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        // [nama_alat, kategori, stok, satuan]
        $data = [
            // ===== LABU UKUR =====
            ['Labu Ukur',              'Alat Gelas',    105, '5 mL'],
            ['Labu Ukur',              'Alat Gelas',    210, '10 mL'],
            ['Labu Ukur',              'Alat Gelas',     83, '20 mL'],
            ['Labu Ukur',              'Alat Gelas',     71, '25 mL'],
            ['Labu Ukur',              'Alat Gelas',    117, '50 mL'],
            ['Labu Ukur',              'Alat Gelas',     99, '100 mL'],
            ['Labu Ukur',              'Alat Gelas',     60, '250 mL'],
            ['Labu Ukur',              'Alat Gelas',     32, '500 mL'],
            ['Labu Ukur',              'Alat Gelas',     22, '1000 mL'],

            // ===== GELAS UKUR =====
            ['Gelas Ukur',             'Alat Gelas',     43, '5 mL'],
            ['Gelas Ukur',             'Alat Gelas',     29, '10 mL'],
            ['Gelas Ukur',             'Alat Gelas',     63, '25 mL'],
            ['Gelas Ukur',             'Alat Gelas',     58, '50 mL'],
            ['Gelas Ukur',             'Alat Gelas',     32, '100 mL'],
            ['Gelas Ukur',             'Alat Gelas',     16, '250 mL'],
            ['Gelas Ukur',             'Alat Gelas',      8, '500 mL'],
            ['Gelas Ukur',             'Alat Gelas',      8, '1000 mL'],

            // ===== BEAKER GLASS =====
            ['Beaker Glass',           'Alat Gelas',    157, '50 mL'],
            ['Beaker Glass',           'Alat Gelas',    239, '100 mL'],
            ['Beaker Glass',           'Alat Gelas',     20, '250 mL'],
            ['Beaker Glass',           'Alat Gelas',     33, '500 mL'],
            ['Beaker Glass',           'Alat Gelas',     28, '1000 mL'],

            // ===== ERLENMEYER =====
            ['Erlenmeyer',             'Alat Gelas',     71, '50 mL'],
            ['Erlenmeyer',             'Alat Gelas',     38, '100 mL'],
            ['Erlenmeyer',             'Alat Gelas',     99, '250 mL'],
            ['Erlenmeyer',             'Alat Gelas',     29, '1000 mL'],

            // ===== PIPET VOLUMETRIK =====
            ['Pipet Volumetrik',       'Alat Ukur',      38, '0,5 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      65, '1 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      37, '2 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      15, '2,5 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      48, '3 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      42, '4 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      63, '5 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      27, '6 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      23, '7 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      26, '8 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      20, '9 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      56, '10 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      18, '15 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      21, '20 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      33, '25 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      20, '30 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      31, '50 mL'],
            ['Pipet Volumetrik',       'Alat Ukur',      16, '100 mL'],

            // ===== PIPET UKUR =====
            ['Pipet Ukur',             'Alat Ukur',      28, '0,5 mL'],
            ['Pipet Ukur',             'Alat Ukur',      31, '1 mL'],
            ['Pipet Ukur',             'Alat Ukur',      27, '2 mL'],
            ['Pipet Ukur',             'Alat Ukur',      41, '5 mL'],
            ['Pipet Ukur',             'Alat Ukur',      29, '10 mL'],
            ['Pipet Ukur',             'Alat Ukur',      15, '20 mL'],

            // ===== PIKNOMETER =====
            ['Piknometer',             'Alat Ukur',      16, '10 mL'],
            ['Piknometer',             'Alat Ukur',      19, '25 mL'],
            ['Piknometer',             'Alat Ukur',       2, '50 mL'],

            // ===== CORONG PISAH =====
            ['Corong Pisah',           'Alat Gelas',     33, '100 mL'],
            ['Corong Pisah',           'Alat Gelas',     24, '250 mL'],

            // ===== TANPA VOLUME (satuan: pcs) =====
            ['Gelas Arloji',           'Alat Gelas',     55, 'pcs'],
            ['Baki Lempeng',           'Alat Pendukung', 35, 'pcs'],
            ['Iodin Flask',            'Alat Gelas',     85, 'pcs'],
            ['Rak Tabung',             'Alat Pendukung', 58, 'pcs'],
            ['Botol Timbang',          'Alat Gelas',     22, 'pcs'],
            ['Krus Porselen',          'Alat Pendukung', 46, 'pcs'],
            ['Sikat',                  'Alat Pendukung',120, 'pcs'],
            ['Cawan Uap',              'Alat Gelas',     71, 'pcs'],
            ['Bunsen',                 'Alat Pemanas',   28, 'pcs'],
            ['Plat Tetes',             'Alat Gelas',     39, 'pcs'],
            ['Cawan Petri',            'Alat Gelas',    351, 'pcs'],
            ['Mortir',                 'Alat Gelas',     59, 'pcs'],
            ['Chamber Kecil',          'Alat Pendukung',  6, 'pcs'],
            ['Hair Dryer',             'Alat Pemanas',   28, 'pcs'],
            ['Klem Buret',             'Alat Logam',     40, 'pcs'],
            ['Klem Jepit',             'Alat Logam',     38, 'pcs'],
            ['Ring Bulat',             'Alat Logam',     93, 'pcs'],
            ['Kawat Kasa',             'Alat Logam',     15, 'pcs'],
            ['Vial',                   'Alat Gelas',    130, 'pcs'],
            ['Corong Besar',           'Alat Gelas',     36, 'pcs'],
            ['Corong Kecil',           'Alat Gelas',     68, 'pcs'],
            ['Dongkrak',               'Alat Pendukung', 19, 'pcs'],
            ['Labu Alas Bulat',        'Alat Gelas',     28, 'pcs'],
            ['Labu Jantung',           'Alat Gelas',     15, 'pcs'],
            ['Kompor',                 'Alat Pemanas',    9, 'pcs'],
            ['Pipet Filler',           'Alat Pendukung', 35, 'pcs'],
            ['Batang Pengaduk',        'Alat Gelas',    107, 'pcs'],
            ['Sendok Tanduk',          'Alat Pendukung', 32, 'pcs'],
            ['Pinset',                 'Alat Logam',     59, 'pcs'],
            ['Krus Tang',              'Alat Logam',     27, 'pcs'],
            ['Baskom',                 'Alat Pendukung',103, 'pcs'],
            ['Ose',                    'Alat Logam',     38, 'pcs'],
            ['Kolom',                  'Alat Gelas',      8, 'pcs'],
            ['Batang Magnet',          'Alat Pendukung', 68, 'pcs'],
            ['Spatel',                 'Alat Logam',     27, 'pcs'],
            ['Penjepit Kayu',          'Alat Pendukung', 44, 'pcs'],
            ['Parutan',                'Alat Pendukung', 45, 'pcs'],
            ['Saringan',               'Alat Pendukung',  2, 'pcs'],
            ['Tabung Reaksi Kecil',    'Alat Gelas',    321, 'pcs'],
            ['Tabung Reaksi Besar',    'Alat Gelas',    305, 'pcs'],
            ['Tutup Tabung Reaksi',    'Alat Gelas',    165, 'pcs'],
            ['Erlenmeyer Bertutup',    'Alat Gelas',     57, 'pcs'],
            ['Botol Semprot',          'Alat Gelas',     42, 'pcs'],
        ];

        foreach ($data as $d) {
            Alat::create([
                'nama_alat' => $d[0],
                'kategori'  => $d[1],
                'stok'      => $d[2],
                'satuan'    => $d[3],
            ]);
        }
    }
}