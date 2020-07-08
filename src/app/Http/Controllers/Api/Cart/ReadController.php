<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Cart;
use Kaleidoscope\Factotum\CartProduct;
use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\Order;
use Kaleidoscope\Factotum\Traits\CartUtils;


class ReadController extends Controller
{
	use CartUtils;

    public function getListPaginated( Request $request )
    {
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort || $sort == 'id' ) {
			$sort = 'carts.id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = Cart::withTrashed();
		$query->selectRaw('carts.*, first_name, last_name, company_name');
		$query->join('users', 'users.id', '=', 'carts.customer_id');
		$query->join('profiles', 'profiles.user_id', '=', 'users.id');

		if ( isset($filters) && count($filters) > 0 ) {
			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->orWhereRaw( 'LCASE(first_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(last_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(company_name) like "%' . $filters['term'] . '%"' );
			}
		}

		if ( $sort == 'customer' ) {

			$query->orderBy('last_name', $direction);
			$query->orderBy('first_name', $direction);
			$query->orderBy('company_name', $direction);

		} else {
			$query->orderBy($sort, $direction);
		}


        if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
        	$query->skip($offset);
		}

		$carts = $query->get();

		if ( $carts->count() > 0 ) {
			foreach ( $carts as $cart ) {
				$cart->totals = $this->_getCartTotals( $cart );
			}
		}
        return response()->json( [ 'result' => 'ok', 'carts' => $carts, 'total' => Cart::count() ]);
    }


    public function getList( Request $request )
	{
		$carts = Cart::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'carts' => $carts ]);
	}


    public function getDetail(Request $request, $id)
    {
		$cart = Cart::find($id);

        if ( $cart ) {
			$cart->load([ 'customer', 'customer.profile' ]);
			$cart->totals   = $this->_getCartTotals( $cart );
			$cart->products = CartProduct::with('product')->where( 'cart_id', $cart->id )->get();

            return response()->json( [ 'result' => 'ok', 'cart' => $cart ]);
        }

        return $this->_sendJsonError( 'Cart not found', 404 );
    }

}
