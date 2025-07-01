<?php

namespace Database\Seeders;

use App\Models\RoleUser;
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
            'nama_role' => 'member'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'head_of_institution'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'accountant'
        ]);
        RoleUser::factory()->create([
            'nama_role' => 'funding_officer'
        ]);


        // User Factory
        User::factory()->create([
            'nama_lengkap' => 'adminUpkMande',
            'email' => 'adminUpkMande@gmail.com',
            'role_id' => RoleUser::where('nama_role', 'admin')->first()->id_role,
            'password' => Hash::make('admin123')
        ]);
        User::factory()->create([
            'nama_lengkap' => 'Bunda Nisa',
            'role_id' => RoleUser::where('nama_role', 'member')->first()->id_role,
            'email' => 'Nisa@gmail.com',
            'password' => Hash::make('nisa123')
        ]);
    }
}
