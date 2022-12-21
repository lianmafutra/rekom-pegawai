<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
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

   public function report(Throwable $exception)
   {
      parent::report($exception);
   }
   public function render($request, Throwable $exception)
   {
      if ($exception instanceof CustomException) {
         return response()->json(['error' => $exception->getMessage()], 400);
      }
      if ($exception instanceof TokenMismatchException) {
         return response()->json(['error' => 'Your form has expired. Please try again'], 419);
      }

      return parent::render($request, $exception);
   }
}
