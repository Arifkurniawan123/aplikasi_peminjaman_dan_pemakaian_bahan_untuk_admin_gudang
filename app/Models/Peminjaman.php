<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman_alat';

    protected $fillable = [
        'mahasiswa_id',
        'alat_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'jumlah',
        'jumlah_kembali',
        'praktikum',
        'status',
        'kondisi_kembali',
        'keterangan',
    ];

    protected $casts = [
        'tanggal_pinjam'  => 'date',
        'tanggal_kembali' => 'date',
        'jumlah'          => 'integer',
        'jumlah_kembali'  => 'integer',
    ];

    // ===== RELASI =====
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'alat_id');
    }

    // ===== SCOPE =====
    public function scopeMenunggu($query)
    {
        return $query->where('status', 'menunggu');
    }

    public function scopeDipinjam($query)
    {
        return $query->where('status', 'dipinjam');
    }

    public function scopeSebagian($query)
    {
        return $query->where('status', 'sebagian');
    }

    public function scopeDikembalikan($query)
    {
        return $query->where('status', 'dikembalikan');
    }

    public function scopeDitolak($query)
    {
        return $query->where('status', 'ditolak');
    }

    public function scopeSelesai($query)
    {
        return $query->whereIn('status', ['dikembalikan', 'ditolak']);
    }

    public function scopeAktif($query)
    {
        return $query->whereIn('status', ['dipinjam', 'sebagian']);
    }

    // ===== HELPER STATUS =====
    public function isMenunggu(): bool
    {
        return $this->status === 'menunggu';
    }

    public function isDipinjam(): bool
    {
        return $this->status === 'dipinjam';
    }

    public function isSebagian(): bool
    {
        return $this->status === 'sebagian';
    }

    public function isDikembalikan(): bool
    {
        return $this->status === 'dikembalikan';
    }

    public function isDitolak(): bool
    {
        return $this->status === 'ditolak';
    }

    public function isSelesai(): bool
    {
        return in_array($this->status, ['dikembalikan', 'ditolak']);
    }

    public function isAktif(): bool
    {
        return in_array($this->status, ['dipinjam', 'sebagian']);
    }

    // ===== HELPER PENGEMBALIAN =====
    public function sisaBelumKembali(): int
    {
        return $this->jumlah - $this->jumlah_kembali;
    }

    public function sudahKembaliSemua(): bool
    {
        return $this->jumlah_kembali >= $this->jumlah;
    }

    // ===== ACCESSOR =====
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'Menunggu Verifikasi',
            'dipinjam'     => 'Sedang Dipinjam',
            'sebagian'     => 'Dikembalikan Sebagian',
            'dikembalikan' => 'Sudah Dikembalikan',
            'ditolak'      => 'Ditolak',
            default        => '-',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'menunggu'     => 'yellow',
            'dipinjam'     => 'blue',
            'sebagian'     => 'orange',
            'dikembalikan' => 'green',
            'ditolak'      => 'red',
            default        => 'zinc',
        };
    }
}