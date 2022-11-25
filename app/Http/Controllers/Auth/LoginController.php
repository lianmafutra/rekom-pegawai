<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Utils\MyLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
   

   use AuthenticatesUsers;
   use MyLog;

   /**
    * Where to redirect users after login.
    *
    * @var string
    */
   protected $redirectTo = RouteServiceProvider::HOME;

   /**
    * Create a new controller instance.
    *
    * @return void
    */
   public function __construct()
   {
      $this->middleware('guest')->except('logout');
   }

   public function login(Request $request)
   {
      $request->validate([
         'username' => 'required',
         'password' => 'required',
         'g-recaptcha-response' => 'required'
      ]);

      $credentials = $request->only('username', 'password');
      if (Auth::attempt($credentials, true)) {
         $this->saveLog('',$request);
         return to_route('dashboard');
      }
      throw ValidationException::withMessages([
         $this->username() => [trans('auth.failed')],
      ]);
   }

   function authenticated(Request $request, $user)
   {
       $user->update([
           'last_login_at' => Carbon::now()->toDateTimeString(),
           'last_login_ip' => $request->getClientIp()
       ]);
   }
}
