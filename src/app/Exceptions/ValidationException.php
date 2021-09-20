<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException as IlluminateValidationException;

/**
 * Class ValidationException
 * @package Kaleidoscope\Factotum\Exceptions
 */
class ValidationException extends BaseApiException
{
    /**
     * @var IlluminateValidationException
     */
    protected $baseException;

    /**
     * ValidationException constructor.
     * @param $validator
     */
    public function __construct($validator)
    {
        $this->baseException = (new IlluminateValidationException($validator));

        $message = "Errore di validazione";

        parent::__construct(new Response($message, 422, []));
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->baseException->errors();
    }
}
