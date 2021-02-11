<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ForSaleInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install:forsale';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the application.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->callSilent('storage:link');
        $success = File::copyDirectory(public_path('frontend/images'), public_path('storage/images'));

        if ($success) {
            $this->info('Images successfully copied to storage folder.');
        }

        $this->call('migrate:fresh', ['--seed' => true]);

        $this->info('Database seed successfully completed.');
    }
}
