<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\ContentType;
use Kaleidoscope\Factotum\Models\User;


class ContentTypePolicy
{
    use HandlesAuthorization;


	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_content_types ? true : false );
	}

	public function read(User $user)
	{
		return ( $user->role->backend_access ? true : false );
	}

	public function update(User $user, $contentTypeID)
	{
		$contentType = ContentType::find($contentTypeID);
		return ( $contentType->editable || !$contentType->editable && auth()->user()->isAdmin() ? true : false );
	}

	public function delete(User $user, $contentTypeID)
	{
		$contentType = ContentType::find($contentTypeID);
		return ( $contentType->editable || !$contentType->editable && auth()->user()->isAdmin() ? true : false );
	}

}
