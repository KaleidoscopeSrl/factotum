<?php

namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BasicNotification extends Notification
{
    use Queueable;

    public $demTitle;


    public function __construct()
    {
    }

}
