<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\ContentType;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentTypePolicy
{
    use HandlesAuthorization;


	public function view(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_content_types ? true : false );
	}

	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_content_types ? true : false );
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
