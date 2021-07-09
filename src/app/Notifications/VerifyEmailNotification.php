<?php
namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailBase;


class VerifyEmailNotification extends VerifyEmailBase
{

	public function __construct()
	{
		$this->demTitle = 'Verifica Email';
	}


	public function toMail($notifiable)
	{
		if (static::$toMailCallback) {
			return call_user_func(static::$toMailCallback, $notifiable);
		}

		return  (new MailMessage)
					->markdown('notifications.email')
					->subject( $this->demTitle )
					->line( 'Please click the button below to verify your email address.')
					->action(
						'Verify Email Address',
						$this->verificationUrl($notifiable)
					)
					->line( 'If you did not create an account, no further action is required.' );
	}
}