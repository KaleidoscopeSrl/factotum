<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\CustomerAddress;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Http\Controllers\Api\ApiBaseController;
use Kaleidoscope\Factotum\Models\CustomerAddress;



class ReadController extends ApiBaseController
{

	public function getListPaginated( Request $request )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);


		if ( !$sort || $sort == 'id' ) {
			$sort = 'customer_addresses.id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = CustomerAddress::query();
		$query->select([ 'customer_addresses.*', 'first_name', 'last_name' ]);
		$query->join('users', 'customer_addresses.customer_id', '=', 'users.id');
		$query->join('profiles', 'users.id', '=', 'profiles.user_id');

		if ( isset($filters) && count($filters) > 0 ) {
			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->where( 'address', 'like', $filters['term'] );
				$query->orWhere( 'city', 'like', $filters['term'] );
				$query->orWhere( 'first_name', 'like', $filters['term'] );
				$query->orWhere( 'last_name', 'like', $filters['term'] );
			}
		}

		if ( $sort == 'first_name' || $sort == 'last_name' ) {
			$sort = 'profiles.' . $sort;
		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		$customerAddresses = $query->get();

		return response()->json( [ 'result' => 'ok', 'customer_addresses' => $customerAddresses, 'total' => CustomerAddress::count() ]);
	}


    public function getList( Request $request )
	{
		$customerAddresses = CustomerAddress::orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'customer_addresses' => $customerAddresses ]);
	}


	public function getListByCustomer( Request $request, $customerId )
	{
		$customerAddresses = CustomerAddress::where('customer_id', $customerId)
											->orderBy('id', 'DESC')->get();

		return response()->json( [ 'result' => 'ok', 'customer_addresses' => $customerAddresses ]);
	}


    public function getDetail(Request $request, $id)
    {
		$customerAddress = CustomerAddress::find($id);

        if ( $customerAddress ) {
			$customerAddress->load([ 'customer', 'customer.profile' ]);
            return response()->json( [ 'result' => 'ok', 'customer_address' => $customerAddress ]);
        }

        return $this->_sendJsonError( 'Customer Address not found', 404 );
    }

}
