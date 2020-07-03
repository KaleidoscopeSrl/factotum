<?php

namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class AbandonedCartReminderNotification extends Notification
{
    use Queueable;

	public $demTitle;
	public $customer;

    public function __construct( $customer )
    {
		$this->demTitle = 'Carrello Abbandonato';
		$this->level    = 'info';
		$this->customer = $customer;
    }


    public function via($notifiable)
    {
        return ['mail'];
    }


    public function toMail($notifiable)
    {
		$view = 'factotum::notifications.email';
		if ( file_exists( resource_path('views/notifications/email.blade.php') ) ) {
			$view = 'notifications.email';
		}

		$intro = 'Gentile <strong>' . $this->customer->profile->first_name . ' ' . $this->customer->profile->last_name . '</strong>, '
			. 'non hai portato a termine l\'acquisto del tuo carrello.<br>Clicca sul link è termina l\'acquisto.';

		$intro = new HtmlString( $intro );

		return (new MailMessage)
				->markdown( $view )
				->subject( $this->demTitle )
				->line( $intro )
				->action(
					'Completa l\'acquisto',
					url('/auth/login/?abandonedCart=1')
				);
    }


    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
