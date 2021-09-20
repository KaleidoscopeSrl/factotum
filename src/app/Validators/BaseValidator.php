<?php

namespace Kaleidoscope\Factotum\Validators;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Kaleidoscope\Factotum\Validators\Traits\Authorize;


/**
 * Class BaseValidator
 * @package Kaleidoscope\Factotum\Validators
 */
abstract class BaseValidator
{
    use Authorize;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @var array
     */
    protected $rules = [];

    /**
     * @var array
     */
    protected $messages = [];

	/**
	 * @var array
	 */
	protected $params = [];

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * @param string $method
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(string $method): bool
    {
        $action = ucfirst(Str::camel($method));

        $this->callValidate($action);
        $this->callAuthorize($action);

        return true;
    }

    /**
     * @param string $action
     * @return bool
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function callValidate(string $action): bool
    {
        $validation = 'validate' . $action;

        if (!method_exists($this, $validation)) {
            return false;
        }

        $this->{$validation}();

        Validator::make(
            $this->data,
            $this->rules,
            $this->messages
        )->validate();

        return true;
    }

	/**
	 * @param $key
	 * @return mixed
	 */
	public function get($key)
	{
		return Arr::get($this->data, $key);
	}

	/**
	 * @param $param
	 * @return mixed
	 */
	public function param($param)
	{
		return Arr::get($this->params, $param);
	}

	/**
	 * @param array $params
	 * @return $this
	 */
	public function setParams(array $params): self
	{
		$this->params = $params;

		return $this;
	}

	/**
	 * @param string $param
	 * @param $value
	 * @return BaseValidator
	 */
	public function addParam(string $param, $value): self
	{
		$this->params[$param] = $value;

		return $this;
	}
}
