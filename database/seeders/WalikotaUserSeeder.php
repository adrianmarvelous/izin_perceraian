<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class WalikotaUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['username' => 'walikota'],
            [
                'name' => 'Walikota',
                'email' => 'walikota@example.com',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole('walikota');

        $this->command->info('Akun walikota berhasil dibuat (username: walikota, password: password).');
    }
}
