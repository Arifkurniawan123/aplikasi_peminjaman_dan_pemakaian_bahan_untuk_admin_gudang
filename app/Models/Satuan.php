<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    protected $table = 'satuan';

    protected $fillable = ['nama', 'tipe'];

    // ===== SCOPE =====
    public function scopeAlat($query)
    {
        return $query->where('tipe', 'alat');
    }

    public function scopeBahan($query)
    {
        return $query->where('tipe', 'bahan');
    }

    // ===== HELPER =====
    public function isAlat(): bool
    {
        return $this->tipe === 'alat';
    }

    public function isBahan(): bool
    {
        return $this->tipe === 'bahan';
    }
}