<?php

namespace Kaleidoscope\Factotum\Validators\Traits;

use Illuminate\Validation\UnauthorizedException;

/**
 * Trait Authorize
 * @package Kaleidoscope\Factotum\Validators\Traits
 */
trait Authorize
{
    /**
     * @var string
     */
    private $unAuthorizedMessage = '';

    /**
     * @return string
     */
    public function getUnAuthorizedMessage(): string
    {
        return $this->unAuthorizedMessage;
    }

    /**
     * @param $message
     * @return $this
     */
    public function setUnAuthorizedMessage($message): self
    {
        $this->unAuthorizedMessage = $message;

        return $this;
    }

    /**
     * @param $action
     * @return bool
     */
    protected function callAuthorize($action): bool
    {
        $authorization = 'authorize' . $action;

        if (!method_exists($this, $authorization)) {
            return false;
        }

        if (!$this->{$authorization}()) {
            throw new UnauthorizedException($this->getUnAuthorizedMessage());
        }

        return true;
    }
}
