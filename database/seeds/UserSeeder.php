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
                'email' => 'kajur@if.com',
                'password' => Hash::make('12345'),
                'role' => 'Kajur',
                'status' => true
            ],
            [
                'name' => 'Bendahara',
                'email' => 'bendahara@if.com',
                'password' => Hash::make('12345'),
                'role' => 'Bendahara',
                'status' => true
            ],
            [
                'name' => 'PAJ',
                'email' => 'paj@if.com',
                'password' => Hash::make('12345'),
                'role' => 'PAJ',
                'status' => true
            ],
        ];

        User::insert($users);
    }
}
