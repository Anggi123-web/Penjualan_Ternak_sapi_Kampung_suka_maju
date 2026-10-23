<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Pak Budi Peternak',
                'email' => 'peternak@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'peternak',
            ],
            [
                'name' => 'Pak Ahmad Pembeli',
                'email' => 'pembeli@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'pembeli',
            ],
            [
                'name' => 'Drh. Siti Mantri',
                'email' => 'mantri@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'mantri_hewan',
            ],
            [
                'name' => 'Drh. Ahmad Fauzi',
                'email' => 'mantri2@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'mantri_hewan',
            ],
            [
                'name' => 'Pak Hasan Pengurus',
                'email' => 'pengurus@gmail.com',
                'password' => bcrypt('password123'),
                'role' => 'pengurus_kampung',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }
    }
}
