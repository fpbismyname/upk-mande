<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string $role
 * @property string $id_role
 */

class RoleUser extends Model
{
    use HasFactory;
    protected $table = 'role_user';
    protected $keyType = 'string';


    protected $fillable = ['nama_role'];

    protected function users()
    {
        return $this->hasMany(User::class);
    }
}
