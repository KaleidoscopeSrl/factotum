<?php

namespace Kaleidoscope\Factotum\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Kaleidoscope\Factotum\Notifications\ResetPasswordNotification;
use Kaleidoscope\Factotum\Notifications\VerifyEmailNotification;
use Laravel\Sanctum\HasApiTokens;


/**
 * Class User
 * @package Kaleidoscope\Factotum\Models
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;


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
	    'editable',
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
		return $this->hasOne(Profile::class );
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
