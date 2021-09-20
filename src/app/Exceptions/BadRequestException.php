<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Http\Response;

/**
 * Class BadRequestException
 * @package Kaleidoscope\Factotum\Exceptions
 */
class BadRequestException extends BaseApiException
{
    /**
     * BadRequestException constructor.
     * @param string $message
     */
    public function __construct($message = '')
    {
        if (empty($message)) {
            $message = 'Errore';
        }

        parent::__construct(new Response($message, 400, []));
    }
}
