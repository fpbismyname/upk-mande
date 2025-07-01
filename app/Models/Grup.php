<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grup extends Model
{

    protected $table = 'grup';
    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nama_grup',
        'limit_pinjaman',
        'status',
        'ketua_user_id'
    ];

    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'grup_id', 'id');
    }
    public function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'grup_id', 'id');
    }
    public function cicilan_pinjaman()
    {
        return $this->hasMany(CicilanPinjaman::class, 'grup_id', 'id');
    }
}
