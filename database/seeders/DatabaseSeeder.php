<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        $user = User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
        ]);
        $user->assignRole('admin');

        $user2 = User::factory()->create([
            'name' => 'User',
            'username' => 'user',
            'email' => 'user@example.com',
        ]);
        $user2->assignRole('user');

        $this->call(OPDSeeder::class);

        $this->call(PegawaiSeeder::class);

        $this->call(MasterOpdSeeder::class);

        $this->call(GolonganSeeder::class);

        $this->call(UpdateGolonganPegawaiSeeder::class);
    }
}
