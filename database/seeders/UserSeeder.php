<?php

namespace Database\Seeders;

use App\Helpers\General;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataUser = [
            [
                'id' => "US" . General::generateId(),
                'name' => 'Muhammad Ghani',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($dataUser as $itemUser) {
            User::create($itemUser);
        }
    }
}
