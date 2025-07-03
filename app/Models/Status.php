<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table = 'status';

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'status_id', 'type_status'];

    protected function pinjaman()
    {
        return $this->hasMany(Pinjaman::class, 'status_id', 'id');
    }
    protected function cicilan_pinjaman()
    {
        return $this->hasMany(CicilanPinjaman::class, 'status_id', 'id');
    }
    protected function grup()
    {
        return $this->hasMany(Grup::class, 'status_id', 'id');
    }
}
