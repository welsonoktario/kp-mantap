<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'Kajur',
                'email' => 'kajur@kp.com',
                'password' => Hash::make('123'),
                'role' => 'Kajur',
                'status' => true
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@kp.com',
                'password' => Hash::make('123'),
                'role' => 'Bendahara',
                'status' => true
            ],
            [
                'name' => 'PAJ',
                'email' => 'paj@kp.com',
                'password' => Hash::make('123'),
                'role' => 'PAJ',
                'status' => true
            ],
        ];

        User::insert($users);
    }
}
