<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';
    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = ['jumlah_pinjaman', 'tenor', 'suku_bunga', 'status', 'grup_id'];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id', 'id');
    }
    public function pencairan_dana()
    {
        return $this->belongsTo(PencairanDana::class, 'pinjaman_id', 'id');
    }
    public function status_histori_pinjaman()
    {
        return $this->belongsTo(StatusHistoriPinjaman::class, 'pinjaman_id', 'id');
    }
}
