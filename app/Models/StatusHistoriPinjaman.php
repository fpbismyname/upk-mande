<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistoriPinjaman extends Model
{

    use HasFactory;
    protected $table = 'status_historio_pinjaman';

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = ['pinjaman_id', 'status', 'catatan'];

    protected function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class, 'pinjaman_id', 'id');
    }
}
