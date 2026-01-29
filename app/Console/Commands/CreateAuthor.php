<?php

namespace App\Console\Commands;

use App\Models\Author;
use Illuminate\Console\Command;

class CreateAuthor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'author:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new author';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $firstName = $this->ask('First name');
        $lastName = $this->ask('Last name');

        if ($this->confirm("Do you want to create the author: {$firstName} {$lastName}?", true)) {
            Author::create([
                'first_name' => $firstName,
                'last_name' => $lastName,
            ]);

            $this->info("Author has been created.");
        } else {
            $this->warn('Operation cancelled.');
        }
    }
}
