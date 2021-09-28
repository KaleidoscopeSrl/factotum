<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Support\Arr;
use Illuminate\Container\Container as Application;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Class Skeleton
 * @package Kaleidoscope\Factotum
 */
class Skeleton
{
	/**
	 * @var array
	 */
	protected array $config;

	/**
	 * @var Application
	 */
	protected Application $app;

	/**
	 * @param Application $app
	 */
	public function __construct(Application $app)
	{
		$this->app    = $app;
		$this->config = config('laravel-skeleton');
	}

	/**
	 * @param string $item
	 * @return array|\ArrayAccess|mixed
	 */
	public function getConfig(string $item)
	{
		return Arr::get($this->config, $item);
	}

	/**
	 * @param $abstract
	 * @param array $parameters
	 * @return mixed|object
	 * @throws BindingResolutionException
	 */
	public function makeInstance($abstract, array $parameters = [])
	{
		return $this->app->make($abstract, $parameters);
	}
}
