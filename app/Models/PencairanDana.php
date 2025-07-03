<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PencairanDana extends Model
{
    protected $table = 'pencairan_dana';
    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = ['id', 'pinjaman_id', 'tanggal_pencairan', 'jumlah_pencairan', 'grup_id', 'keterangan'];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id', 'id');
    }
    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id', 'id');
    }
}
