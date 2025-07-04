<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistoriPendanaan extends Model
{
    protected $table = 'histori_pinjaman';
    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'catatan',
        'grup_id',
        'status_id',
        'pinjaman_id'
    ];
    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id', 'id');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function grup()
    {
        return $this->belongsTo(Status::class, 'grup_id', 'id');
    }
}
