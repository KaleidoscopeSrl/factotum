<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

class CreateSymbolicLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factotum:symlinks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symbolink links from storage to public';

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
    	if ( !file_exists(public_path('media')) ) {
			symlink( storage_path('app/media'), public_path('media') );
		}
		if ( !file_exists(public_path('avatars')) ) {
			symlink( storage_path('app/avatars'), public_path('avatars') );
		}
    }
}
