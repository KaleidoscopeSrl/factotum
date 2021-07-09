<?php

namespace Kaleidoscope\Factotum\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Kaleidoscope\Factotum\Models\User;


class AuthForgottenPassword extends Mailable
{
    use Queueable, SerializesModels;

	public $user, $password;

	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, $password)
	{
		$this->user     = $user;
		$this->password = $password;
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$subject = 'Factotum - Recupero Password';

		return $this->subject($subject)
					->markdown('email.auth.forgotten_password', [
						'demTitle' => 'Factotum - Recupero Password'
					]);
    }
}


