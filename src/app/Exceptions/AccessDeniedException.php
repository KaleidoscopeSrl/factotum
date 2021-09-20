<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Http\Response;

/**
 * Class AccessDeniedException
 * @package Kaleidoscope\Factotum\Exceptions
 */
class AccessDeniedException extends BaseApiException
{
    /**
     * AccessDeniedException constructor.
     * @param string $message
     */
    public function __construct($message = '')
    {
        if (empty($message)) {
            $message = "Accesso Negato";
        }

        parent::__construct(new Response($message, 403, []));
    }
}
