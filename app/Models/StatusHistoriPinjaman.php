<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistoriPinjaman extends Model
{

    use HasFactory;
    protected $table = 'status_historio_pinjaman';
    protected $keyType = 'string';


    protected $fillable = ['pinjaman_id', 'status', 'catatan'];

    protected function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }
}
