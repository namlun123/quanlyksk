<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HashPasswords extends Command
{
    protected $signature = 'hash:passwords';
    protected $description = 'Rehash all user passwords in the database.';

    public function handle()
    {
        $users = User::all();

        foreach ($users as $user) {
            if (!Hash::needsRehash($user->password)) {
                $user->password = Hash::make($user->password); // Hash the password
                $user->save(); // Update the database
            }
        }

        $this->info('Passwords have been hashed.');
    }
}

