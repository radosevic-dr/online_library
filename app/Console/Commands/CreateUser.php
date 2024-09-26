<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    // Add user_type to the signature so it can be passed as a command-line argument (if needed)
    protected $signature = 'user:create {name} {email} {password} {jmbg} {user_type?}';
    protected $description = 'Create a new user in the system';

    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = bcrypt($this->argument('password'));
        $jmbg = $this->argument('jmbg');
        $userType = $this->argument('user_type') ?? 'librarian'; // Default to 'librarian'

        User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'username' => strtolower(str_replace(' ', '', $name)),
            'jmbg' => $jmbg,
            'user_type' => $userType,  // Set the user_type value here
        ]);

        $this->info("User $name has been created successfully as a $userType!");
    }
}
