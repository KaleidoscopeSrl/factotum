<?php

namespace Kaleidoscope\Factotum\Filters;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\Models\Capability;


trait CapabilityContentTypeFilter {

	public function scopeCapabilityFilter($query)
	{
		$user = Auth::user();

		if ( !$user->isAdmin() ) {
			$capabilities = Capability::where( 'role_id', $user->role->id )->get();

			$filterContentTypes = [];
			if ( $capabilities->count() > 0 ) {
				foreach ( $capabilities as $cap ) {
					$filterContentTypes[] = $cap->content_type_id;
				}
			}

			$query->whereIn( 'id', $filterContentTypes );
		}

		return $query;
	}

}