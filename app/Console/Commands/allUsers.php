<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class allUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'allUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
    echo    User::all();
    }
}
