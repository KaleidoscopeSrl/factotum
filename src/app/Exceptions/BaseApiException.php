<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Http\Response;

/**
 * Class BaseApiException
 * @package Kaleidoscope\Factotum\Exceptions
 */
abstract class BaseApiException extends \RuntimeException
{
    /**
     * @var Response
     */
    protected $response;

    /**
     * AbstractHttpException constructor.
     * @param Response $response
     */
    public function __construct(Response $response)
    {
        parent::__construct();

        $this->response = $response;
    }

    /**
     * @return Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getErrors(): ?array
    {
        return [];
    }
}
