<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Volume alat (dari Excel Inventarisasi Alat Gelas)
            '0,5 mL',
            '1 mL',
            '2 mL',
            '2,5 mL',
            '3 mL',
            '4 mL',
            '5 mL',
            '6 mL',
            '7 mL',
            '8 mL',
            '9 mL',
            '10 mL',
            '15 mL',
            '20 mL',
            '25 mL',
            '30 mL',
            '50 mL',
            '100 mL',
            '250 mL',
            '500 mL',
            '1000 mL',

            // Non-volume (alat)
            'pcs',

            // Bahan
            'g',
            'mg',
            'mL',
            'pack',
            'botol',
        ];

        foreach ($data as $nama) {
            Satuan::create(['nama' => $nama]);
        }
    }
}