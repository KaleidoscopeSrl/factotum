<?php

namespace Kaleidoscope\Factotum\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Kaleidoscope\Factotum\Http\Core\ApiResponse;
use Kaleidoscope\Factotum\Services\BaseService;

/**
 * Class BaseController
 * @package Kaleidoscope\Factotum\Http\Controllers\Api
 */
abstract class BaseController extends Controller
{

	/**
	 * @var BaseService
	 */
    protected $service;


    /**
     * @var ApiResponse
     */
    protected $response;


	/**
	 * BaseController constructor.
	 * @param ApiResponse $response
	 * @param BaseService $service
	 */
    public function __construct(
        ApiResponse $response,
        BaseService $service
    )
    {
        $this->service  = $service;
        $this->response = $response;
    }


	/**
	 * @param $id
	 * @param Request $request
	 * @return Response
	 */
    public function single($id, Request $request): Response
    {
        return $this->response->make(
        	$this->service->single($id, $request->all())
        );
    }


	/**
	 * @param Request $request
	 * @return Response
	 */
    public function paginated(Request $request): Response
    {
        return $this->response->make(
        	$this->service->pagination(
        		$request->all()
	        )
        );
    }


	/**
	 * @param Request $request
	 * @return Response
	 */
    public function collected(Request $request): Response
    {
        return $this->response->make(
        	$this->service->collection(
        		$request->all()
	        )
        );
    }


	/**
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
    public function create(Request $request): Response
    {
        return $this->response->make(
        	$this->service->create(
        		$request->all()
	        )
        );
    }


	/**
	 * @param $id
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
    public function update($id, Request $request): Response
    {
        return $this->response->make(
        	$this->service->update(
        		$id, $request->all()
	        )
        );
    }


	/**
	 * @param $id
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
    public function delete($id, Request $request): Response
    {
    	if ( $this->service->delete( $id, $request->all() ) ) {
		    return $this->response->ok();
	    }
    }


	/**
	 * @param Request $request
	 * @return Response
	 * @throws \Exception
	 */
	public function deleteMultiple(Request $request): Response
	{
		if ( $this->service->deleteMultiple( $request->input('ids') ) ) {
			return $this->response->ok();
		}
	}


}
