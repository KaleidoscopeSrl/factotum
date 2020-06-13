<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Web\Ecommerce\Checkout;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Web\Controller as Controller;

use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{

	use CartUtils;

	// TODO: fare il checkout
	// STEP 1: scegliere indirizzo di consegna e di spedizione (con possibilità di aggiungerne uno nuovo e fare redirect al checkout dopo)
	// STEP 2: spedizione, corriere oppure ritiro in sede (sul salvataggio, converto il carrello in ordine con stato "da completare")
	// STEP 3: scegli metodo di pagamento (stripe, paypal, pagamento concordato con mt distribuzione)
	// STEP 4: sulla conferma di pagamento, salvare i dati di transazione e far partire l'ordine

	public function prepareCheckout( Request $request )
	{
		$cart          = $this->_getCart();
		$total         = 0;
		$totalProducts = 0;

		if ( isset($cart) && $cart->products->count() > 0 ) {
			foreach( $cart->products as $p ) {
				$totalProducts += $p->pivot->quantity;
				$total += $p->pivot->quantity * $p->pivot->product_price;
			}
		}

		$view = 'factotum::ecommerce.chekcout';

		if ( file_exists( resource_path('views/ecommerce/chekcout.blade.php') ) ) {
			$view = 'ecommerce.chekcout';
		}

		return view($view)->with([
			'cart'          => $cart,
			'total'         => '€ ' . number_format( $total, 2, ',', '.' ),
			'totalProducts' => $totalProducts
		]);
	}


}
