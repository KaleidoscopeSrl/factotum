<?php

namespace Kaleidoscope\Factotum\Http\Core;

use Illuminate\Http\Response as IlluminateResponse;

use Kaleidoscope\Factotum\Exceptions\BaseApiException;

/**
 * Class ApiResponse
 * @package Kaleidoscope\Factotum\Http\Core
 */
class ApiResponse
{
    /**
     * @var IlluminateResponse
     */
    protected $response;

    /**
     * Response constructor.
     * @param IlluminateResponse $response
     */
    public function __construct(IlluminateResponse $response)
    {
        $this->response = $response;
    }

    /**
     * @return IlluminateResponse
     */
    public function ok(): IlluminateResponse
    {
        return $this->response
            ->setContent([
	            'result' => 'ok'
            ])
            ->setStatusCode(200);
    }

    /**
     * @param $content
     * @return IlluminateResponse
     */
    public function make($content): IlluminateResponse
    {
        return $this->response
            ->setContent([
            	'result' => 'ok',
                'data'   => $content,
            ])
            ->setStatusCode(200);
    }

    /**
     * @param BaseApiException $exception
     * @return IlluminateResponse
     */
    public function exception(BaseApiException $exception): IlluminateResponse
    {
        $response = $exception->getResponse();

        $response->setContent([
	        'result' => 'ko',
            'error'   => 'Http Error',
            'code'    => $response->getStatusCode(),
            'message' => $response->getContent(),
            'errors'  => $exception->getErrors(),
        ]);

        return $response;
    }
}
