<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;


class FactotumCreateStorageFolders extends Command
{

    protected $signature = 'factotum:storage';


    protected $description = 'Create Factotum folders';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
		Storage::makeDirectory('models');
		Storage::makeDirectory('public/media');
    }

}
