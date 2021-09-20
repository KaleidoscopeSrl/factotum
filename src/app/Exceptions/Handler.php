<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException as IlluminateValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

use Kaleidoscope\Factotum\Http\Core\ApiResponse;


class Handler extends ExceptionHandler
{
	/**
	 * @var ApiResponse
	 */
	protected $response;

	/**
	 * Handler constructor.
	 * @param Container $container
	 * @param ApiResponse $response
	 */
	public function __construct(
		Container $container,
		ApiResponse $response
	)
	{
		parent::__construct($container);

		$this->response = $response;
	}

	/**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {

	        if (app()->bound('sentry') && $this->shouldReport($e)) {
		        app('sentry')->captureException($e);
	        }

        });
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 * @param Throwable $e
	 * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
	 * @throws Throwable
	 */
    public function render($request, Throwable $e)
    {
	    if (config('app.debug')) {
	    	return parent::render($request, $e);
	    }

	    if ($e instanceof IlluminateValidationException) {
		    return $this->response->exception(new ValidationException($e->validator));
	    }

	    if ($e instanceof UnauthorizedException) {
		    return $this->response->exception(new AccessDeniedException($e->getMessage()));
	    }

	    if ($e instanceof NotFoundHttpException) {
		    return $this->response->exception(new NotFoundException());
	    }

	    if ($e instanceof ModelNotFoundException) {
		    return $this->response->exception(new NotFoundException());
	    }

	    return $this->response->exception(new BadRequestException($e->getMessage()));
    }
}
