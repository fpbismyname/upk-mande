<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencairanDana extends Model
{
    protected $table = 'pencairan_dana';
    protected $keyType = 'string';


    protected $fillable = ['pinjaman_id', 'tanggal_pencairan', 'jumlah_pencairan', 'grup_id', 'keterangan'];

    protected function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
    protected function grup()
    {
        return $this->belongsTo(Grup::class);
    }
}
