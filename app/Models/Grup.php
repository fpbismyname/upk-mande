<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{

    protected $table = 'grup';
    protected $keyType = 'string';

    protected $fillable = [
        'nama_grup',
        'limit_pinjaman',
        'status',
        'anggota_id',
        'ketua_user_id'
    ];

    public function anggota()
    {
        return $this->hasMany(Anggota::class);
    }
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class);
    }
    public function cicilan_pinjaman()
    {
        return $this->hasMany(CicilanPinjaman::class);
    }
    public function pencairan_dana()
    {
        return $this->hasMany(PencairanDana::class);
    }
}
