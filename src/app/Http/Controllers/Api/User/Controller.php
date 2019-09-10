<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

use Kaleidoscope\Factotum\Http\Controllers\Api\Controller as ApiBaseController;


class Controller extends ApiBaseController
{

	protected $userRules = [
		'first_name'     => 'required|max:64',
		'last_name'      => 'required|max:64',
		'role_id'        => 'required',
		'email'          => 'required|email|max:128|unique:users,email',
	];


	protected function _validate( $request )
	{
		$id = Route::current()->parameter('id');

		if ( !$id ) {
			$this->userRules['password'] = 'required|min:8';
		} else {
			$this->userRules['email']   .= ',' . $id;

			$password = $request->input('password', null);

			if ( isset($password) && $password != '') {
				$rules['password'] = 'required|min:8';
			}
		}

		$avatar = $request->input('avatar', null);

		if ( isset( $avatar ) && $avatar != '' ) {
			$rules['avatar'] = 'required|image';
		}

		return $this->validate( $request, $this->userRules, $this->messages );
	}


	private function _removeMedia( $filename )
	{
		$filename = parse_url($filename, PHP_URL_PATH);

		if ( file_exists( public_path( $filename ) ) ) {
			$filename = str_replace('/storage/users/', '', $filename);
			Storage::disk('users')->delete( $filename );
		}
	}


	protected function _save( Request $request, $user, $profile )
	{
		$data = $request->all();

		$user->email = $data['email'];

		if ( isset($data['password']) ) {
			$user->password = Hash::make( $data['password'] );
		}

		$user->role_id = $data['role_id'];
		$user->save();


		if ( $request->hasFile('avatar') && $request->file('avatar')->isValid() ) {

			$extension = $request->file('avatar')->getClientOriginalExtension();
			$filename = 'avatar_' . Str::random(4) . '.' . $extension;

			$request->avatar->storeAs( $user->id, $filename, 'users');

			$path = storage_path('app/public/users/' . $user->id . '/' . $filename);

			$img = Image::make( $path );
			$img->fit( 100, 100 );
			$img->save( $path );

			$user->avatar = $filename;
			$user->save();

		} elseif ( $user && $request->input('avatar') != $user->avatar ) {

			$this->_removeMedia( $user->avatar );
			$user->avatar = null;
			$user->save();

		}


		$profile->first_name = $data['first_name'];
		$profile->last_name  = $data['last_name'];
		$profile->user_id    = $user->id;
		$profile->save();

		return $user;
	}



}
