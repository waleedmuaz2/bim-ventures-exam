<?php

namespace App\Exceptions;

use App\Support\Exceptions\OAuthException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Symfony\Component\HttpFoundation\Response;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return jsonFormat('', 'Not Found', 404);
            }
        });
        $this->reportable(
            reportUsing: fn(TokenInvalidException|TokenExpiredException|TokenBlacklistedException $e) => throw new OAuthException(code: 'token_could_not_verified')
        );
        $this->reportable(
            reportUsing: fn(JWTException $e) => throw new OAuthException(code: 'token_could_not_parse', statusCode: Response::HTTP_INTERNAL_SERVER_ERROR)
        );
    }

}
