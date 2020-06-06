<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Cart;

use Illuminate\Support\Facades\Auth;

use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\Http\Requests\AddProductToCart;
use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\Product;
use Kaleidoscope\Factotum\ProductCategory;
use Kaleidoscope\Factotum\Tax;


class CartController extends Controller
{

    public function addProduct( AddProductToCart $request )
    {
    	try {

			$user = Auth::user();

			$productId = $request->input('product_id');
			$quantity  = $request->input('quantity');

			$cart = Cart::where( 'customer_id', $user->id )->where('expires_at', '<=', date('Y-m-d H:i:s'))->first();

			if ( !$cart ) {
				$cart = new Cart;
				$cart->customer_id = $user->id;
				$cart->expires_at  = date('Y-m-d H:i:s', strtotime('+1 day') );
				$cart->total       = 0;
				$cart->save();
			}

			// A QUESTO PUNTO HO IL CARRELLO

			// VERIFICO SE IL PRODOTTO E' GIA' PRESENTE NEL CARRELLO, COSI DA MODIFICARE LA QUANTITA E ALTRI PARAMETRI
			$product = Product::find( $productId );

			$productCart = CartProduct::where( 'cart_id', $cart->id )
				->where( 'product_id', $product->id )
				->first();

			if ( !$productCart ) {
				$productCart = new CartProduct;
				$productCart->cart_id    = $cart->id;
				$productCart->product_id = $product->id;
				$productCart->quantity   = $quantity;
			} else {
				$productCart->quantity  += $quantity;
			}


			// TODO: qui vanno applicate:
			// 1 - se si parte dal prezzo scontato o meno.
			// 2 - le eventuali regole dei codici sconto per "tutti i clienti"
			// 3 - le eventuali regole dei codici sconto per il cliente corrente

			$price = $product->basic_price;

			if ( $product->discount_price != '' && $product->discount_price > 0 ) {
				$price = $product->discount_price;
			}

			// TODO: qui implementare le regole codici sconto

			// IL PREZZO E' PER IL SINGOLO PRODOTTO; NON IL TOTALE
			// SE NEL PERIODO DI CREAZIONE CARRELLO, IL PREZZO VARIA, IL SINGOLO PRODOTTO PRENDE IL VALORE ATTUALE
			$productCart->product_price = $price;

			// SE NEL PERIODO DI CREAZIONE CARRELLO, LA TASSAZIONE VARIA, IL SINGOLO PRODOTTO PRENDE IL VALORE ATTUALE
			$tax = Tax::find( $product->tax_id );
			$productCart->tax_data = json_encode([
				'name'   => $tax->name,
				'amount' => $tax->amount
			]);

			$productCart->save();

			session()->flash( 'message', 'Prodotto aggiunto al carrello!' );

			return redirect()->back();

		} catch ( \Exception $ex ) {

			return view('factotum::errors.500');

		}

    }

    // TODO: removeProduct ( rimuovere il prodotto dal carrello )

    // TODO: addProductQuick ( aggiunta di 1 pezzo alla volta )

	// TODO: removeProductQuick ( rimuovere di 1 pezzo alla volta )
}
