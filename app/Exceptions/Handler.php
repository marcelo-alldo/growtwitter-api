<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\UnauthorizedException;
use Throwable;

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
        $this->renderable(function (AvatarStoreFailException $e, $request) {
            return response()->json([
                'success' => 'false',
                'msg' => $e->getMessage()
            ], 500);
        });

        $this->renderable(function (UnauthorizedUserActionException $e, $request) {
            return response()->json([
                'success' => 'false',
                "message" => "Ação não é autorizada para este usuário.",
            ], 403);
        });
    }
}
