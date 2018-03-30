<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Media;

class MediaPolicy
{
    use HandlesAuthorization;

	public function view(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function create(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function update(User $user)
	{
		return ( $user->role->backend_access && $user->role->manage_media ? true : false );
	}

	public function delete(User $user, $filename)
	{
		if ( $user->role->backend_access && $user->role->manage_media ) {
			$media = Media::whereFilename($filename)->whereUserId($user->id)->get();
			return ( count($media) > 0 ? true : false );
		}
		return false;
	}

}
