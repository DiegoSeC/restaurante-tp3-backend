<?php

namespace App\Exceptions;

use App\Exceptions\Classes\AbstractException;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {

        if (app()->bound('sentry') && $this->shouldReport($e)) {
            app('sentry')->captureException($e);
        }

        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        if ($e instanceof AbstractException) {
            return $this->formatJson($e->getMessage(), $e->getCode());
        } elseif ($e instanceof ValidationException) {
            return $this->formatJson(trans('exception.validation_exception'), 400, $e->validator->errors());
        }

        return parent::render($request, $e);
    }

    /**
     * @param $message
     * @param $code
     * @param null $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function formatJson($message, $code, $data = null) {
        if(is_null($data)) {
            return response()->json(['error' => ['message' => $message]], $code);
        } else {
            return response()->json(['error' => ['message' => $message, 'data' => $data]], $code);
        }
    }
}
