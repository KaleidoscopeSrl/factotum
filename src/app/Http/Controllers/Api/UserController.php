<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Kaleidoscope\Factotum\Http\Core\ApiResponse;
use Kaleidoscope\Factotum\Services\UserService;

class UserController extends BaseController
{

	/**
	 * UserController constructor.
	 * @param ApiResponse $response
	 * @param UserService $service
	 */
	public function __construct(
		ApiResponse $response,
		UserService $service
	)
	{
		parent::__construct($response, $service);
	}


	/**
	 * All the users
	 *
	 * @group User
	 *
	 * @queryParam selects Comma-separated list of fields to include in the response. Example: first_name,last_name
	 * @queryParam relations Comma-separated list of relations to include in the response. Example: company,badges
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/user/collected.json
	 *
	 */
	public function collected(Request $request): Response
	{
		return parent::collected($request);
	}


	/**
	 * Detail
	 *
	 * @group User
	 *
	 * @urlParam id int required The user's ID. Example: 123
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/user/single.json
	 *
	 */
	public function single($id, Request $request): Response
	{
		return parent::single( $id, $request );
	}


	/**
	 * Paginated List
	 *
	 * @group User
	 *
	 * @queryParam limit int Max number of records to paginate
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/user/paginated.json
	 *
	*/
	public function paginated(Request $request): Response
	{
		return parent::paginated( $request );
	}


	/**
	 * Create
	 *
	 * @group User
	 *
	 * @bodyParam first_name string required The first name of the user. Example: Foo
	 * @bodyParam last_name string required The last name of the user. Example: Bar
	 * @bodyParam password string required The password of the user Example: p4ssw0rd
	 * @bodyParam email string required The email of the user. Example: info@email.com
	 * @bodyParam phone string required The phone of the user. Example: +39 123 456789
	 * @bodyParam enabled boolean required Flag to enable the user. Example: true
	 * @bodyParam role string required The role of the user. Example: admin
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/user/create.json
	 *
	 */
	public function create(Request $request): Response
	{
		return parent::create( $request );
	}



	/**
	 * Update
	 *
	 * @group User
	 *
	 * @urlParam id int required The user's ID. Example: 123
	 *
	 * @bodyParam first_name string required The first name of the user. Example: Foo
	 * @bodyParam last_name string required The last name of the user. Example: Bar
	 * @bodyParam password string required The password of the user Example: p4ssw0rd
	 * @bodyParam email string required The email of the user. Example: info@email.com
	 * @bodyParam phone string required The phone of the user. Example: +39 123 456789
	 * @bodyParam enabled boolean required Flag to enable the user. Example: true
	 * @bodyParam role string required The role of the user. Example: admin
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/user/update.json
	 *
	 */
	public function update($id, Request $request): Response
	{
		return parent::update( $id, $request );
	}


	/**
	 * Delete
	 *
	 * @group User
	 *
	 * @urlParam id int required The user's ID. Example: 88683
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/ok.json
	 *
	 */
	public function delete($id, Request $request): Response
	{
		return parent::delete( $id, $request );
	}


	/**
	 * Delete users
	 *
	 * @group User
	 *
	 * @bodyParam ids number[] required The array of user IDs to delete. Example: [ 1, 3, 5 ]
	 *
	 * @authenticated
	 *
	 * @responseFile status=200 vendor/kaleidoscope/factotum/src/documentation/responses/ok.json
	 *
	 */
	public function deleteUsers(Request $request): Response
	{
		return parent::deleteMultiple( $request );
	}

}
