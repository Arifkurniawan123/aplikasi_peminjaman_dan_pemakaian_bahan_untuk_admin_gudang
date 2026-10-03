<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemakaian extends Model
{
    protected $table = 'pemakaian_bahan';

    protected $fillable = [
        'mahasiswa_id',
        'bahan_id',
        'tanggal_pakai',
        'semester',
        'praktikum',
        'jumlah',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pakai' => 'date',
        'jumlah'        => 'integer',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id');
    }

    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDiserahkan($query)
    {
        return $query->where('status', 'diserahkan');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeSelesai($query)
    {
        return $query->whereIn('status', ['diserahkan', 'ditolak']);
    }

    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDiserahkan(): bool
    {
        return $this->status === 'diserahkan';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'   => 'Menunggu Verifikasi',
            'diserahkan' => 'Sudah Diserahkan',
            'ditolak'    => 'Ditolak',
            default      => '-',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'   => 'yellow',
            'diserahkan' => 'green',
            'ditolak'    => 'red',
            default      => 'zinc',
        };
    }
}