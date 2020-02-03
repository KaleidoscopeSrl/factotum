<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CreateStorageFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factotum:storage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Factotum folders';

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
     * @return mixed
     */
    public function handle()
    {
		Storage::makeDirectory('models');
		Storage::makeDirectory('media');
    }
}
