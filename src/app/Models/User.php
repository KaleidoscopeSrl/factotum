<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Image;

use Kaleidoscope\Factotum\Notifications\ResetPasswordNotification;
use Kaleidoscope\Factotum\Notifications\VerifyEmailNotification;


class User extends Authenticatable implements MustVerifyEmail
{

	use Notifiable;
	use HasApiTokens;


    protected $fillable = [
        'email',
		'password',
		'role_id',
		'avatar',
		'url'
    ];

	protected $hidden = [
		'password',
		'remember_token',
		'updated_at',
		'deleted_at'
	];


	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}


	public function sendEmailVerificationNotification()
	{
		$this->notify(new VerifyEmailNotification);
	}


	public function profile() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Profile');
	}


	public function role() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Role', 'id', 'role_id');
	}


	public function avatar() {
		return $this->hasOne('Kaleidoscope\Factotum\Models\Media', 'id', 'avatar');
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

}
