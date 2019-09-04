<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Intervention\Image\Facades\Image;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;
use Kaleidoscope\Factotum\User;

class Controller extends ApiBaseController
{

	protected function _save( Request $request, $user, $profile )
	{
		$data = $request->all();

		$user->email    = $data['email'];
		if ( isset($data['password']) ) {
			$user->password = bcrypt($data['password']);
		}
		$user->role_id = $data['role_id'];
		$user->save();


        if ( $request->hasFile('avatar') && $request->file('avatar')->isValid() ) {

            $filename = 'avatar_' . str_random(10) . '.jpg';

            $request->avatar->storeAs( $user->id, $filename, 'users' );
            $path      = storage_path('app/public/users/' . $user->id . '/' . $filename );

            $img = Image::make( $path );

            $img->fit( 100, 100, function ($constraint) {
                $constraint->upsize();
            });

            $img->save( $path, 90  );

            $user->filename = $filename;
            $user->avatar   = url( 'storage/users/' . $user->id . '/' . $filename );

            $user->save();
        }


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

			if ( isset($data['avatar']) && $data['avatar'] != '' ) {
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


}
