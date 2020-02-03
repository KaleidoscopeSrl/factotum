<?php

namespace Kaleidoscope\Factotum\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;


class CapabilityContentTypeScope implements Scope
{

	/**
	 * Apply the scope to a given Eloquent query builder.
	 *
	 * @param  \Illuminate\Database\Eloquent\Builder  $builder
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @return void
	 */
	public function apply(Builder $builder, Model $model)
	{
		var_dump(Auth::user());
//		if ( request()->attributes->get('role') == 'admin' ) {
//			$builder->with('company');
//		} else {
//			if ( request()->attributes->get('company_id') ) {
//				$builder->where( $model->getTable() . '.company_id', request()->attributes->get('company_id') );
//			}
//		}
	}

}
