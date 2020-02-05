<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

class FactotumInstallation extends Command
{

	protected $signature = 'factotum:install';


	protected $description = 'Install Factotum CMS';


	public function __construct()
	{
		parent::__construct();
	}


	public function handle()
	{
		if ( $this->confirm('Are you sure?') ) {

			$this->info('Cleaning up Laravel scaffolding...');
			$this->call('factotum:clean-laravel-scaffolding');
			$this->info('Clean up done.');

			$this->call('vendor:publish', [ '--tag' => 'factotum' ]);
			$this->call('dump-autoload');

			$this->info('Migration running...');
			$this->call('migrate');
			$this->info('Migration done.');

			$this->info('Seeding running...');
			$this->call('db:seed');
			$this->info('Seeding done.');

			$this->call('passport:install');
			$this->call('factotum:storage');
			$this->call('factotum:symlinks');

		}

	}

}
