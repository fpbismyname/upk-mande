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
        'id',
        'nama_grup',
        'limit_pinjaman',
        'status_id',
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
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id', 'id');
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'ketua_user_id', 'id');
    }
}
