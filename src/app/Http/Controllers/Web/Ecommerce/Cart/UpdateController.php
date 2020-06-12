<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\Http\Requests\AddProductToCart;
use Kaleidoscope\Factotum\Http\Requests\RemoveProductFromCart;
use Kaleidoscope\Factotum\Http\Requests\DropProductFromCart;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\Tax;
use Kaleidoscope\Factotum\Traits\CartUtils;


class UpdateController extends Controller
{

	use CartUtils;


	// IL PREZZO E' PER IL SINGOLO PRODOTTO; NON IL TOTALE
	// SE NEL PERIODO DI CREAZIONE CARRELLO, IL PREZZO VARIA, IL SINGOLO PRODOTTO PRENDERA' IL VALORE ATTUALE
	protected function _calculateProductPrice( Product $product )
	{
		$user = Auth::user();

		// 1 - definire se si parte dal prezzo scontato o meno
		$price = $product->basic_price;

		if ( $product->discount_price != '' && $product->discount_price > 0 ) {
			$price = $product->discount_price;
		}


		// 2 - le eventuali regole dei codici sconto per "tutti i clienti" e per il cliente corrente
		$allCustomersDiscountCodes = DiscountCode::whereRaw('(all_customers = ? OR customer_id = ?)', [1, $user->id])
													->whereHas('products', function($q) use($product) {
														$q->where('product_id', $product->id);
													})->get();

		if ( $allCustomersDiscountCodes->count() > 0 ) {
			$totalPercentageDiscount = 0;

			foreach ( $allCustomersDiscountCodes as $dc ) {
				if ( $dc->type == 'percentage' ) {
					$totalPercentageDiscount += $dc->discount;
				} else {
					$price -= $dc->discount;
				}
			}

			if ( $totalPercentageDiscount > 0 ) {
				$price = $price - $price / 100 * $totalPercentageDiscount;
			}
		}

		return $price;
	}



    public function addProduct( AddProductToCart $request )
    {
		try {

			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');

			$product = Product::find( $productId );
			$cart    = $this->_getCart();

			$productCart = $this->_getProductCart( $cart->id, $product->id );

			// AUMENTO LA QUANTITA'
			$productCart->quantity += $quantity;

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

			session()->flash( 'product_added', 'Prodotto aggiunto al carrello!' );

			$total         = 0;
			$totalProducts = 0;
			$cart          = $this->_getCart();
			if ( isset($cart) && $cart->products->count() > 0 ) {
				foreach( $cart->products as $p ) {
					$totalProducts += $p->pivot->quantity;
					$total += $p->pivot->quantity * $p->pivot->product_price;
				}
			}

			$result = [
				'result'        => 'ok',
				'message'       => 'Prodotto aggiunto al carrello!',
				'total'         => '€ ' . number_format( $total, 2, ',', '.' ),
				'totalProducts' => $totalProducts,
				'price'         => ( $productCart ? '€ ' . number_format( $productCart->quantity * $productCart->product_price, 2, ',', '.' ) : '€ 0' )
			];

			return $request->wantsJson() ? json_encode( $result ) : redirect()->back();

		} catch ( \Exception $ex ) {
			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');
		}

    }



	public function removeProduct( RemoveProductFromCart $request )
	{
		try {
			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');

			$cart        = $this->_getCart();
			$product     = Product::find( $productId );
			$productCart = $this->_getProductCart( $cart->id, $product->id );

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

			session()->flash( 'product_removed', 'Prodotto rimosso dal carrello!' );

			$total         = 0;
			$totalProducts = 0;
			$cart          = $this->_getCart();
			if ( isset($cart) && $cart->products->count() > 0 ) {
				foreach( $cart->products as $p ) {
					$totalProducts += $p->pivot->quantity;
					$total += $p->pivot->quantity * $p->pivot->product_price;
				}
			}

			$result = [
				'result'        => 'ok',
				'message'       => 'Prodotto rimosso dal carrello!',
				'removed'       => $removed,
				'total'         => '€ ' . number_format( $total, 2, ',', '.' ),
				'totalProducts' => $totalProducts,
				'price'         => ( $productCart ? '€ ' . number_format( $productCart->quantity * $productCart->product_price, 2, ',', '.' ) : '€ 0' )
			];

			return $request->wantsJson() ? json_encode( $result ) : redirect()->back();

		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');

		}
	}



	public function dropProduct( DropProductFromCart $request )
	{
		try {
			$productId = $request->input('product_id');

			$cart        = $this->_getCart();
			$product     = Product::find($productId);
			$productCart = $this->_getProductCart($cart->id, $product->id);
			$dropped     = $productCart->delete();

			$total         = 0;
			$totalProducts = 0;
			$cart          = $this->_getCart();

			if ( isset($cart) && $cart->products->count() > 0 ) {
				foreach( $cart->products as $p ) {
					$totalProducts += $p->pivot->quantity;
					$total += $p->pivot->quantity * $p->pivot->product_price;
				}
			}

			if ( $dropped ) {
				session()->flash( 'product_dropped', 'Prodotto rimosso dal carrello!' );
			} else {
				session()->flash( 'error', 'Impossibile rimuovere un prodotto dal carrello!' );
			}

			$result = [
				'result'        => ( $dropped ? 'ok' : 'ko' ),
				'message'       => ( $dropped ? 'Prodotto rimosso dal carrello!' : 'Impossibile rimuovere un prodotto dal carrello!' ),
				'removed'       => $dropped,
				'total'         => '€ ' . number_format( $total, 2, ',', '.' ),
				'totalProducts' => $totalProducts,
				'price'         => '€ 0'
			];

			return $request->wantsJson() ? json_encode($result) : redirect()->back();


		} catch ( \Exception $ex ) {

			session()->flash( 'error', $ex->getMessage() );
			return $request->wantsJson() ? json_encode(['result' => 'ko', 'error' => $ex->getMessage() ]) : view('factotum::errors.500');

		}
	}


}
