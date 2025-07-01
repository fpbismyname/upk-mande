<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @property string $role_id
 * @property string $nama_lengkap
 * @property string $email
 * @property string $password
 * @property string $id
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama_lengkap',
        'email',
        'password',
        'role_id'
    ];

    // Primary key and key type
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';


    // Dynamics forms for user
    public static function getFieldUser($type = null)
    {
        if ($type === 'login') {
            return [
                [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Alamat Email',
                ],
                [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => 'Password',
                ]
            ];
        }
        if ($type === 'register') {
            return [
                [
                    'name' => 'name',
                    'type' => 'text',
                    'label' => 'Username',
                ],
                [
                    'name' => 'email',
                    'type' => 'email',
                    'label' => 'Alamat Email',
                ],
                [
                    'name' => 'password',
                    'type' => 'password',
                    'label' => 'Password',
                ],
                [
                    'name' => 'password_confirmation',
                    'type' => 'password',
                    'label' => 'Konfirmasi Password',
                ],
            ];
        }
    }

    public function role_user()
    {
        return $this->belongsTo(RoleUser::class, 'role_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
