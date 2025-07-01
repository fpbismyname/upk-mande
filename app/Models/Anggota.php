<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table = 'anggota';
    protected $keyType = 'string';

    protected $fillable = ['nik', 'nama_lengkap', 'alamat', 'grup_id'];
    public function grup()
    {
        return $this->belongsTo(Grup::class);
    }
}
