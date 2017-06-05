<?php

namespace Kaleidoscope\Factotum\Library\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage as IlluminateMailMessage;

class AdminMailMessage extends IlluminateMailMessage
{
	/**
	 * The view for the message.
	 *
	 * @var string
	 */
	public $view = [
		'factotum::admin.notifications.email',
		'factotum::admin.notifications.email-plain',
	];

}
