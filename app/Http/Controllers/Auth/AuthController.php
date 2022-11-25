<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{



   public function ubahPassword(Request $request)
   {
      try {

         $user = User::find(auth()->user()->id);
         if (!Hash::check($request->password,  $user->password)) {

            activity()
               ->causedBy($user)
               ->useLog($request->route()->getActionMethod())
               ->withProperties([
                  "user" => auth()->user()->username,
                  "role" => $user->roles->pluck('name')[0],
                  "method" => \Route::current()->methods()[0],
                  "file" => \Route::currentRouteAction(),
                  "ip" => request()->ip(),
               ])
               ->event('verified')
               ->log('edited');

            return redirect()->back()->with('error', 'Password Lama Tidak Cocok');
         }

         $user->password = bcrypt($request->password_baru);
         $user->save();
         $activity = Activity::all()->last();
         return redirect()->back()->with('success', 'Berhasil Merubah Password');
      } catch (\Throwable $th) {
         dd($th);
         return redirect()->back()->with('error', 'Gagal Merubah Password User');
      }
   }
}
