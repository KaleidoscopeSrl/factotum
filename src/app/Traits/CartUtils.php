<?php

namespace Kaleidoscope\Factotum\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\CustomerAddress;
use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\OrderProduct;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductVariant;
use Kaleidoscope\Factotum\Role;
use Kaleidoscope\Factotum\Tax;
use Kaleidoscope\Factotum\User;


trait CartUtils
{
	protected $_cartDuration = '+3 days';

	
	protected function _getUser()
	{
		if ( config('factotum.guest_cart') ) {

			if ( !request()->session()->exists('user_id') ) {
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
				$user   = User::find( $userId );
			}
			
		} else {

			$user = Auth::user();

		}

		return $user;
	}
	

	protected function _getCart( $dontCreateNew = false )
	{
		try {

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

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getFile() . ' - ' . $ex->getLine() . ' - ' . $ex->getMessage() );
			return view('factotum::errors.500');
		}
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
						$tax         = $cp->tax_data;
						$totalTaxes += ( ( $cp->quantity * $cp->product_price ) / 100 * $tax['amount'] );
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
			if ( !config('factotum.product_vat_included') ) {
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

			if ( isset( $shippingOptions['pick-up']) ) {
				$tmp['pick-up'] = [
					'amount' => $shippingOptions['pick-up']['standard'],
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
				
				if ( $cartTotals ) {
					
				}

			} else {

				foreach ( $shippingOptions as $country => $shippingTypes ) {
					foreach ( $shippingTypes as $shippingType => $amount ) {
						$tmp[ $country . '_' . $shippingType ] = [
							'amount' => $amount,
							'label'  => Lang::get('factotum::ecommerce_checkout.shipping_' . $country . '_' . $shippingType )
						];
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

			return  CustomerAddress::where('customer_id', $user->id)
									->where('type', 'delivery')
									->where('id', $addressId)
									->first();
		}

		return null;
	}


	protected function _getTemporaryInvoiceAddress()
	{
		$addressId = request()->session()->get( 'invoice_address' );

		if ( $addressId ) {
			$user = $this->_getUser();

			return CustomerAddress::where('customer_id', $user->id)
									->where('type', 'invoice')
									->where('id', $addressId)
									->first();
		}

		return null;
	}


	protected function _getTemporaryShipping()
	{
		return ( request()->session()->get('shipping') ? request()->session()->get('shipping') : null );
	}


	protected function _getTemporaryDiscountCode()
	{
		$discountCode = request()->session()->get( 'discount_code' );

		if ( $discountCode ) {
			return DiscountCode::find( $discountCode );
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

				$order->total_net      = $totals['totalPartial'];
				$order->total_tax      = $totals['totalTaxes'];
				$order->total_shipping = $totals['totalShipping'];

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
							} else {
								$product->quantity = $product->quantity - $cp->quantity;
								$product->save();
							}
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

		$checkQuantity = $productCart->quantity + $quantity;
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
}