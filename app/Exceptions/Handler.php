<?php

namespace App\Exceptions;
die('This file is not meant to be executed directly. Please use the appropriate routes or controllers in your application.');
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    protected $levels = [
        // Define log levels for exceptions (optional)
    ];

    protected $dontReport = [
        // Exceptions you don't want to report (optional)
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->renderable(function (PostTooLargeException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Uploaded file is too large.',
                ], 413);
            }

            return redirect()->back()->withErrors([
                'file' => 'Uploaded file is too large.',
            ]);
        });
    }
}
