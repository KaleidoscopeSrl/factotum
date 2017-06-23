<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;

use Kaleidoscope\Factotum\Http\Controllers\Admin\Controller as MainAdminController;
use Kaleidoscope\Factotum\User;

class Controller extends MainAdminController
{
	protected function _save( Request $request, $user, $profile )
	{
		$data = $request->all();

		if ( $request->file('avatar') ) {
			$path = $request->file('avatar')->store('avatars');
			$filename = $this->_saveAvatar( $path );
			$user->filename = $filename;
			$user->avatar   = url( 'avatars/' . $filename );
		}

		$user->email    = $data['email'];
		if ( isset($data['password']) ) {
			$user->password = bcrypt($data['password']);
		}
		$user->role_id = $data['role_id'];
		$user->save();

		$profile->first_name = $data['first_name'];
		$profile->last_name  = $data['last_name'];
		$profile->user_id    = $user->id;
		$profile->save();

		return $user;
	}

	protected function validator(array $data, $userId = false)
	{
		$rules = array(
			'first_name'     => 'required|max:64',
			'last_name'      => 'required|max:64',
			'role_id'        => 'required',
			'email'          => 'required|email|max:128',
		);

		if (!$userId) {
			$rules['email']    = 'required|email|max:128|unique:users';
			$rules['password'] = 'required|min:6|confirmed';

			if ( $data['avatar'] != '' ) {
				$rules['avatar'] = 'required|image';
			}

		} else {
			$user = User::find($userId);
			if ($data['email'] != $user->email) {
				$rules['email'] = 'required|email|max:128|unique:users';
			}
			if ($data['password'] != '') {
				$rules['password'] = 'required|min:6|confirmed';
			}
			if ( $user['avatar'] != '' ) {
				$rules['avatar'] = '';
			}
		}

		return Validator::make($data, $rules);
	}

	private function _saveAvatar( $path )
	{
		$filename = array_reverse( explode('/', $path) )[0];
		$image = Image::make( $path );
		$image->fit( 100, 100, function ($constraint) {
			$constraint->upsize();
		});
		$filename = str_replace( 'jpeg', 'jpg', $filename );
		$image->save( 'avatars/' . $filename, 90 );

		return $filename;
	}
}
