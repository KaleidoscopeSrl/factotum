<?php

namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;


class ResetPasswordNotification extends BasicNotification
{

	public function __construct($token)
	{
		$this->token    = $token;
		$this->demTitle = 'Reset Password';
	}

	public function via($notifiable)
	{
		return ['mail'];
	}


    public function toMail($notifiable)
    {
		$url = url(route('password.reset', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));

        return  (new MailMessage)
						->markdown('notifications.email')
						->subject( $this->demTitle )
						->line(Lang::get('You are receiving this email because we received a password reset request for your account.'))
						->action(Lang::get('Reset Password'), $url)
						->line(Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
						->line(Lang::get('If you did not request a password reset, no further action is required.'));
    }


}
