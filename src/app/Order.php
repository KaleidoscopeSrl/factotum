<?php

namespace Kaleidoscope\Factotum;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

use Kaleidoscope\Factotum\Notifications\NewOrderToCustomerNotification;
use Kaleidoscope\Factotum\Notifications\NewOrderToShopOwnerNotification;
use Kaleidoscope\Factotum\Notifications\OrderStatusChangeToCustomerNotification;


class Order extends Model
{
	use SoftDeletes;


	// STATI:
	// "waiting_payment": ordini da verificare il pagamento (bonifico o fatturazione)
	// "waiting":  ordine da lavorare
	// "payment_accepted": Pagamento accettato
	// "progress": ordine in lavorazione
	// "shipped": ordine spedito
	// "done": ordine completato
	// "canceled": annullato
	// "failed": fallito
	// "refuned": rimborsato

	protected $fillable = [
		'cart_id',
		'customer_id',
		'status',
		'shipping',

		'total_net',
		'total_tax',
		'total_shipping_net',
		'total_shipping_tax',

		'discount_code_id',

		'phone',

		'delivery_address',
		'delivery_address_line_2',
		'delivery_city',
		'delivery_zip',
		'delivery_province',
		'delivery_country',

		'invoice_address',
		'invoice_address_line_2',
		'invoice_city',
		'invoice_zip',
		'invoice_province',
		'invoice_country',

		'payment_type',
		'transaction_id',

		'notes',
		'customer_user_agent',
	];


	protected $hidden = [
		'deleted_at'
	];

	protected $appends = [
		'total',
		'total_shipping'
	];



	// RELATIONS
	public function customer() {
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

	public function products() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Product', 'order_product')
					->withPivot('product_variant_id', 'quantity', 'product_price', 'tax_data');
	}

	public function discount_code() {
		return $this->hasOne('Kaleidoscope\Factotum\DiscountCode', 'id', 'discount_code_id');
	}





	public function setTransactionId( $transactionId = '' )
	{
		if ( $transactionId != '' ) {
			$this->transaction_id = $transactionId;
			$this->status         = 'payment_accepted';
			$this->save();
		}

		return $this;
	}


	public function sendNewOrderNotifications()
	{
		if ( file_exists( app_path('User.php') ) ) {
			$customer = \App\User::with('profile')->find( $this->customer_id );
		} else {
			$customer = User::with('profile')->find( $this->customer_id );
		}

		if ( file_exists(app_path('Notifications/NewOrderToCustomerNotification.php')) ) {
			Notification::send( $customer, new \App\Notifications\NewOrderToCustomerNotification( $customer, $this ) );
		} else {
			Notification::send( $customer, new NewOrderToCustomerNotification( $customer, $this ) );
		}

		$shopManagers = config('factotum.shop_managers');

		if ( count($shopManagers) > 0 ) {
			if ( file_exists(app_path('Notifications/NewOrderToShopOwnerNotification.php')) ) {
				$notification = new \App\Notifications\NewOrderToShopOwnerNotification( $customer, $this );
			} else {
				$notification = new NewOrderToShopOwnerNotification( $customer, $this );
			}

			foreach ( $shopManagers as $shopManager ) {
				Notification::route( 'mail', $shopManager )->notify( $notification );
			}
		}

	}


	public function sendOrderStatusChangeNotification()
	{
		if ( file_exists( app_path('User.php') ) ) {
			$customer = \App\User::with('profile')->find( $this->customer_id );
		} else {
			$customer = User::with('profile')->find( $this->customer_id );
		}

		if ( file_exists(app_path('Notifications/OrderStatusChangeToCustomerNotification.php')) ) {
			Notification::send( $customer, new \App\Notifications\OrderStatusChangeToCustomerNotification( $customer, $this ) );
		} else {
			Notification::send( $customer, new OrderStatusChangeToCustomerNotification( $customer, $this ) );
		}
	}


	// MUTATORS
	public function getTotalAttribute()
	{
		$total  = $this->total_net;
		$total += $this->total_shipping_net;
		$total += $this->total_tax;
		$total += $this->total_shipping_tax;

		return $total;
	}

	public function getTotalNetAttribute($value)
	{
		return (float)$value;
	}

	public function getTotalTaxAttribute($value)
	{
		return (float)$value;
	}
	
	public function getTotalShippingAttribute()
	{
		$totalShipping = 0;
		$totalShipping += $this->total_shipping_net;
		$totalShipping += $this->total_shipping_tax;
		
		return $totalShipping;
	}

	public function getTotalShippingNetAttribute($value)
	{
		return (float)$value;
	}

	public function getTotalShippingTaxAttribute($value)
	{
		return (float)$value;
	}


	public function getCreatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

	public function getUpdatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}
}
