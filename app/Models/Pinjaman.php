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


    protected $fillable = ['id', 'nominal_pinjaman', 'tenor', 'suku_bunga', 'status_id', 'grup_id', 'jumlah_pinjaman', 'dana_kembali', 'jadwal_pencairan'];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function tenor()
    {
        return $this->belongsTo(Tenor::class, 'tenor', 'id');
    }
    public function suku_bunga()
    {
        return $this->belongsTo(SukuBunga::class, 'suku_bunga', 'id');
    }
}
