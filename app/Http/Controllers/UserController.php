<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
   public function index()
   {
      $x['title']     = 'User';
      $x['data']      = User::get();
      $x['role']      = Role::get();
      return view('admin.user', $x);
   }

   public function profile()
   {
      $x['title']     = 'Profile';
      $user = auth()->user();
      return view('admin.profile.index', $x, compact('user'));
   }

   public function ubah_foto()
   {
      try {
         $user = User::find(auth()->user()->id);
       
       
         DB::commit();
         Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil disimpan')->toToast()->toHtml();
      } catch (\Throwable $th) {
         DB::rollback();
         Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
      }
      return back();
   }

    public function update(Request $request)
    {
        $rules = [
            'username'      => ['required', 'string', 'max:255'],
            'password'  => ['nullable', 'string'],
            'role'      => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }
        $data = [
            'username'      => $request->username,
          
        ];
        if (!empty($request->password)) {
            $data['password']   = bcrypt($request->password);
        }

        DB::beginTransaction();
        try {
            $user = User::find($request->id);
            $user->update($data);
            $user->syncRoles($request->role);
            DB::commit();
            Alert::success('Pemberitahuan', 'Data <b>' . $user->username . '</b> berhasil disimpan')->toToast()->toHtml();
        } catch (\Throwable $th) {
            DB::rollback();
            Alert::error('Pemberitahuan', 'Data <b>' . $user->username . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
        }
        return back();
    }

      if ($validator->fails()) {
         return back()->withErrors($validator)
            ->withInput();
      }
      $data = [
         'name'      => $request->name,
         'email'     => $request->email,
      ];
      if (!empty($request->password)) {
         $data['password']   = bcrypt($request->password);
      }

      DB::beginTransaction();
      try {
         $user = User::find($request->id);
         $user->update($data);
         $user->syncRoles($request->role);
         DB::commit();
         Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil disimpan')->toToast()->toHtml();
      } catch (\Throwable $th) {
         DB::rollback();
         Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal disimpan : ' . $th->getMessage())->toToast()->toHtml();
      }
      return back();
   }

   public function destroy(Request $request)
   {
      try {
         $user = User::find($request->id);
         $user->delete();
         Alert::success('Pemberitahuan', 'Data <b>' . $user->name . '</b> berhasil dihapus')->toToast()->toHtml();
      } catch (\Throwable $th) {
         Alert::error('Pemberitahuan', 'Data <b>' . $user->name . '</b> gagal dihapus : ' . $th->getMessage())->toToast()->toHtml();
      }
      return back();
   }
}
