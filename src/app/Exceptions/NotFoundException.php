<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Http\Response;

/**
 * Class NotFoundException
 * @package Kaleidoscope\Factotum\Exceptions
 */
class NotFoundException extends BaseApiException
{
    /**
     * NotFoundException constructor.
     * @param string $message
     */
    public function __construct($message = '')
    {
        if (empty($message)) {
            $message = "Non Trovato";
        }

        parent::__construct(new Response($message, 404, []));
    }
}
