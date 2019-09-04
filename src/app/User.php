<?php

namespace Kaleidoscope\Factotum;

use Kaleidoscope\Factotum\Notifications\AdminResetPassword as AdminResetPasswordNotification;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role_id', 'filename', 'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function profile() {
		return $this->hasOne('Kaleidoscope\Factotum\Profile');
	}

	public function role() {
		return $this->hasOne('Kaleidoscope\Factotum\Role', 'id', 'role_id');
	}

	/**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	 */
	public function sendPasswordResetNotification($token)
	{
		// TODO: check user role, if he had access to the backend, select different notification
		// based on the role.
		$this->notify(new AdminResetPasswordNotification($token));
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
