<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        //Only change response when the exception is raised by an api
        if ($exception instanceof ValidationException && $request->hasHeader('Authorization')) {
            return response()->json([
                'code' => $exception->status,
                'message' => $exception->getMessage(),
                'errors' => $this->array_unflatten($exception->validator->errors()->toArray())
                ], $exception->status);
        }
        return parent::render($request, $exception);
    }

    /**
     * Convert flatten collection (with dot notation) to multiple dimmensionals array
     * Example from unit.0.address='123 street' to unit:[0: [ address: '123 street' ]]
     * @param  Collection $collection Collection to be flatten
     * @return Array
     */
    function array_unflatten( $array ){
        $output = array();
        foreach ( $array as $key => $value )
        {
            Arr::set( $output, $key, $value );
            if ( is_array( $value ) && ! strpos( $key, '.' ) ){
                $nested = $this->array_unflatten( $value );
                $output[$key] = $nested;
            }
        }

        return $output;
    }
}
