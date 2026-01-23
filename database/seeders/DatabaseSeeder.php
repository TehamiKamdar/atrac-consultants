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
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Admin',
        //         'email' => 'admin@atracconsultants.com',
        //         'password' => Hash::make('123audi789'), // Hashing the password
        //         'role' => 'admin', // Assuming 1 is admin
        //         'remember_token' => Str::random(10),
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);
        for ($i=300; $i < 350; $i++) { 
            DB::table('sim_codes')->insert([
                ["code" => $i]
            ]);
        }
        DB::table('sim_codes')->insert([
            ["code"=>370]
        ]);
    }
}
