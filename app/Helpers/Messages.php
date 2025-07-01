<?php

namespace App\Helpers;

class Messages
{
    public static $register = [
        'success' => [
            'message' => 'Akun berhasil terdaftar. Silahkan ajukan pinjaman untuk proses lebih lanjut.',
            'type' => 'success',
        ],
        'failed' => [
            'message' => 'Proses daftar akun gagal. Silahkan coba lagi.',
            'type' => 'error',
        ],
    ];
    public static $login = [
        'success' => [
            'message' => 'Login berhasil.',
            'type' => 'success',
        ],
        'invalid_creds' => [
            'message' => 'Email atau password salah.',
            'type' => 'error',
        ],
        'failed' => [
            'message' => 'Proses login akun gagal. Silahkan coba lagi.',
            'type' => 'error',
        ]
    ];
    public static $server = [
        'error' => [
            'message' => 'Terjadi kesalahan pada sistem kami. Silahkan coba lagi di lain waktu.',
            'type' => 'error',
        ]
    ];
}
