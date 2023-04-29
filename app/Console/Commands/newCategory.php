<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class newCategory extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newCategory';

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
        $category=new Category();
        $category->name="cars";
        $category->slug="cars-123";
        $category->description="it's all about cars ";
        $category->save();
    }
}
