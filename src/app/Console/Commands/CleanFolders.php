<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanFolders extends Command
{

	protected $signature = 'factotum:clean-laravel-scaffolding';


	protected $description = 'Clean the default laravel scaffolding files and folders';


	public function __construct()
	{
		parent::__construct();
	}


	public function handle()
	{
		$this->_cleanUpWebRoutes();
		$this->_cleanUpApiRoutes();
		$this->_cleanUpMigrations();
		$this->_cleanUpSeeds();
		$this->_cleanUpUser();
		$this->_cleanUpViews();
		$this->_cleanUpSass();
		$this->_cleanUpJs();
	}


	private function _cleanUpFolder( $folder )
	{
		$files = glob($folder . '/*');

		foreach( $files as $file ) {
			if ( is_file($file) ) {
				unlink($file);
			}
		}
	}

	private function _truncateFile( $file )
	{
		$f = @fopen( $file, 'r+');
		if ( $f !== false ) {
			ftruncate($f, 0);
			fclose($f);
		}
	}

	private function _cleanUpWebRoutes()
	{
		$this->_truncateFile( base_path( 'routes') .'/web.php' );
	}


	private function _cleanUpApiRoutes()
	{
		$this->_truncateFile( base_path( 'routes') .'/api.php' );
	}


	private function _cleanUpMigrations()
	{
		$this->_cleanUpFolder( database_path( 'migrations') );
	}


	private function _cleanUpSeeds()
	{
		$this->_cleanUpFolder( database_path( 'seeds') );
	}


	private function _cleanUpUser()
	{
		if ( is_file( app_path() . '/User.php') ) {
			unlink( app_path() . '/User.php' );
		}
	}


	private function _cleanUpViews()
	{
		$this->_cleanUpFolder( resource_path( 'views') );
	}


	private function _cleanUpSass()
	{
		$this->_cleanUpFolder( resource_path( 'sass') );
		if ( file_exists(resource_path( 'sass')) ) {
			rmdir( resource_path( 'sass') );
		}
	}


	private function _cleanUpJs()
	{
		$this->_cleanUpFolder( resource_path( 'js') );
		if ( file_exists(resource_path( 'js')) ) {
			rmdir( resource_path( 'js') );
		}
	}

}
