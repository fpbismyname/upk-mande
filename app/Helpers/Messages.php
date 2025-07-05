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
    public static $pendanaan = [
        'add-success' => [
            'message' => 'Saldo berhasil ditambahkan.',
            'type' => 'success',
        ],
        'add-failed' => [
            'message' => 'Saldo gagal ditambahkan.',
            'type' => 'error',
        ],
        'decrease-success' => [
            'message' => 'Saldo berhasil ditarik.',
            'type' => 'success',
        ],
        'decrease-failed' => [
            'message' => 'Saldo gagal ditarik.',
            'type' => 'error',
        ],
        'insuficient-fund' => [
            'message' => 'Saldo tidak cukup.',
            'type' => 'error',
        ]
    ];
    public static $sukuBunga = [
        'success' => [
            'message' => 'Suku bunga berhasil diubah.',
            'type' => 'success',
        ],
        'failed' => [
            'message' => 'Terjadi kesalahan pada saat mengubah suku bunga.',
            'type' => 'success',
        ]
    ];
    public static $collection = [
        'store' => [
            'success' => [
                'message' => "Data berhasil ditambahkan.",
                'type' => 'success'
            ],
            'failed' => [
                'message' => "Data gagal ditambahkan.",
                'type' => 'error'
            ]
        ],
        'update' => [
            'success' => [
                'message' => "Data berhasil diperbaharui.",
                'type' => 'success'
            ],
            'failed' => [
                'message' => "Data gagal diperbaharui.",
                'type' => 'error'
            ],
            'notFound' => [
                'message' => "Data yang ingin diperbaharui tidak ditemukan.",
                'type' => 'error'
            ],
        ],
        'delete' => [
            'success' => [
                'message' => "Data berhasil dihapus.",
                'type' => 'success'
            ],
            'failed' => [
                'message' => "Data gagal dihapus.",
                'type' => 'error'
            ],
            'notFound' => [
                'message' => "Data yang ingin dihapus tidak ditemukan.",
                'type' => 'error'
            ],
            'onSession' => [
                'message' => "Data tidak dapat dihapus.",
                'type' => 'error'
            ],
        ]
    ];
}
