<?php

namespace Kaleidoscope\Factotum\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\Library\PayPalClient;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductVariant;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\Tax;
use Kaleidoscope\Factotum\User;



trait EcommerceUtils
{

	protected $_cartDuration = '+3 days';
	protected $_user;
	protected $_cart;


	protected function _setUser( $user ) {
		$this->_user = $user;
	}


	protected function _setCart( $cart ) {
		$this->_cart = $cart;
	}


	protected function _getUser()
	{
		if ( config('factotum.guest_cart') ) {

			if (!request()->session()->exists('user_id')) {
				$customerRole = Role::where('role', 'customer')->first();

				$user           = new User;
				$user->email    = 'guest_' . Str::random(8) . '@kaleidoscope.it';
				$user->password = bcrypt(Str::random(8));
				$user->role_id  = $customerRole->id;
				$user->editable = true;
				$user->save();

				request()->session()->put('user_id', $user->id);
			} else {
				$userId = request()->session()->get('user_id');
				$user   = User::find($userId);
			}

		} else if ( isset($this->_user) && $this->_user ) {

			$user = $this->_user;

		} else {

			$user = Auth::user();

		}

		return $user;
	}
	

	protected function _getCart( $dontCreateNew = false )
	{
		// try {

			$cart = null;
			$user = $this->_getUser();

			if ( isset($user) && $user ) {

				if ( config('factotum.guest_cart') ) {

					$cartId = request()->session()->get('cart_id');

					if ( $cartId ) {
						$cart = Cart::find( $cartId );
					}

					if ( !$cart && !$dontCreateNew ) {
						$cart = new Cart;

						$cart->customer_id = $user->id;
						$cart->expires_at  = date('Y-m-d H:i:s', strtotime( $this->_cartDuration ) );
						$cart->save();

						request()->session()->put( 'cart_id', $cart->id );
					}

				} else {

					$cart = Cart::where( 'customer_id', $user->id )
								->whereNull( 'order_id' )
								->where( 'expires_at', '>=', date('Y-m-d H:i:s') )
								->first();

					if ( !$cart && !$dontCreateNew ) {
						$cart = new Cart;
						$cart->customer_id = $user->id;
						$cart->expires_at  = date('Y-m-d H:i:s', strtotime( $this->_cartDuration ) );
						$cart->save();
					}

				}

				if ( $cart ) {
					$cart->load('products');
					return $cart;
				}
			}

			return null;

//		} catch ( \Exception $ex ) {
//			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );
//			return view('factotum::errors.500');
//		}
	}


	protected function _getProductCart( $cartId, $productId, $productVariantId = null )
	{
		try {

			$product = Product::find($productId);

			if ( $product->has_variants && $productVariantId ) {
				$productCart = CartProduct::where( 'cart_id', $cartId )
											->where( 'product_id', $productId )
											->where( 'product_variant_id', $productVariantId )
											->first();
			} else {
				$productCart = CartProduct::where( 'cart_id', $cartId )
											->where( 'product_id', $productId )
											->first();
			}

			if ( !$productCart ) {
				$productCart = new CartProduct;
				$productCart->cart_id    = $cartId;
				$productCart->product_id = $productId;
				$productCart->quantity   = 0;

				if ( $product->has_variants && $productVariantId ) {
					$productCart->product_variant_id = $productVariantId;
				}
			}

			return $productCart;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _extendCart()
	{
		try {
			$user = $this->_getUser();

			if ( $user ) {

				$cart = Cart::where( 'customer_id', $user->id )->where('expires_at', '>=', date('Y-m-d H:i:s'))->first();

				if ( $cart ) {
					$cart->expires_at  = date('Y-m-d H:i:s', strtotime( $this->_cartDuration ) );
					$cart->save();
				}
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getCartTotals( $cart = null )
	{
		$total         = 0;
		$totalPartial  = 0;
		$totalTaxes    = 0;
		$totalShipping = 0;
		$totalProducts = 0;
		$totalDiscount = 0;

		if ( isset($cart) ) {

			$cartProducts = CartProduct::where( 'cart_id', $cart->id )->get();

			if ( $cartProducts->count() > 0 ) {
				foreach( $cartProducts as $cp ) {
					$totalProducts += $cp->quantity;
					$totalPartial  += $cp->quantity * $cp->product_price;

					if ( $cp->tax_data ) {
						$tax = $cp->tax_data;

						if ( config('factotum.product_vat_included') ) {
							$totalTaxes   += ( ( $cp->quantity * $cp->product_price ) / 122 * $tax['amount'] );
						} else {
							$totalTaxes += ( ( $cp->quantity * $cp->product_price ) / 100 * $tax['amount'] );
						}
					}
				}

			}

			// Apply discount code
			$discountCode = $this->_getTemporaryDiscountCode();

			if ( $discountCode ) {

				$initialTotalPartial = $totalPartial;
				$initialTotalTaxes   = $totalTaxes;

				if ( $discountCode->type == 'percentage' ) {
					$totalPartial = $totalPartial - ( $totalPartial / 100 * $discountCode->discount );

					if ( $totalPartial < 0 ) {
						$totalPartial = 0;
					}

					$totalTaxes = $totalTaxes - ( $totalTaxes / 100 * $discountCode->discount );
					if ( $totalTaxes < 0 ) {
						$totalTaxes = 0;
					}

				} elseif ( $discountCode->type == 'price' ) {

					if ( $discountCode->discount > $totalPartial ) {
						$totalPartial = 0;
						$totalTaxes = 0;
					} else {
						$perc = $discountCode->discount / $totalPartial * 100;

						$totalPartial = $totalPartial - ( $totalPartial / 100 * $perc );

						if ( $totalPartial < 0 ) {
							$totalPartial = 0;
						}

						$totalTaxes = $totalTaxes - ( $totalTaxes / 100 * $perc );
						if ( $totalTaxes < 0 ) {
							$totalTaxes = 0;
						}
					}

				}

				$partialPart = $initialTotalPartial - $totalPartial;
				if ( !config('factotum.product_vat_included') ) {
					$taxesPart = $initialTotalTaxes - $totalTaxes;
				} else {
					$taxesPart = 0;
				}
				$totalDiscount = $partialPart + $taxesPart;
			}


			$total = $totalPartial;
			if ( config('factotum.product_vat_included') ) {
				$totalPartial = $total - $totalTaxes;
			} else {
				$total += $totalTaxes;
			}

			$shipping = $this->_getTemporaryShipping();

			if ( $shipping ) {
				$shippingOptions = $this->_getShippingOptions();
				if ( isset($shippingOptions[$shipping]) ) {
					$totalShipping = $shippingOptions[$shipping]['amount'];
					$total        += $totalShipping;
				}
			}
		}

		return [
			'total'         => $total,
			'totalPartial'  => $totalPartial,
			'totalTaxes'    => $totalTaxes,
			'totalShipping' => $totalShipping,
			'totalProducts' => $totalProducts,
			'totalDiscount' => $totalDiscount,
		];
	}


	protected function _getTotalShipping( $total, $totalShipping, $formatted = false ) {
		$freeShipping  = false;

		if ( config('factotum.min_free_shipping') ) {
			if ( $total > config('factotum.min_free_shipping') ) {
				$freeShipping  = true;
				$totalShipping = Lang::get('factotum::ecommerce_cart.free_shipping');
			}
		}


		if ( $freeShipping ) {
			$totalShipping = Lang::get('factotum::ecommerce_cart.free_shipping');
		} else {
			if ( $totalShipping ) {
				if ( $formatted ) {
					$totalShipping = '€ ' . number_format( $totalShipping, 2, ',', '.' );
				}
			} else {
				$totalShipping = Lang::get('factotum::ecommerce_cart.shipping_not_calculated');
			}
		}

		return $totalShipping;
	}


	protected function _getShippingOptions( $countryCode = null )
	{
		try {

			$shippingOptions = config('factotum.shipping_options');

			$deliveryAddress = $this->_getTemporaryDeliveryAddress();

			$tmp = [];

			if ( isset( $shippingOptions['pick_up']) ) {
				$tmp['pick_up_standard'] = [
					'amount' => $shippingOptions['pick_up']['standard'],
					'label'  => Lang::get('factotum::ecommerce_checkout.shipping_pick_up')
				];
			}

			if ( $deliveryAddress ) {
				$countryCode = strtoupper($deliveryAddress->country);
			}

			if ( $countryCode ) {

				if ( isset($shippingOptions[ $countryCode ]) ) {
					$shippingTypes = $shippingOptions[ $countryCode ];

					foreach ( $shippingTypes as $shippingType => $amount ) {
						$tmp[ $countryCode . '_' . $shippingType ] = [
							'amount' => $amount,
							'label'  => Lang::get('factotum::ecommerce_checkout.shipping_' . $countryCode . '_' . $shippingType )
						];
					}

				} else {

					$shippingTypes = $shippingOptions[ 'other' ];

					foreach ( $shippingTypes as $shippingType => $amount ) {
						$tmp[ 'other_' . $shippingType ] = [
							'amount' => $amount,
							'label'  => Lang::get('factotum::ecommerce_checkout.shipping_other_' . $shippingType )
						];
					}

				}

			} else {

				foreach ( $shippingOptions as $country => $shippingTypes ) {
					if ( is_array($shippingTypes) ) {
						foreach ( $shippingTypes as $shippingType => $amount ) {
							$tmp[ $country . '_' . $shippingType ] = [
								'amount' => $amount,
								'label'  => Lang::get('factotum::ecommerce_checkout.shipping_' . $country . '_' . $shippingType )
							];
						}
					}
				}

			}

			return $tmp;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );
			return view('factotum::errors.500');
		}
	}


	protected function _getTemporaryDeliveryAddress()
	{
		$addressId = request()->session()->get( 'delivery_address' );

		if ( $addressId ) {

			$user = $this->_getUser();

			return  CustomerAddress::where([
										'customer_id' => $user->id,
										'type'        => 'delivery',
										'id'          => $addressId
									])
								   	->first();
		}

		return null;
	}


	protected function _getTemporaryInvoiceAddress()
	{
		$addressId = request()->session()->get( 'invoice_address' );

		if ( $addressId ) {
			$user = $this->_getUser();

			return CustomerAddress::where([
										'customer_id' => $user->id,
										'type'        => 'invoice',
										'id'          => $addressId
									])
								  	->first();
		}

		return null;
	}


	protected function _getTemporaryShipping()
	{
		if ( request()->hasSession() ) {
			return ( request()->session()->get('shipping') ? request()->session()->get('shipping') : null );
		}

		return null;
	}


	protected function _getTemporaryDiscountCode()
	{
		if ( request()->hasSession() ) {
			$discountCode = request()->session()->get( 'discount_code' );

			if ( $discountCode ) {
				return DiscountCode::find( $discountCode );
			}
		}

		return null;
	}


	protected function _createOrderFromCart( Cart $cart )
	{
		try {

			$user = $this->_getUser();

			if ( $user ) {

				$totals          = $this->_getCartTotals( $cart );
				$deliveryAddress = $this->_getTemporaryDeliveryAddress();
				$invoiceAddress  = $this->_getTemporaryInvoiceAddress();

				$order              = new Order();
				$order->cart_id     = $cart->id;
				$order->customer_id = $user->id;
				$order->status      = 'waiting_payment';
				$order->shipping    = $cart->shipping;

				$order->total_net = $totals['totalPartial'];
				$order->total_tax = $totals['totalTaxes'];

				$totalShippingNet = 0;
				$totalShippingTax = 0;

				if ( config('factotum.shipping_vat_included') ) {
					$totalShippingTax = ( $totals['totalShipping'] / 122 * 22 );
					$totalShippingNet = $totals['totalShipping'] - $totalShippingTax;
				} else {
					$totalShippingNet = $totals['totalShipping'];
				}

				$order->total_shipping_net = $totalShippingNet;
				$order->total_shipping_tax = $totalShippingTax;

				$discountCode = $this->_getTemporaryDiscountCode();

				if ( $discountCode ) {
					$order->discount_code_id = $discountCode->id;
				}

				$order->phone = $user->profile->phone;

				$order->delivery_address  = $deliveryAddress->address;
				$order->delivery_city     = $deliveryAddress->city;
				$order->delivery_zip      = $deliveryAddress->zip;
				$order->delivery_province = $deliveryAddress->province;
				$order->delivery_country  = $deliveryAddress->country;

				$order->invoice_address  = $invoiceAddress->address;
				$order->invoice_city     = $invoiceAddress->city;
				$order->invoice_zip      = $invoiceAddress->zip;
				$order->invoice_province = $invoiceAddress->province;
				$order->invoice_country  = $invoiceAddress->country;

				$order->notes = $cart->notes;

				$order->customer_user_agent = $_SERVER['HTTP_USER_AGENT'];
				$order->save();

				// Copy the products from cart to order
				if ( isset($cart) ) {
					$cartProducts = CartProduct::where('cart_id', $cart->id)->get();

					if ( $cartProducts->count() > 0 ) {

						foreach ($cartProducts as $cp) {
							$orderProduct                     = new OrderProduct;
							$orderProduct->order_id           = $order->id;
							$orderProduct->product_id         = $cp->product_id;
							$orderProduct->product_variant_id = $cp->product_variant_id;
							$orderProduct->quantity           = $cp->quantity;
							$orderProduct->product_price      = $cp->product_price;
							$orderProduct->tax_data           = json_encode( $cp->tax_data );
							$orderProduct->save();

							$product = Product::find( $cp->product_id );

							if ( $product->has_variants && $cp->product_variant_id ) {
								$productVariant = ProductVariant::find( $cp->product_variant_id );
								$productVariant->quantity = $productVariant->quantity - $cp->quantity;
								$productVariant->save();
							}

							$product->quantity = $product->quantity - $cp->quantity;
							$product->save();
						}

					}

					// Delete the cart
					if ( $order->id ) {
						$cart->order_id = $order->id;
						$cart->save();

						if ( config('factotum.guest_cart') ) {
							Cart::where('customer_id', $user->id)->delete();
						}

						request()->session()->remove('delivery_address');
						request()->session()->remove('invoice_address');
						request()->session()->remove('shipping');
						request()->session()->remove('cart_id');
						request()->session()->remove('user_id');
						request()->session()->remove('discount_code');
					}

					return $order;
				}

			}

			return null;

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );

			return request()->wantsJson() ? json_encode([
				'result' => 'ko',
				'error'  => $ex->getMessage(),
				'trace'  => $ex->getTrace()
			]) : view( $this->_getServerErrorView() );
		}
	}




	// IL PREZZO E' PER IL SINGOLO PRODOTTO; NON IL TOTALE
	// SE NEL PERIODO DI CREAZIONE CARRELLO, IL PREZZO VARIA, IL SINGOLO PRODOTTO PRENDERA' IL VALORE ATTUALE
	protected function _calculateProductPrice( Product $product )
	{
		$price = $product->basic_price;

		if ( $product->discount_price != '' && $product->discount_price > 0 ) {
			$price = $product->discount_price;
		}

		return $price;
	}


	protected function addProductToCart( $productId, $quantity, $productVariantId = null )
	{
		$product = Product::find( $productId );
		$cart    = $this->_getCart();

		if ( $product->has_variants ) {
			$productVariant = ProductVariant::find( $productVariantId );
			$productCart = $this->_getProductCart( $cart->id, $product->id, $productVariant->id );
		} else {
			$productCart = $this->_getProductCart( $cart->id, $product->id );
		}

		$checkQuantity        = $productCart->quantity + $quantity;
		$checkQuantityAgaints = ( $product->has_variants ? $productVariant->quantity : $product->quantity );

		if ( $checkQuantity > $checkQuantityAgaints) {
			return [
				'result'        => 'ko',
				'message'       => Lang::get('factotum::ecommerce_cart.max_quantity_reached'),
			];
		}

		// AUMENTO LA QUANTITA'
		$productCart->quantity     += $quantity;
		$productCart->product_price = $this->_calculateProductPrice( $product );

		// SE NEL PERIODO DI CREAZIONE CARRELLO, LA TASSAZIONE VARIA, IL SINGOLO PRODOTTO PRENDE IL VALORE ATTUALE
		$tax = Tax::find( $product->tax_id );

		if ( $tax ) {
			$productCart->tax_data = json_encode([
				'name'   => $tax->name,
				'amount' => $tax->amount
			]);
		}

		$productCart->save();

		$cart   = $this->_getCart();
		$totals = $this->_getCartTotals( $cart );

		return [
			'result'        => 'ok',
			'message'       => Lang::get('factotum::ecommerce_cart.product_added'),
			'price'         => ( $productCart ? '€ ' . number_format( $productCart->quantity * $productCart->product_price, 2, ',', '.' ) : '€ 0' ),

			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
			'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
			'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
		];
	}


	protected function removeProductFromCart( $productId, $quantity, $productVariantId = null )
	{
		$cart        = $this->_getCart();
		$product     = Product::find( $productId );

		if ( $product->has_variants ) {
			$productCart = $this->_getProductCart( $cart->id, $product->id, $productVariantId );
		} else {
			$productCart = $this->_getProductCart( $cart->id, $product->id );
		}

		$productCart->quantity -= $quantity;

		if ( $productCart->quantity < 0 ) {
			$productCart->quantity = 0;
		}

		$removed = false;

		// Se il prodotto è a quantità 0, rimuoverlo dal carrello
		if ( $productCart->quantity == 0 ) {
			$removed = $productCart->delete();
			$productCart = null;
		} else {
			$productCart->product_price = $this->_calculateProductPrice( $product );

			// SE NEL PERIODO DI CREAZIONE CARRELLO, LA TASSAZIONE VARIA, IL SINGOLO PRODOTTO PRENDE IL VALORE ATTUALE
			$tax = Tax::find( $product->tax_id );
			if ( $tax ) {
				$productCart->tax_data = json_encode([
					'name'   => $tax->name,
					'amount' => $tax->amount
				]);
			}

			$productCart->save();
		}

		$cart   = $this->_getCart();
		$totals = $this->_getCartTotals( $cart );

		return [
			'result'        => 'ok',
			'message'       => Lang::get('factotum::ecommerce_cart.product_removed'),
			'removed'       => $removed,
			'price'         => ( $productCart ? '€ ' . number_format( $productCart->quantity * $productCart->product_price, 2, ',', '.' ) : '€ 0' ),

			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
			'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
			'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
		];
	}


	protected function dropProductFromCart( $productId, $productVariantId = null )
	{
		$cart        = $this->_getCart();
		$product     = Product::find($productId);

		if ( $product->has_variants ) {
			$productCart = $this->_getProductCart( $cart->id, $product->id, $productVariantId );
		} else {
			$productCart = $this->_getProductCart( $cart->id, $product->id );
		}

		$dropped = $productCart->delete();

		$cart    = $this->_getCart();
		$totals  = $this->_getCartTotals( $cart );

		return [
			'result'        => ( $dropped ? 'ok' : 'ko' ),
			'message'       => ( $dropped ? Lang::get('factotum::ecommerce_cart.product_dropped') : Lang::get('factotum::ecommerce_cart.product_drop_error') ),
			'removed'       => $dropped,
			'price'         => '€ 0',

			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
			'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
			'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
		];
	}


	protected function emptyCart()
	{
		$cart   = $this->_getCart();
		$result = CartProduct::where('cart_id', $cart->id)->delete();
		$totals = $this->_getCartTotals( $cart );

		return [
			'result'        => 'ok',

			'totalProducts' => $totals['totalProducts'],
			'totalPartial'  => '€ ' . number_format( $totals['totalPartial'], 2, ',', '.' ),
			'totalTaxes'    => '€ ' . number_format( $totals['totalTaxes'], 2, ',', '.' ),
			'totalShipping' => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'         => '€ ' . number_format( $totals['total'], 2, ',', '.' ),
		];
	}


	protected function addNoteToCart( $notes )
	{
		$cart        = $this->_getCart();
		$cart->notes = $notes;
		$cart->save();

		return true;
	}


	private function _redirectHome()
	{
		if ( config('factotum.guest_cart') ) {
			request()->session()->remove('user_id');
			request()->session()->remove('delivery_address');
			request()->session()->remove('invoice_address');
			request()->session()->remove('shipping');
		}

		if ( config('factotum.shop_base_url') ) {
			return redirect('/' . config('factotum.shop_base_url'));
		} else {
			return redirect('/');
		}
	}


	protected function _prepareCheckout()
	{
		// 1. Get the cart
		$cart = $this->_getCart( true );

		// 2. If the cart does not have products or if it does not exist, redirect to home
		if ( $cart ) {
			$cartProducts = CartProduct::where( 'cart_id', $cart->id )->get();
			$totals       = $this->_getCartTotals( $cart );

			if ( $totals['totalProducts'] == 0 ) {
				return $this->_redirectHome();
			}
		} else {
			return $this->_redirectHome();
		}

		$deliveryAddress = null;
		$invoiceAddress  = null;
		$shipping        = null;

		// 2. Get delivery and invoice address, based if there is the guest cart or not
		if ( !config('factotum.guest_cart') ) {
			// 1 . Get all the customers addresses
			$user              = $this->_getUser();
			$deliveryAddresses = CustomerAddress::where( 'type', 'delivery' )
												->where( 'customer_id', $user->id )
												->orderBy('default_address', 'DESC')
												->get();

			$invoiceAddresses  = CustomerAddress::where( 'type', 'invoice' )
												->where( 'customer_id', $user->id )
												->orderBy('default_address', 'DESC')
												->get();
		} else {
//			request()->session()->remove('delivery_address');
//			request()->session()->remove('invoice_address');
//			request()->session()->remove('shipping');

			$deliveryAddress = $this->_getTemporaryDeliveryAddress();
			$invoiceAddress  = $this->_getTemporaryInvoiceAddress();
		}

		// 3. Get the current shipping and available shipping options
		$shipping        = $this->_getTemporaryShipping();
		$shippingOptions = $this->_getShippingOptions();


		// 4. Define the current checkout step
		$step = 'delivery-address';
		if ( $deliveryAddress ) {
			$step = 'invoice-address';
		} else if ( $deliveryAddress && $invoiceAddress ) {
			$step = 'shipping';
		} else if ( $deliveryAddress && $invoiceAddress && $shipping ) {
			$step = 'payment';
		}


		// 5. Get all the accepted payment methods
		$paymentMethods = config('factotum.payment_methods');

		$stripe        = null;
		$paypal        = null;
		$bankTransfer  = null;
		$customPayment = null;

		if ( isset($paymentMethods) && in_array('stripe', $paymentMethods) && env('STRIPE_PUBLIC_KEY') && env('STRIPE_SECRET_KEY') ) {
			$stripe = [
				'publicKey' => env('STRIPE_PUBLIC_KEY')
			];
		}

		if ( isset($paymentMethods) && in_array('paypal', $paymentMethods) && env('PAYPAL_CLIENT_ID') && env('PAYPAL_CLIENT_SECRET') ) {
			$paypal = [
				'publicKey' => env('PAYPAL_CLIENT_ID')
			];
		}

		if ( isset($paymentMethods) && in_array('bank-transfer', $paymentMethods) && env('SHOP_OWNER_BANK_NAME') && env('SHOP_OWNER_BANK_IBAN') ) {
			$bankTransfer = true;
		}

		if ( isset($paymentMethods) && in_array('custom-payment', $paymentMethods) ) {
			$customPayment = true;
		}

		$shop = [
			'name'      => env('SHOP_OWNER_NAME'),
			'bank_name' => env('SHOP_OWNER_BANK_NAME'),
			'bank_iban' => env('SHOP_OWNER_BANK_IBAN'),
		];


		return [
			'cart'              => $cart,
			'cartProducts'      => $cartProducts,

			// All the totals
			'totalProducts'     => $totals['totalProducts'],
			'totalDiscount'     => $totals['totalDiscount'],
			'totalPartial'      => $totals['totalPartial'],
			'totalTaxes'        => $totals['totalTaxes'],
			'totalShipping'     => $this->_getTotalShipping( $totals['total'], $totals['totalShipping'], true ),
			'total'             => $totals['total'],
			'discountCode'      => $this->_getTemporaryDiscountCode(),

			// Possible options
			'deliveryAddresses' => ( isset($deliveryAddresses) ? $deliveryAddresses : null ),
			'invoiceAddresses'  => ( isset($invoiceAddresses)  ? $invoiceAddresses  : null ),
			'shippingOptions'   => $shippingOptions,

			// Current values
			'deliveryAddress'   => ( isset($deliveryAddress) ? $deliveryAddress : null ),
			'invoiceAddress'    => ( isset($invoiceAddress)  ? $invoiceAddress  : null ),
			'shipping'          => $shipping,

			// Current step in checkout
			'step'              => $step,

			// Payments
			'shop'          => $shop,
			'stripe'        => $stripe,
			'paypal'        => $paypal,
			'bankTransfer'  => $bankTransfer,
			'customPayment' => $customPayment,
		];
	}


	protected function _proceedCheckout()
	{
		$cart = $this->_getCart( true );

		if ( $cart ) {
			$order               = $this->_createOrderFromCart( $cart );
			$order->payment_type = request()->input('pay-with');
			$order->save();
			$order->sendNewOrderNotifications();

			return $order;
		}

		return null;
	}


	/**
	 * PAYMENT FUNCTIONS
	 */

	protected function _setupStripePayment()
	{
		\Stripe\Stripe::setApiKey( env('STRIPE_SECRET_KEY') );
	}

	protected function _initStripePayment()
	{
		try {
			$user   = $this->_getUser();
			$cart   = $this->_getCart();
			$totals = $this->_getCartTotals( $cart );

			if ( $totals && $totals['total'] > 0 ) {

				$intent = \Stripe\PaymentIntent::create([
					'amount'   => round( $totals['total'] * 100, 0 ), // Stirpe accepts 1099 for a 10.99 payment
					'currency' => 'eur',
				]);

				if ( $intent ) {
					$cart->payment_type     = 'stripe';
					$cart->stripe_intent_id = $intent->id;
					$cart->save();

					$invoiceAddress = $this->_getTemporaryInvoiceAddress();

					return [
						'result'         => 'ok',
						'clientSecret'   => $intent->client_secret,
						'billingDetails' => [
							'name'  => $user->profile->company_name,
							'email' => $user->email,
							'phone' => $user->profile->phone,
							'address' => [
								'line1'       => $invoiceAddress->address,
								'city'        => $invoiceAddress->city,
								'postal_code' => $invoiceAddress->zip,
								'state'       => $invoiceAddress->province,
								'country'     => $invoiceAddress->country,
							]
						],
						'stripeIntentID' => $intent->id
					];

				}

				return [ 'result' => 'ko', 'error' => 'Error on creating order' ];

			}

			return [ 'result' => 'ko', 'error' => 'Error on creating intent. Missing cart data' ];

		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return [ 'result' => 'ko', 'error' => $ex->getMessage(), 'trace' => $ex->getTrace() ];

		}
	}


	protected function _getStripeTransactionId( $stripeIntentId, $transactionId )
	{
		try {

			$cart = $this->_getCart();

			if ( $stripeIntentId && $cart->stripe_intent_id == $stripeIntentId ) {

				$order = $this->_createOrderFromCart( $cart );

				if ( !$order ) {
					return [ 'result' => 'ko', 'message' => 'Error on setting stripe transaction id' ];
				}

				$order->payment_type = 'stripe';
				$order->save();

				$order->setTransactionId( $transactionId );
				$order->sendNewOrderNotifications();

				$shopBaseUrl = config('factotum.shop_base_url');
				$redirectUrl = url( ( $shopBaseUrl ? $shopBaseUrl : '' ) . '/order/thank-you/' . $order->id );

				$result = [
					'result'   => 'ok',
					'order_id' => $order->id,
					'redirect' => $redirectUrl
				];

				return $result;

			}

			return [ 'result' => 'ko', 'message' => 'Error on setting stripe transaction id' ];

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );

			return [
				'result' => 'ko',
				'error'  => $ex->getMessage(),
				'trace'  => $ex->getTrace()
			];
		}

	}


	protected function _initPayPalPayment()
	{
		try {
			$user   = $this->_getUser();
			$cart   = $this->_getCart();
			$totals = $this->_getCartTotals( $cart );

			if ( $totals && $totals['total'] > 0 ) {

				$ppRequest = new OrdersCreateRequest();
				$ppRequest->prefer('return=representation');
				$ppRequest->body = $this->_buildPayPalIntentRequestBody( $cart->id, $totals['total'] );

				$client   = PayPalClient::client();
				$response = $client->execute($ppRequest);

				if ( $response->statusCode == 200 || $response->statusCode == 201 ) {
					$cart->payment_type    = 'paypal';
					$cart->paypal_order_id = $response->result->id;
					$cart->save();

					$invoiceAddress = $this->_getTemporaryInvoiceAddress();

					$billingName = $user->profile->first_name . ' ' . $user->profile->last_name;
					if ( isset($user->profile->company_name) && $user->profile->company_name ) {
						$billingName = $user->profile->company_name;
					}

					return [
						'result'         => 'ok',
						'billingDetails' => [
							'name'  => $billingName,
							'email' => $user->email,
							'phone' => $user->profile->phone,
							'address' => [
								'line1'       => $invoiceAddress->address,
								'city'        => $invoiceAddress->city,
								'postal_code' => $invoiceAddress->zip,
								'state'       => $invoiceAddress->province,
								'country'     => $invoiceAddress->country,
							]
						],
						'paypalOrderID' => $response->result->id
					];
				}

				return [ 'result' => 'ko', 'message' => 'Error on creating intent. Missing cart data' ];
			}

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );

			return [
				'result' => 'ko',
				'error'  => $ex->getMessage(),
				'trace'  => $ex->getTrace()
			];
		}
	}


	protected function _buildPayPalIntentRequestBody( $cartId, $total )
	{
		$deliveryAddress = $this->_getTemporaryDeliveryAddress();

		return [
			'intent' => 'CAPTURE',
			'purchase_units' => [
				0 => [
					'amount' => [
						'currency_code' => 'EUR',
						'value'         => round($total, 2)
					],
					'description' => 'Acquisto su ' . env('APP_NAME'),
					'custom_id'   => $cartId,
					'shipping' => [
						'method'  => 'Corriere Espresso',
						'address' => [
							'address_line_1' => $deliveryAddress->address,
							'admin_area_1'   => $deliveryAddress->province,
							'admin_area_2'   => $deliveryAddress->city,
							'postal_code'    => $deliveryAddress->zip,
							'country_code'   => $deliveryAddress->country,
						]
					]
				]
			]
		];
	}


	protected function _getPayPalTransactionId( $paypalOrderId )
	{
		try {
			$cart = $this->_getCart();

			if ( $paypalOrderId && $cart->paypal_order_id == $paypalOrderId ) {

				$order               = $this->_createOrderFromCart( $cart );
				$order->payment_type = 'paypal';
				$order->save();

				$client = PayPalClient::client();
				$response = $client->execute(new OrdersGetRequest($paypalOrderId));

				if ( $response->statusCode == 200 || $response->statusCode == 201 ) {

					if ( isset($response->result->purchase_units[0]->payments->captures[0]) ) {
						$transactionId = $response->result->purchase_units[0]->payments->captures[0]->id;

						$order->setTransactionId( $transactionId );
						$order->sendNewOrderNotifications();

						$shopBaseUrl = config('factotum.shop_base_url');
						$redirectUrl = url( ( $shopBaseUrl ? $shopBaseUrl : '' ) . '/order/thank-you/' . $order->id );

						return [
							'result'   => 'ok',
							'order_id' => $order->id,
							'redirect' => $redirectUrl
						];
					}

				}

			}

			return [ 'result' => 'ko', 'message' => 'Error on getting paypal transaction id' ];

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );

			return [
				'result' => 'ko',
				'error' => $ex->getMessage(),
				'trace' => $ex->getTrace()
			];
		}
	}

}