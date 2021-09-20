<?php

namespace Kaleidoscope\Factotum\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Composer;


class DumpAutoload extends Command
{

	protected $signature = 'dump-autoload';


	protected $description = 'Regenerate framework autoload files';


	protected $composer;


	public function __construct(Composer $composer)
	{
		parent::__construct();

		$this->composer = $composer;
	}


	public function handle()
	{
		$this->composer->dumpAutoloads();
		$this->composer->dumpOptimized();
	}

}