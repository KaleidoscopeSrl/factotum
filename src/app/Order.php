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
		'customer_id',
		'status',

		'phone',

		'delivery_address',
		'delivery_city',
		'delivery_zip',
		'delivery_province',
		'delivery_country',

		'invoice_address',
		'invoice_city',
		'invoice_zip',
		'invoice_province',
		'invoice_country'
	];



	protected $hidden = [
		'deleted_at'
	];


	public function customer() {
		return $this->hasOne('Kaleidoscope\Factotum\User', 'id', 'customer_id');
	}

	public function products() {
		return $this->belongsToMany('Kaleidoscope\Factotum\Product', 'order_product');
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

		Notification::send( $customer, new NewOrderToCustomerNotification( $customer, $this ) );

		$roles = Role::where('manage_orders', 1)->get();

		if ( $roles->count() > 0 ) {
			$tmp = [];
			foreach ($roles as $r ) {
				$tmp[] = $r->id;
			}
			$users = User::whereIn('role_id', $tmp)->get();

			Notification::send( $users, new NewOrderToShopOwnerNotification( $customer, $this ) );
		}
	}


	public function sendOrderStatusChangeNotification()
	{
		if ( file_exists( app_path('User.php') ) ) {
			$customer = \App\User::with('profile')->find( $this->customer_id );
		} else {
			$customer = User::with('profile')->find( $this->customer_id );
		}

		Notification::send( $customer, new OrderStatusChangeToCustomerNotification( $customer, $this ) );
	}


	// MUTATORS
	public function getCreatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}

	public function getUpdatedAtAttribute($value)
	{
		return ( $value ? strtotime($value) * 1000 : null );
	}
}
