<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
   public function ubahPassword(Request $request)
   {
      try {
         $user = User::find(auth()->user()->id);
         $user->password = bcrypt($request->password_baru);
         $user->save();
         return redirect()->back()->with('success', 'Berhasil Merubah Password');
      } catch (\Throwable $th) {
         dd($th);
         return redirect()->back()->with('error', 'Gagal Merubah Password User');
      }
   }
}
