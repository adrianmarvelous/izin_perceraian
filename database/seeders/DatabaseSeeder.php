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
        $this->call(WalikotaRoleSeeder::class);
        $this->call(WalikotaUserSeeder::class);

        $user = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Admin', 'username' => 'admin', 'password' => bcrypt('password')]
        );
        $user->assignRole('admin');

        $user2 = User::updateOrCreate(
            ['email' => 'user@example.com'],
            ['name' => 'User', 'username' => 'user', 'password' => bcrypt('password')]
        );
        $user2->assignRole('user');

        $this->call(OPDSeeder::class);

        $this->call(PegawaiSeeder::class);

        $this->call(MasterOpdSeeder::class);

        $this->call(GolonganSeeder::class);

        $this->call(StatusIzinPerceraianSeeder::class);

        $this->call(UpdateGolonganPegawaiSeeder::class);
    }
}
