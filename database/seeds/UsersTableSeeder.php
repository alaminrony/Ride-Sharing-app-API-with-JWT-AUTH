<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'email_verified_at' => now(),
            'phone' => 'admin@email.com',
            'gender' => 'admin@email.com',
            'status' => 'admin@email.com',
            'activation_code' => 'admin@email.com',
            'ip_address' => 'admin@email.com',
            'last_ip_address' => 'admin@email.com',
            'group_id' => 'admin@email.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
