<?php

namespace Kaleidoscope\Factotum\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use Kaleidoscope\Factotum\Models\User;


class AuthForgottenPassword extends Mailable
{
    use Queueable, SerializesModels;

	public $user;
	public $password;

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
	    $subject          = '[' . config('app.name') . '] - Recupero Password';
	    $data['title']    = 'Recupero Password';
	    $data['user']     = $this->user;
	    $data['password'] = $this->password;

        return $this->from( config('mail.from.address'), config('mail.from.name') )
	                ->subject($subject)
	                ->markdown( 'emails.auth.forgotten_password', $data );
    }
}



