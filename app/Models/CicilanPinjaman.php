<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicilanPinjaman extends Model
{
    protected $table = 'cicilan_pinjaman';
    protected $keyType = 'string';


    protected $fillable = ['jumlah_cicilan', 'jatuh_tempo', 'status', 'grup_id'];

    protected function grup()
    {
        return $this->belongsTo(Grup::class);
    }
}
