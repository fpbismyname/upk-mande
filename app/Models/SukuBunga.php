<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SukuBunga extends Model
{
    use HasFactory;
    protected $table = 'suku_bunga';

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'jumlah_suku_bunga'];
}
