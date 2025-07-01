<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';
    protected $keyType = 'string';


    protected $fillable = ['jumlah_pinjaman', 'tenor', 'suku_bunga', 'status', 'grup_id'];

    protected function grup()
    {
        return $this->belongsTo(Grup::class);
    }
    protected function status_histori_pinjaman()
    {
        return $this->belongsTo(StatusHistoriPinjaman::class);
    }
}
