<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;

class FactotumInstallation extends Command
{

	protected $signature = 'factotum:install {--reinstall} {--module=}';


	protected $description = 'Install Factotum CMS';


	private $install;
	private $installEcommerce;
	private $installNewsletter;
	private $installPIM;
	private $reInstall;

	private $migrationPath;

	public function __construct()
	{
		parent::__construct();

		$this->install           = false;
		$this->installEcommerce  = false;
		$this->installNewsletter = false;
		$this->installPIM        = false;
		$this->reInstall         = false;
		$this->migrationPath     = 'vendor/kaleidoscope/' . ( env('APP_ENV') == 'local' ? 'dev-' : '')
									. 'factotum/database/migrations';
	}


	private function _resetMigration()
	{
		$this->info('Resetting DB...');

		$paths = [];

		if ( $this->installEcommerce ) {
			$paths[] = $this->migrationPath . '/0000_00_00_000001_factotum_ecommerce_setup.php';
		}

		if ( $this->installNewsletter ) {
			$paths[] = $this->migrationPath . '/0000_00_00_000002_factotum_newsletter_setup.php';
		}

		if ( $this->installPimMapping ) {
			$paths[] = $this->migrationPath . '/0000_00_00_000003_factotum_pim_setup.php';
		}

		$paths[] = $this->migrationPath . '/0000_00_00_000000_factotum_setup.php';

		$this->call('migrate:reset', [
			'--path' => $paths
		]);

		$this->info('DB resetted...', var_dump($paths));
	}


	private function _cleanLaravelScaffolding()
	{
		$this->info('Cleaning up Laravel scaffolding...');
		$this->call('factotum:clean-laravel-scaffolding');
		$this->info('Clean up done.');
	}


	private function _publishVendorAndDump()
	{
		$this->call('vendor:publish', [ '--tag' => 'factotum' ]);
		$this->call('dump-autoload');
	}


	private function _installMigration()
	{
		$this->info('Migration running...');
		$this->call('migrate', [
			'--path' => $this->migrationPath . '/0000_00_00_000000_factotum_setup.php'
		] );
		$this->call('migrate');
		$this->info('Migration done.');

		if ( $this->installEcommerce ) {
			$this->info('eCommerce Migration running...');
			$this->call('migrate', [
				'--path' => $this->migrationPath . '/0000_00_00_000001_factotum_ecommerce_setup.php'
			] );
			$this->info('eCommerce Migration done.');
		}


		if ( $this->installNewsletter ) {
			$this->info('Newsletter Migration running...');
			$this->call('migrate', [
				'--path' => $this->migrationPath . '/0000_00_00_000002_factotum_newsletter_setup.php'
			] );
			$this->info('Newsletter Migration done.');
		}


		if ( $this->installPIM ) {
			$this->info('PIM Migration running...');
			$this->call('migrate', [
				'--path' => $this->migrationPath . '/0000_00_00_000003_factotum_pim_setup.php'
			] );
			$this->info('PIM Migration done.');
		}
	}


	private function _installPassport()
	{
		$this->call('passport:install', [ '--force' => true ]);
	}


	private function _dbSeeding()
	{
		$this->info('Seeding running...');
		$this->call('db:seed');
		$this->info('Seeding done.');

		if ( $this->installEcommerce ) {
			$this->info('eCommerce Seeding running...');
			$this->call('db:seed', [ '--class' => 'EcommerceTableSeeder' ]);
			$this->info('eCommerce Seeding done.');
		}
	}


	private function _factotumUtils()
	{
		$this->call('factotum:storage');
		$this->call('factotum:symlinks');

		$path = base_path('.env');

		if ( file_exists($path) && !env('FACTOTUM_INSTALLED') ) {
			file_put_contents($path, "\n" . 'FACTOTUM_INSTALLED=true', FILE_APPEND);

			if ( $this->installEcommerce ) {
				file_put_contents($path, "\n" . 'FACTOTUM_ECOMMERCE_INSTALLED=true', FILE_APPEND);
			}

			if ( $this->installNewsletter ) {
				file_put_contents($path, "\n" . 'FACTOTUM_NEWSLETTER_INSTALLED=true', FILE_APPEND);
			}
		}
	}


	public function handle()
	{
		$module = $this->option('module');

		if ( $module ) {
			if ( $module == 'pim' ) {
				$this->info('PIM Migration running...');
				$this->call('migrate', [
					'--path' => $this->migrationPath . '/0000_00_00_000003_factotum_pim_setup.php'
				] );
				$this->info('PIM Migration done.');

			} else {

				$this->info('Not supported yet.');
			}

			exit;
		}


		$this->reInstall = $this->option('reinstall');

		if ( $this->confirm('Are you sure?') ) {
			$this->install = true;
		}

		if ( $this->confirm('Do you want to install the eCommerce Module') ) {
			$this->installEcommerce = true;
		}

		if ( $this->confirm('Do you want to install the Newsletter Module') ) {
			$this->installNewsletter = true;
		}

		if ( $this->confirm('Do you want to install the PIM Mapping') ) {
			$this->installPIM = true;
		}


		if ( !$this->install ) {
			$this->info('Nothing to do.');
			exit;
		}

		if ( $this->reInstall ) {
			// TODO: cancellare le tabelle create sui content type (tipo news, page, ecc.)
			$this->_resetMigration();

			// TODO: destroy folders from storage
			// TODO: destroy symlinks
			// TODO: found a way to remove keys from .env
		}

		if ( $this->install ) {
			$this->_cleanLaravelScaffolding();
			$this->_publishVendorAndDump();
			$this->_installMigration();

			$this->_installPassport();

			$this->_dbSeeding();

			$this->_factotumUtils();
		}

	}

}
