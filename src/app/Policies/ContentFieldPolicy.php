<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\ContentField;
use Kaleidoscope\Factotum\Capability;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContentFieldPolicy
{
    use HandlesAuthorization;


    /**
     * Determine whether the user can view the contentField.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\ContentField  $contentField
     * @return mixed
     */
    public function view(User $user)
    {
		return ( $user->role->backend_access && $user->role->manage_content_types ? true : false );
    }

    /**
     * Determine whether the user can create contentFields.
     *
     * @param  \Factotum\User  $user
     * @return mixed
     */
    public function create(User $user, $contentTypeID)
    {
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ( $capability && $capability->configure ? true : false );
    }

    /**
     * Determine whether the user can update the contentField.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\ContentField  $contentField
     * @return mixed
     */
    public function update(User $user, $contentTypeID)
    {
		$capability = Capability::where('role_id', $user->role_id)
								 ->where('content_type_id', $contentTypeID)
								 ->first();
		return ( $capability && $capability->configure ? true : false );
    }

    /**
     * Determine whether the user can delete the contentField.
     *
     * @param  \Factotum\User  $user
     * @param  \Factotum\ContentField  $contentField
     * @return mixed
     */
    public function delete(User $user, $contentFieldId)
    {
		$contentField = ContentField::find( $contentFieldId );
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentField->content_type_id)
								->first();
		return ( $capability && $capability->configure ? true : false );
    }

}
