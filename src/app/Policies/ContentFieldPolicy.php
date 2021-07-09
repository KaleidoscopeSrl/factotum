<?php

namespace Kaleidoscope\Factotum\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use Kaleidoscope\Factotum\Models\Capability;
use Kaleidoscope\Factotum\Models\ContentField;
use Kaleidoscope\Factotum\Models\User;


class ContentFieldPolicy
{
    use HandlesAuthorization;


	private function _checkCapabilityByContentType($user, $contentTypeID)
	{
		$capability = Capability::where('role_id', $user->role_id)
								->where('content_type_id', $contentTypeID)
								->first();

		if ( $capability ) {
			return ( $user->role->backend_access && $capability && $capability->configure ? true : false );
		}

		abort(404, 'Content Field not found');
	}


	private function _checkCapabilityByContentField( $user, $contentID )
	{
		$contentField = ContentField::find($contentID);

		if ( $contentField ) {
			$capability = Capability::where('role_id', $user->role_id)
										->where('content_type_id', $contentField->content_type_id)
										->first();
			return ( $user->role->backend_access && $capability && $capability->configure ? true : false );
		}

		abort(404, 'Content Field not found');
	}


    public function create( User $user )
    {
		$contentTypeID = request()->input('content_type_id');
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
    }


	public function read( User $user, $contentTypeID )
	{
		return $this->_checkCapabilityByContentType( $user, $contentTypeID );
	}


	public function readDetail( User $user, $contentFieldID )
	{
		return $this->_checkCapabilityByContentField( $user, $contentFieldID );
	}


    public function update( User $user, $contentFieldID )
    {
		return $this->_checkCapabilityByContentField( $user, $contentFieldID );
    }


    public function delete( User $user, $contentFieldID )
    {
		return $this->_checkCapabilityByContentField( $user, $contentFieldID );
    }

}
