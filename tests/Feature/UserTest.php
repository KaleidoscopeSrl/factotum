<?php

namespace Kaleidoscope\Factotum\Tests\Feature;

use Kaleidoscope\Factotum\Repositories\UserRepository;

use Kaleidoscope\Factotum\Tests\KaleidoscopeTestCase;


class UserTest extends KaleidoscopeTestCase
{

	protected $repository;


	public function setUp(): void
	{
		parent::setUp();

		if ( !$this->repository ) {
			$this->repository = app()->make( UserRepository::class );
		}

		$this->customActingAs();
	}


    public function testCollected()
    {
    	$uri = $this->baseApiUrl . '/user/collected';

	    $response = $this->getJson( $uri );

	    $this->checkResponse( $response, $uri );

	    $response
		    ->assertStatus(200)
		    ->assertJsonStructure([
			    'result',
			    'data'
		    ]);
    }


	public function testPaginated()
	{
		$uri = $this->baseApiUrl . '/user/paginated';

		$response = $this->getJson( $uri );

		$this->checkResponse( $response, $uri );

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'result',
				'data' => $this->paginateStructure
			]);
	}


	public function testSingle()
	{
		$user = $this->repository->latest();
		$uri  = $this->baseApiUrl . '/user/single/' . $user->id;

		$response = $this->getJson( $uri );

		$this->checkResponse( $response, $uri );

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'result',
				'data' => $this->userStructure
			]);
	}


	public function testCreated()
	{
		$data = $this->generateUserData();
		$uri  = $this->baseApiUrl . '/user/create';

		dd($data);
		$response = $this->postJson($uri, $data);

		$this->checkResponse( $response, $uri );

		$response
			->assertStatus(200)
			->assertJsonStructure([
				'result',
				'data' => $this->userStructure
			]);
	}
//
//
//	public function testUpdated()
//	{
//		$user = $this->repository->latest();
//		$data = $this->generateUserData();
//		$uri  = $this->baseApiUrl . '/user/update/' . $user->id;
//
//		$response = $this->putJson($uri, $data);
//
//		$this->checkResponse( $response, $uri );
//
//		$response
//			->assertStatus(200)
//			->assertJsonStructure([
//				'result',
//				'data' => $this->userStructure
//			]);
//	}
//
//
//	public function testDeleted()
//	{
//		$user = $this->repository->latest();
//
//		$uri = $this->baseApiUrl . '/user/delete/' . $user->id;
//
//		$response = $this->deleteJson( $uri );
//
//		$this->checkResponse( $response, $uri );
//
//		$response
//			->assertStatus(200)
//			->assertJsonStructure([
//				'result'
//			]);
//	}


}
