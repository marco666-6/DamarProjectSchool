<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(['email' => 'admin@biis.sch.id'], [
            'name'     => 'Administrator BIIS',
            'email'    => 'admin@biis.sch.id',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '08112345678',
            'alamat'   => 'Batam Integrated Islamic School, Batam',
        ]);

        // Sample parent/user accounts
        User::updateOrCreate(['email' => 'orang.tua@gmail.com'], [
            'name'     => 'Budi Santoso',
            'email'    => 'orang.tua@gmail.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
            'phone'    => '08129876543',
            'alamat'   => 'Jl. Sudirman No. 10, Batam Kota',
        ]);

        User::updateOrCreate(['email' => 'parent2@gmail.com'], [
            'name'     => 'Siti Rahayu',
            'email'    => 'parent2@gmail.com',
            'password' => Hash::make('user123'),
            'role'     => 'user',
            'phone'    => '08135551234',
            'alamat'   => 'Jl. Imam Bonjol No. 5, Batu Ampar',
        ]);
    }
}