<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\DiscountCode;
use Kaleidoscope\Factotum\Http\Requests\AddProductToCart;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Tax;
use Kaleidoscope\Factotum\Traits\CartUtils;


class CartController extends Controller
{

	use CartUtils;


    public function addProduct( AddProductToCart $request )
    {

    	try {
			$user = Auth::user();

			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');

			$cart = $this->_getCart();

			// A QUESTO PUNTO HO IL CARRELLO

			// VERIFICO SE IL PRODOTTO E' GIA' PRESENTE NEL CARRELLO, COSI DA MODIFICARE LA QUANTITA E ALTRI PARAMETRI
			$product = Product::find( $productId );

			$productCart = $this->_getProductCart( $cart->id, $product->id );
			$productCart->quantity  += $quantity;


			// 1 - se si parte dal prezzo scontato o meno.
			// 2 - le eventuali regole dei codici sconto per "tutti i clienti"
			// 3 - le eventuali regole dei codici sconto per il cliente corrente

			$price = $product->basic_price;

			if ( $product->discount_price != '' && $product->discount_price > 0 ) {
				$price = $product->discount_price;
			}

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

			// IL PREZZO E' PER IL SINGOLO PRODOTTO; NON IL TOTALE
			// SE NEL PERIODO DI CREAZIONE CARRELLO, IL PREZZO VARIA, IL SINGOLO PRODOTTO PRENDE IL VALORE ATTUALE
			$productCart->product_price = $price;

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

			return redirect()->back();

		} catch ( \Exception $ex ) {
			echo '<pre>';
			print_r( $ex->getLine() . ' - ' . $ex->getMessage());die;
			session()->flash( 'error', $ex->getMessage() );

			return view('factotum::errors.500');

		}

    }

    // TODO: removeProduct ( rimuovere il prodotto dal carrello )

    // TODO: addProductQuick ( aggiunta di 1 pezzo alla volta )

	// TODO: removeProductQuick ( rimuovere di 1 pezzo alla volta )
}
