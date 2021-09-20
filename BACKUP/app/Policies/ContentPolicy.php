<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\Capability;
use Kaleidoscope\Factotum\Models\Content;
use Kaleidoscope\Factotum\Models\User;


class ContentPolicy
{

    use HandlesAuthorization;


	private function _checkCapabilityByContentType($user, $contentTypeID)
	{
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();

		if ( $capability ) {
			return ( $user->role->backend_access && $capability && $capability->edit ? true : false );
		}

		abort(404, 'Content not found');
	}


	private function _checkCapabilityByContent( $user, $contentID )
	{
		$content = Content::find($contentID);

		if ( $content ) {
			$capability = Capability::where('role_id', $user->role_id)
									->where('content_type_id', $content->content_type_id)
									->first();
			return ( $user->role->backend_access && $capability && $capability->edit ? true : false );
		}

		abort(404, 'Content not found');
	}


    public function create(User $user)
    {
		$contentTypeID = request()->input('content_type_id');
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
    }


	public function read(User $user, $contentTypeID)
	{
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
	}


	public function readDetail( User $user, $contentID )
	{
		return $this->_checkCapabilityByContent( $user, $contentID );
	}


    public function update(User $user, $contentID)
    {
		return $this->_checkCapabilityByContent( $user, $contentID );
    }


    public function delete(User $user, $contentID)
    {
		return $this->_checkCapabilityByContent( $user, $contentID );
    }

}
