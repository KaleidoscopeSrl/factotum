<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;

use Kaleidoscope\Factotum\Notifications\ResetPasswordNotification;
use Kaleidoscope\Factotum\Notifications\VerifyEmailNotification;

use Kaleidoscope\Factotum\Database\Factories\UserFactory;






/**
 * Class User
 * @package Kaleidoscope\Factotum\Models
 */
class User extends BaseModel implements
	AuthenticatableContract,
	AuthorizableContract,
	CanResetPasswordContract
{
	use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
	use HasApiTokens, HasFactory, Notifiable;


	protected static function newFactory()
	{
		return UserFactory::new();
	}


	protected $with = ['profile'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
	    'email',
	    'email_verified_at',
	    'password',
	    'role_id',
	    'editable',
	    'avatar',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function profile() {
		return $this->hasOne(Profile::class, 'user_id', 'id' );
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function role() {
		return $this->hasOne( Role::class, 'id', 'role_id');
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasOne
	 */
	public function avatar() {
		return $this->hasOne(Media::class, 'id', 'avatar');
	}



	public function sendPasswordResetNotification($token)
	{
		$this->notify(new ResetPasswordNotification($token));
	}


	public function sendEmailVerificationNotification()
	{
		$this->notify(new VerifyEmailNotification);
	}

}
