<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    protected $table = 'bahan';

    protected $fillable = [
        'nama_bahan',
        'kategori',
        'stok',
        'stok_botol',
        'isi_per_botol',
        'satuan',
        'biaya',          
    ];

    protected $casts = [
        'stok'          => 'integer',
        'stok_botol'    => 'integer',
        'isi_per_botol' => 'integer',
        'biaya'         => 'decimal:2',   
    ];

    // ===== ACCESSOR =====
    public function getTotalStokAttribute(): int
    {
        return ($this->stok_botol * $this->isi_per_botol) + $this->stok;
    }

    public function getStokLabelAttribute(): string
    {
        $parts = [];

        if ($this->stok_botol > 0) {
            $parts[] = $this->stok_botol . ' botol';
        }

        if ($this->stok > 0) {
            $parts[] = $this->stok . ' ' . $this->satuan;
        }

        return $parts ? implode(' + ', $parts) : '0 ' . $this->satuan;
    }

    // Total nilai bahan = stok × biaya
    public function getTotalNilaiAttribute(): float
    {
        return $this->stok * $this->biaya;
    }
}