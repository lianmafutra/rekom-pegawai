<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Utils\MyLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Models\Activity;

class AuthController extends Controller
{

   use MyLog;

   public function ubahPassword(Request $request)
   {
      try {
         $user = User::find(auth()->user()->id);
         if (!Hash::check($request->password,  $user->password)) {
            $this->saveLog($user,$request);
            return redirect()->back()->with('error', 'Password Lama Tidak Cocok');
         }
         $user->password = bcrypt($request->password_baru);
         $user->save();
         
         return redirect()->back()->with('success', 'Berhasil Merubah Password');
      } catch (\Throwable $th) {
         dd($th);
         return redirect()->back()->with('error', 'Gagal Merubah Password User');
      }
   }
}
