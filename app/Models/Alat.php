<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';

    protected $fillable = [
        'nama_alat',
        'kategori',
        'stok',
        'satuan',
        'ukuran_id',
    ];

    protected $casts = [
        'stok' => 'integer',
    ];

    public function ukuran()
    {
        return $this->belongsTo(Ukuran::class, 'ukuran_id');
    }
}