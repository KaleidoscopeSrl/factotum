<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api\User;

use Illuminate\Http\Request;

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
		return response()->json( [ 'result' => 'ok', 'users' => $this->_getListPaginated( $request ), 'total' => User::count() ]);
	}


	public function getListByRolePaginated( Request $request )
	{
		$role = $request->input('role');

		if ( $role != '' ) {
			$role = Role::where( 'role', $request->input('role') )->first();

			return response()->json( [
				'result' => 'ok',
				'users'  => $this->_getListPaginated( $request, $role ),
				'total'  => User::where( 'role_id', $role->id )->count()
			]);
		}

		return $this->_sendJsonError( 'Users not found', 404 );
	}


	private function _getListPaginated( Request $request, $role = '' )
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

		if ( isset($filters) && count($filters) > 0 ) {

			if ( isset($filters['term']) && strlen($filters['term']) > 0 ) {
				$query->whereRaw( 'LCASE(profiles.first_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(profiles.last_name) like "%' . $filters['term'] . '%"' );
				$query->orWhereRaw( 'LCASE(email) like "%' . $filters['term'] . '%"' );
			}

		}

		if ( $role ) {
			$query->where( 'role_id', $role->id );
		}

		if ( $sort == 'first_name' || $sort == 'last_name' ) {
			$sort = 'profiles.' . $sort;
		}

		if ( $sort == 'role' ) {
			$sort = 'roles.' . $sort;
		}

		$query->orderBy($sort, $direction);

		if ( $limit ) {
			$query->take($limit);
		}

		if ( $offset ) {
			$query->skip($offset);
		}

		return $query->get();
	}

}
