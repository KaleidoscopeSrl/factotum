<?php

namespace Kaleidoscope\Factotum;

use Kaleidoscope\Factotum\Notifications\AdminResetPassword as AdminResetPasswordNotification;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Kaleidoscope\Factotum\Library\Utility;


class User extends Authenticatable
{
	use HasApiTokens;
	use Notifiable;


    protected $fillable = [
        'email',
		'password',
		'role_id',
		'avatar',
		'url'
    ];

	protected $hidden = [
		'password', 'remember_token',
		'email_verified_at',
		'created_at', 'updated_at', 'deleted_at'
	];


	public function profile() {
		return $this->hasOne('Kaleidoscope\Factotum\Profile');
	}


	public function role() {
		return $this->hasOne('Kaleidoscope\Factotum\Role', 'id', 'role_id');
	}


	public function isAdmin()
	{
		return ($this->role->role == 'admin' ? true : false);
	}


	public function canConfigure($contentTypeID)
	{
		$capability = Capability::where('role_id', $this->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ($capability && $capability->configure ? true : false);
	}


	public function canEdit($contentTypeID)
	{
		$capability = Capability::where('role_id', $this->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ($capability && $capability->edit ? true : false);
	}


	public function canPublish($contentTypeID)
	{
		$capability = Capability::where('role_id', $this->role_id)
								->where('content_type_id', $contentTypeID)
								->first();
		return ($capability && $capability->publish ? true : false);
	}


	public function setAvatar($request)
	{
		if ( $request->hasFile('avatar') && $request->file('avatar')->isValid() ) {

			$path           = $request->file('avatar')->store('avatars');
			$path           = storage_path( 'app/' . $path);
			$this->avatar   = url( 'avatars/' . Utility::saveAvatar( $path ) );

		} else if ( $request->input('avatar') ) {

			$avatar       = $request->input('avatar');
			$imageData    = base64_decode( substr( $avatar, strpos( $avatar, ',') + 1) );
			$jpgName      = Str::random(8) . '.jpg';
			$path         = storage_path('app/public/avatars/' . $jpgName);

			Storage::disk('avatars')->put( $jpgName, $imageData, 'public');

			$this->avatar = url( 'storage/avatars/' . Utility::saveAvatar( $path ) );

		}
	}


}
