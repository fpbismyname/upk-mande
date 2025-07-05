<?php

namespace Database\Seeders;

use App\Models\Pendanaan;
use App\Models\RoleUser;
use App\Models\Status;
use App\Models\SukuBunga;
use App\Models\Tenor;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Role Factory
        RoleUser::factory()->create([
            'nama_role' => 'admin'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'nasabah'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'kepala-institusi'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'divisi-keuangan'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'divisi-pendanaan'
        ]);


        // User Factory
        User::factory()->create([
            'nama_lengkap' => 'adminUpkMande',
            'email' => 'adminUpkMande@gmail.com',
            'role_id' => RoleUser::where('nama_role', 'admin')->first()->id,
            'password' => Hash::make('admin123')
        ]);
        User::factory()->create([
            'nama_lengkap' => 'Nisa',
            'role_id' => RoleUser::where('nama_role', 'nasabah')->first()->id,
            'email' => 'Nisa@gmail.com',
            'password' => Hash::make('nisa123')
        ]);
        User::factory()->create([
            'nama_lengkap' => 'kepalaInstitusi',
            'role_id' => RoleUser::where('nama_role', 'kepala-institusi')->first()->id,
            'email' => 'kepalaInstitusi@gmail.com',
            'password' => Hash::make('kepala123')
        ]);
        User::factory()->create([
            'nama_lengkap' => 'akunKeuangan',
            'role_id' => RoleUser::where('nama_role', 'divisi-keuangan')->first()->id,
            'email' => 'akunKeuangan@gmail.com',
            'password' => Hash::make('keuangan123')
        ]);
        User::factory()->create([
            'nama_lengkap' => 'akunPendanaan',
            'role_id' => RoleUser::where('nama_role', 'divisi-pendanaan')->first()->id,
            'email' => 'akunPendanaan@gmail.com',
            'password' => Hash::make('pendanaan123')
        ]);

        // Status Factory
        Status::factory()->create([
            'nama_status' => 'sudah_dibayar',
            'type_status' => 'cicilan_pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'belum_dibayar',
            'type_status' => 'cicilan_pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'diproses',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'disetujui',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'ditolak',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'dibatalkan',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'belum_lunas',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'sudah_lunas',
            'type_status' => 'pinjaman',
        ]);
        Status::factory()->create([
            'nama_status' => 'aktif',
            'type_status' => 'grup',
        ]);
        Status::factory()->create([
            'nama_status' => 'non-aktif',
            'type_status' => 'grup',
        ]);
        Status::factory()->create([
            'nama_status' => 'diblokir',
            'type_status' => 'grup',
        ]);

        // Pendanaan
        Pendanaan::factory()->create([
            'saldo' => 2000000, // Dua juta rupiah
        ]);

        // Tenor
        Tenor::factory()->create([
            'nama_tenor' => '3 bulan',
            'waktu_tenor' => 3,
        ]);
        Tenor::factory()->create([
            'nama_tenor' => '6 bulan',
            'waktu_tenor' => 6,
        ]);
        Tenor::factory()->create([
            'nama_tenor' => '9 bulan',
            'waktu_tenor' => 9,
        ]);
        // Suku bunga
        SukuBunga::factory()->create([
            'jumlah_suku_bunga' => 18,
        ]);
    }
}
