<?php

namespace App\Exceptions;

use App\Http\Traits\GeneralTrait;
use App\Http\Traits\getLang;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Throwable;

class Handler extends ExceptionHandler
{
    use GeneralTrait, getLang;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $lang = $this->returnLang($request);
        App::setLocale($lang);
        if ($request->segment(1) == 'api') {
            if ($exception instanceof AuthenticationException) {
                return $this->returnError(401, __('api.notAllow'));
            }
            if ($exception instanceof MethodNotAllowedHttpException) {
                return $this->returnError(401, __('api.notAllow'));
            }
            if ($exception instanceof NotFoundHttpException) {
                return $this->returnError(401, __('api.notAllow'));
            }
        }
        return parent::render($request, $exception);
    }
}
