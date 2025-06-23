<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Tehami',
                'email' => 'tehami@atracconsultants.com',
                'password' => Hash::make('12345678'), // Hashing the password
                'role' => 1, // Assuming 1 is admin
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Uzair',
                'email' => 'uzair@atracconsultants.com',
                'password' => Hash::make('123audi789'), // Hashing the password
                'role' => 1, // Assuming 0 is regular user
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kamran',
                'email' => 'kamran@atracconsultants.com',
                'password' => Hash::make('123audi789'), // Hashing the password
                'role' => 1, // Assuming 0 is regular user
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
