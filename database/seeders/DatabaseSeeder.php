<?php

namespace Database\Seeders;

use App\Models\RoleUser;
use App\Models\Status;
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
            'nama_role' => 'keuangan'
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
            'nama_lengkap' => 'Bunda Nisa',
            'role_id' => RoleUser::where('nama_role', 'nasabah')->first()->id,
            'email' => 'Nisa@gmail.com',
            'password' => Hash::make('nisa123')
        ]);

        // Status Factory
        Status::factory()->create([
            'nama_status' => 'disetujui',
        ]);
        Status::factory()->create([
            'nama_status' => 'diproses',
        ]);
        Status::factory()->create([
            'nama_status' => 'dibayar',
        ]);
        Status::factory()->create([
            'nama_status' => 'belum dibayar',
        ]);
        Status::factory()->create([
            'nama_status' => 'ditolak',
        ]);
        Status::factory()->create([
            'nama_status' => 'dibatalkan',
        ]);
        Status::factory()->create([
            'nama_status' => 'aktif',
        ]);
        Status::factory()->create([
            'nama_status' => 'non-aktif',
        ]);
        Status::factory()->create([
            'nama_status' => 'diblokir',
        ]);
    }
}
