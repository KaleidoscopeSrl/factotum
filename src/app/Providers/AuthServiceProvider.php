<?php

namespace Kaleidoscope\Factotum\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
	    'Kaleidoscope\Factotum\Models\User'    => 'Kaleidoscope\Factotum\Policies\UserPolicy'
    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
	    $this->registerAuthorizations();
    }


	/**
	 *
	 */
    protected function registerAuthorizations()
    {
		// Gate::define('company.is.mine', CompanyPolicy::class . '@isMine');
    }

}
