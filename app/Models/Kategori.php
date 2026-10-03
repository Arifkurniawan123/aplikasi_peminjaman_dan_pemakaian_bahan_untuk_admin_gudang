<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';

    protected $fillable = ['nama', 'tipe'];

    public function scopeAlat($query)
    {
        return $query->where('tipe', 'alat');
    }

    public function scopeBahan($query)
    {
        return $query->where('tipe', 'bahan');
    }
    public function isAlat(): bool
    {

        return $this->tipe === 'alat';
    }

    public function isBahan(): bool
    {

        return $this->tipe === 'bahan';
    }
}
