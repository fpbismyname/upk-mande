<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicilanPinjaman extends Model
{
    protected $table = 'cicilan_pinjaman';
    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['jumlah_cicilan', 'jatuh_tempo', 'status', 'grup_id'];

    public function grup()
    {
        return $this->belongsTo(Grup::class, 'grup_id', 'id');
    }
}
