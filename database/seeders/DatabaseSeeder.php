<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin Operasional – akun default untuk testing
        User::updateOrCreate(
            ['email' => 'admin@wtrack.co.id'],
            [
                'name'              => 'Admin Operasional',
                'email'             => 'admin@wtrack.co.id',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Tambahan user teknisi
        User::updateOrCreate(
            ['email' => 'teknisi@wtrack.co.id'],
            [
                'name'              => 'Teknisi Workshop',
                'email'             => 'teknisi@wtrack.co.id',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
