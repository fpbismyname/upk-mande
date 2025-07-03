<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenor extends Model
{
    use HasFactory;
    protected $table = 'tenor';

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'nama_tenor', 'waktu_tenor'];
}
