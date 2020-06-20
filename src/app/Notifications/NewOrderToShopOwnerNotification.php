<?php
namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;
use Kaleidoscope\Factotum\OrderProduct;

class NewOrderToShopOwnerNotification extends Notification
{
	use Queueable;

	public $customer;
	public $order;
	public $orderProducts;

	public function __construct( $customer, $order )
	{
		$this->demTitle = 'Gentile ' . env('SHOP_OWNER_NAME') . ', hai ricevuto un nuovo ordine #' . $order->id . ' il '
						. \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $order->created_at)->formatLocalized('%d %B %Y');

		$this->customer      = $customer;
		$this->order         = $order;
		$this->orderProducts = OrderProduct::with('product')->where('order_id', $order->id)->get();
	}


	public function via($notifiable)
	{
		return ['mail'];
	}


	public function toMail($notifiable)
	{
		$view = 'factotum::notifications.new_order';
		if ( file_exists( resource_path('views/notifications/new_order.blade.php') ) ) {
			$view = 'notifications.new_order';
		}

		$intro = 'Hai ricevuto un nuovo ordine da <strong>' . $this->customer->profile->first_name . ' ' . $this->customer->profile->last_name . '</strong>.';
		$intro = new HtmlString( $intro );


		return  (new MailMessage)
					->markdown( $view , [
						'customer'       => $this->customer,
						'order'          => $this->order,
						'orderProducts'  => $this->orderProducts
					])
					->subject( $this->demTitle )
					->line( $intro );
	}


	public function toArray($notifiable)
	{
		return [
			//
		];
	}

}