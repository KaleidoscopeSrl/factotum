<?php

namespace Kaleidoscope\Factotum\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\Debug\ExceptionHandler as SymfonyExceptionHandler;
use Illuminate\Support\Facades\Mail;
// use App\Mail\ExceptionOccured;


class Handler extends ExceptionHandler
{
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
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
//		if ( $this->shouldReport($exception) && env('APP_ENV') == 'production' ) {
//			$this->sendEmail($exception);
//		}

		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		if ( $request->expectsJson() ) {

			if ( $exception instanceof ValidationException) {
				$errors  = $exception->validator->getMessageBag()->getMessages();
				$message = array_first( $errors )[0];

				return response()->json( [
					'result'  => 'ko',
					'message' => $message,
					'errors'  => $errors
				], 422 );
			}

			return response()->json( [
				'result'  => 'ko',
				'message' => $exception->getMessage(),
				'errors'  => [
					'error' => [ $exception->getTrace() ],
					'file'  => [ 'Error on file: ' . $exception->getFile() ],
					'line'  => [ 'Error @line : ' . $exception->getLine() ],
				]
			], 422 );

		}

		return parent::render($request, $exception);
	}

	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ( $request->expectsJson() ) {
			return response()->json([ 'result' => 'ko', 'error' => 'Non autorizzato.'], 401);
		}

		return response('Unauthenticated.', 401);
	}


	public function sendEmail(Exception $exception)
	{
		try {

			$e = FlattenException::create($exception);

			$handler = new SymfonyExceptionHandler();

			$html = $handler->getHtml($e);

			Mail::to('fmatteoriggio@gmail.com')
				->cc('mguarino129@gmail.com')
				->send(new ExceptionOccured($html));

		} catch (Exception $ex) {

			dd($ex);

		}
	}
}
