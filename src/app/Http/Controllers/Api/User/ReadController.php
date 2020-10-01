<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;

use Kaleidoscope\Factotum\Library\Utility;
use Kaleidoscope\Factotum\User;
use Kaleidoscope\Factotum\Role;


class ReadController extends Controller
{

    public function getList( Request $request )
    {
    	$limit  = $request->input('limit');
		$offset = $request->input('offset');

		$query = User::with('profile')
						->with('role')
						->with('avatar')
						->orderBy('id','DESC')
						->skip($offset)
						->take($limit);

		// If Factotum Ecommerce, get all the users EXCEPT the customers
        if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$role = Role::where( 'role', 'customer' )->first();
			$query->where( 'role_id', '!=', $role->id );
		}

        $users = $query->get();

        return response()->json( [ 'result' => 'ok', 'users' => $users ]);
    }


	public function getListByRole( Request $request )
	{
		$limit  = $request->input('limit');
		$offset = $request->input('offset');

		$role   = Role::where( 'role', $request->input('role') )->first();

		if ( $role ) {

			$users = User::with('profile')
						->with('role')
						->with('avatar')
						->where( 'role_id', $role->id )
						->orderBy('id','DESC')
						->skip($offset)
						->take($limit)
						->get();

			return response()->json( [ 'result' => 'ok', 'users' => $users ]);
		}

		return $this->_sendJsonError( 'Users not found', 404 );
	}


	public function getListByRoleAndSearch( Request $request )
	{
		$search = $request->input('search');
		$role   = Role::where( 'role', $request->input('role') )->first();

		if ( $role ) {

			if ( strlen($search) > 0 ) {
				$users = User::with('profile')
					->whereHas( 'profile', function($query) use ($search) {
						$query->where( 'first_name', 'like', '%' . $search . '%' );
						$query->orWhere( 'last_name', 'like', '%' . $search . '%' );
					})
					->where( 'role_id', $role->id )
					->orderBy('id','DESC')
					->get();

				return response()->json( [ 'result' => 'ok', 'users' => $users ]);
			}

			return response()->json( [ 'result' => 'ok', 'users' => [] ]);

		}

		return $this->_sendJsonError( 'Users not found', 404 );
	}


    public function getDetail(Request $request, $id)
    {
        $user = User::find($id);

        if ( $user ) {
            $user->load([ 'profile', 'avatar' ]);
            return response()->json( [ 'result' => 'ok', 'user' => $user ]);
        }

        return $this->_sendJsonError( 'User not found', 404 );
    }


	public function getListPaginated( Request $request )
	{
		$result = $this->_getListPaginated( $request );

		return response()->json( [
			'result' => 'ok',
			'users'  => $result['users'],
			'total'  => $result['total']
		]);
	}


	public function getListByRolePaginated( Request $request )
	{
		$role = $request->input('role');

		if ( $role != '' ) {
			$role = Role::where( 'role', $request->input('role') )->first();

			$result = $this->_getListPaginated( $request, $role );

			return response()->json( [
				'result' => 'ok',
				'users'  => $result['users'],
				'total'  => $result['total']
			]);
		}

		return $this->_sendJsonError( 'Users not found', 404 );
	}


	private function _getListPaginated( Request $request, $role = null )
	{
		$limit     = $request->input('limit');
		$offset    = $request->input('offset');
		$sort      = $request->input('sort');
		$direction = $request->input('direction');
		$filters   = $request->input('filters', null);

		if ( $role ) {
			$role = Role::where( 'role', $request->input('role') )->first();
		}

		if ( !$sort || $sort == 'id' ) {
			$sort = 'users.id';
		}

		if ( !$direction ) {
			$direction = 'DESC';
		}

		$query = User::query();
		$query->select(
			'users.*',
			'profiles.first_name',
			'profiles.last_name',
			'roles.role'
		);
		$query->join('profiles', 'users.id', '=', 'profiles.user_id');
		$query->join('roles', 'users.role_id', '=', 'roles.id');

		if ( $role ) {
			$query->where( 'role_id', $role->id );
		}

		if ( env('FACTOTUM_ECOMMERCE_INSTALLED') ) {
			$customerRole = Role::where( 'role', 'customer' )->first();
			if ( !$role || ( $role && $role->id != $customerRole->id ) ) {
				$query->where( 'role_id', '!=', $customerRole->id );
			}
		}

		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(profiles.first_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(profiles.last_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(email) like "%' . $filters['term'] . '%"' );
			}

		}


		if ( $sort == 'first_name' || $sort == 'last_name' ) {
			$sort = 'profiles.' . $sort;
		}

		if ( $sort == 'role' ) {
			$sort = 'roles.' . $sort;
		}

		$query->orderBy($sort, $direction);

		$total = $query->count();

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		// echo Utility::getSqlQuery($query);die;
		return [ 'users' => $query->get(), 'total' => $total ];
	}

}
