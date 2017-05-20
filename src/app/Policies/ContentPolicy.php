<?php

namespace Kaleidoscope\Factotum\Policies;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Content;
use Kaleidoscope\Factotum\Capability;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the content.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\Content  $content
     * @return mixed
     */
    public function view(User $user, $contentTypeID)
    {
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();

		return ( $capability && $capability->edit ? true : false );
    }

    /**
     * Determine whether the user can create contents.
     *
     * @param  \Factotum\User  $user
     * @return mixed
     */
    public function create(User $user, $contentTypeID)
    {
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ( $capability && $capability->edit ? true : false );
    }

    /**
     * Determine whether the user can update the content.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\Content  $content
     * @return mixed
     */
    public function update(User $user, $contentID)
    {
		$content = Content::find($contentID);
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $content->content_type_id)
								->first();
		return ( $capability && $capability->edit ? true : false );
    }

    /**
     * Determine whether the user can delete the content.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\Content  $content
     * @return mixed
     */
    public function delete(User $user, $contentID)
    {
		$content = Content::find($contentID);
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $content->content_type_id)
								->first();
		return ( $capability && $capability->edit ? true : false );
    }
}
