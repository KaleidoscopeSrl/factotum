<?php

namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Kaleidoscope\Factotum\Library\Notifications\Messages\AdminMailMessage;

class AdminResetPassword extends Notification
{
    use Queueable;

	public $token;

    public function __construct($token)
    {
		$this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
		return (new AdminMailMessage)
			->line('You are receiving this email because we received a password reset request for your account.')
			->action('Reset Password', url('admin/auth/password/reset', $this->token))
			->line('If you did not request a password reset, no further action is required.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

}
