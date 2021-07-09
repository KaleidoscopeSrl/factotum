<?php
namespace Kaleidoscope\Factotum\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\HtmlString;

use Kaleidoscope\Factotum\Models\OrderProduct;


class OrderStatusChangeToCustomerNotification extends Notification
{
	use Queueable;

	public $customer;
	public $order;
	public $orderProducts;

	public function __construct( $customer, $order )
	{
		$this->demTitle = 'Il tuo ordine #' . $order->id . ' del '
						. \Carbon\Carbon::createFromTimestampMs( $order->created_at )->formatLocalized('%d %B %Y') . ' ha cambiato stato.';

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
		$view = 'factotum::notifications.order_status_change';
		if ( file_exists( resource_path('views/notifications/order_status_change.blade.php') ) ) {
			$view = 'notifications.order_status_change';
		}


		$intro = 'Ciao <strong>' . $this->customer->profile->first_name . ' ' . $this->customer->profile->last_name . '</strong>, '
			. 'il tuo ordine ha cambiato stato in <strong>' . Lang::get('factotum::ecommerce_order.' . $this->order->status) . '</strong>.';

		$intro = new HtmlString( $intro );

		$outro = new HtmlString(
			'Per qualsiasi informazione in merito al tuo ordine, ' .
			'puoi contattarci a <a href="mailto:' . env('SHOP_OWNER_EMAIL') . '">' . env('SHOP_OWNER_EMAIL') . '</a>.<br><br>' .
			'Un saluto dal team di ' . env('SHOP_OWNER_NAME')
		);


		return  (new MailMessage)
					->markdown( $view , [
						'customer'       => $this->customer,
						'order'          => $this->order,
						'orderProducts'  => $this->orderProducts
					])
					->subject( $this->demTitle )
					->line( $intro )
					->action('empty', url(''))
					->line( $outro );
	}


	public function toArray($notifiable)
	{
		return [
			//
		];
	}

}