<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateUserPosition extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:position {email} {position}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update a user\'s position by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $position = $this->argument('position');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }
        
        $user->position = $position;
        $user->save();
        
        $this->info("Position for {$email} updated to: {$position}");
        return 0;
    }
}
