<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'first_name' => 'Ayan',
                'last_name' => 'Ganguly',
                'email' => 'admin@test.com',
                'password' => Hash::make('12345678')
            ]
        ];

        User::insert($users);    
    }
}
