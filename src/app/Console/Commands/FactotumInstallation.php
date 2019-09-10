<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

class FactotumInstallation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'factotum:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Factotum CMS';

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
		$this->call('vendor:publish');

		$this->info('Migration running...');
		$this->call('migrate');
		$this->info('Migration done.');

		$this->info('Seeding running...');
		// TODO: attenzione, potrebbe essere che va lanciato il composer dump-autoload (verificare se esiste un compando di laravel che lo fa in auto
		$this->call('db:seed');
		$this->info('Seeding done.');

		$this->call('passport:install');
		$this->call('factotum:storage');
		$this->call('factotum:symlinks');
    }
}
