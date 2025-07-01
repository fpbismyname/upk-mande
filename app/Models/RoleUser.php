<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string $nama_role
 * @property string $id
 */

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'role_user';

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nama_role'];

    protected function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
