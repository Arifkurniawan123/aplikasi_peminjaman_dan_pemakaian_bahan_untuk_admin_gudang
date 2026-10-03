<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ukuran extends Model
{
    protected $table = 'ukuran';

    protected $fillable = ['nama'];

    public function alats()
    {
        return $this->hasMany(Alat::class, 'ukuran_id');
    }
}