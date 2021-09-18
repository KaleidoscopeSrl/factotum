<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\Cart;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\Cart;
use Kaleidoscope\Factotum\Models\CartProduct;
use Kaleidoscope\Factotum\Traits\EcommerceUtils;


class ReadController extends ApiBaseController
{
	use EcommerceUtils;


	// TODO: UPDATE carts SET edited = 1 WHERE id IN ( SELECT id FROM `carts` WHERE id IN (SELECT cart_id FROM cart_product ) )

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
		$query->selectRaw('carts.*, first_name, last_name, companies.name');
		$query->join('users', 'users.id', '=', 'carts.customer_id');
		$query->join('profiles', 'profiles.user_id', '=', 'users.id');

		$query->where( 'edited', true );

		if ( isset($filters) && count($filters) > 0 ) {
			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->orWhereRaw( 'LCASE(first_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(last_name) like "%' . $filters['term'] . '%"' );
			}
		}

		if ( $sort == 'customer' ) {

			$query->orderBy('last_name', $direction);
			$query->orderBy('first_name', $direction);

		} else {
			$query->orderBy($sort, $direction);
		}

		$total = $query->count();

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

        return response()->json( [ 'result' => 'ok', 'carts' => $carts, 'total' => $total ]);
    }


    public function getList( Request $request )
	{
		$carts = Cart::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'carts' => $carts ]);
	}


    public function getDetail(Request $request, $id)
    {
		$cart = Cart::withTrashed()->where( 'id', $id )->first();

        if ( $cart ) {
			$cart->load([ 'customer', 'customer.profile' ]);
			$cart->totals   = $this->_getCartTotals( $cart );
			$cart->products = CartProduct::with('product')->where( 'cart_id', $cart->id )->get();

            return response()->json( [ 'result' => 'ok', 'cart' => $cart ]);
        }

        return $this->_sendJsonError( 'Cart not found', 404 );
    }

}
