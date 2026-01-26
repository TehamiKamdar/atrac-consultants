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
                'name' => 'Admin',
                'email' => 'admin@atracconsultants.com',
                'password' => Hash::make('123audi789'), // Hashing the password
                'role' => 'admin', // Assuming 1 is admin
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        for ($i=300; $i < 350; $i++) {
            DB::table('sim_codes')->insert([
                ["code" => $i]
            ]);
        }
        DB::table('sim_codes')->insert([
            ["code"=>370]
        ]);
        DB::table('fields')->insert([
            ['field' => 'Law'],
            ['field' => 'Medicine'],
            ['field' => 'Business Administration'],
            ['field' => 'Computer Science'],
            ['field' => 'Information Technology'],
            ['field' => 'Engineering'],
            ['field' => 'Civil Engineering'],
            ['field' => 'Electrical Engineering'],
            ['field' => 'Mechanical Engineering'],
            ['field' => 'Software Engineering'],
            ['field' => 'Architecture'],
            ['field' => 'Economics'],
            ['field' => 'Accounting & Finance'],
            ['field' => 'Marketing'],
            ['field' => 'Human Resource Management'],
            ['field' => 'Psychology'],
            ['field' => 'Education'],
            ['field' => 'Political Science'],
            ['field' => 'International Relations'],
            ['field' => 'Media & Communication'],
            ['field' => 'Mass Communication'],
            ['field' => 'Journalism'],
            ['field' => 'Islamic Studies'],
            ['field' => 'Biotechnology'],
            ['field' => 'Environmental Sciences'],
            ['field' => 'Pharmacy'],
            ['field' => 'Nursing'],
            ['field' => 'Dentistry'],
        ]);
    }
}
