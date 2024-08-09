<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SpecificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'copy:specs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'copy general specifications to second database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        copyCoreSpecs();
    }
}
