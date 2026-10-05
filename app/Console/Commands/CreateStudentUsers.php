<?php

namespace App\Console\Commands;

use App\Models\students;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateStudentUsers extends Command
{
    protected $signature = 'students:create-users';

    protected $description = 'Create user accounts for existing students';

    public function handle()
    {
        $students = students::whereNull('user_id')->get();

        if ($students->isEmpty()) {
            $this->info('No students found without a user account.');
            return Command::SUCCESS;
        }

        foreach ($students as $student) {

            $username = Str::random(10);
            $counter = 1;

            while (User::where('username', $username)->exists()) {
                $username = $username . $counter;
                $counter++;
            }

            // Email
            $email = $student->email;

            // Agar email already kisi user ke paas hai
            if ($email && User::where('email', $email)->exists()) {
                $email = null;
            }

            $user = User::create([
                'name' => trim(
                    $student->first_name . ' ' . $student->last_name
                ),
                'username' => $username,
                'email' => $email,
                'password' => Hash::make('Students@atrac$12345'),
                'status' => 'active',
                'user_type' => 'student',
                'must_change_password' => 1,
            ]);

            $student->update([
                'user_id' => $user->id,
                'status' => 'active',
                'account_created' => 1
            ]);

            $this->info(
                "Created user for Student #{$student->id} - {$username}"
            );
        }

        $this->info('Student users created successfully.');

        return Command::SUCCESS;
    }
}