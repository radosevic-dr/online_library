<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AddFirstLibrariand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'librarian:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add the first librarian to the system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->ask('Enter librarian name');
        $username = $this->ask('Enter librarian username');
        $email = $this->ask('Enter librarian email');
        $jmbg = $this->ask('Enter librarian jmbg');
        $password = $this->ask('Enter librarian password min 8 and max 16 characters');

        // ... ask for last name, email, username, jmbg and validate them

        $librarian = new User;
        $librarian->name = $name;
        $librarian->username = $username;
        $librarian->email = $email;
        $librarian->password = $password;
        $librarian->jmbg = $jmbg;
        $librarian->user_type = 'librarian';

        $librarian->save();

        $this->info('First librarian added successfully!');
    }
}
