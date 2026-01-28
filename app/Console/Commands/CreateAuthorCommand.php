<?php

namespace App\Console\Commands;

use App\Models\Author;
use Illuminate\Console\Command;

class CreateAuthorCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-author';

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
        $firstName = $this->ask('What is the author\'s first name?');
        $lastName = $this->ask('What is the author\'s last name?');

        $author = Author::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
        ]);

        $this->info("Author {$author->first_name} {$author->last_name} created successfully!");
    }
}
