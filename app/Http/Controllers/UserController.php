<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Utils\uploadFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
   public function index()
   {
      // 
      $x['title']     = 'User';
      $x['data']      = User::get();
      $x['role']      = Role::get();
      return view('admin.user', $x);
   }

   public function profile()
   {
      $x['title']     = 'Profile';
      $user = User::find(auth()->user()->id);

    
      return view('admin.profile.index', $x, compact('user'));
   }

   public function profileUpdate(Request $request)
   {
      try {
         $user = User::find(auth()->user()->id);
         $user->kontak = $request->kontak;
         $user->save();
         DB::commit();
         return redirect()->back()->with('success', 'Berhasil Merubah Data User');
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error', 'Gagal Merubah Data User');
      }
      return back();
   }

   public function ubah_foto(Request $request, uploadFile $uploadFile)
   {
      try {
         $user = User::find(auth()->user()->id);
         $files = $request->file('foto');

         $data = User::where('id',auth()->user()->id)->firstOrFail();

         if ($data->foto == null) {
            $data->foto = $files  ? Str::uuid()->toString() : NULL;
         }
         $data->save();

         $uploadFile
            ->file($files)
            ->path('profile')
            ->uuid($data->uuid)
            ->parent_id($data->id)
            ->update($data->foto);

         DB::commit();
         return redirect()->back()->with('success', 'Berhasil Merubah Foto User');
      } catch (\Throwable $th) {
         DB::rollback();
         return redirect()->back()->with('error', 'Gagal Merubah Foto User' . $th);
      }
      return back();
   }

   public function store(Request $request)
   {
      $validator = Validator::make($request->all(), [
         'username'     => ['required', 'string', 'max:255', 'unique:users'],
         'password'  => ['required', 'string'],
         'role'      => ['required']
      ]);
      if ($validator->fails()) {
         return back()->withErrors($validator)
            ->withInput();
      }
      DB::beginTransaction();
      try {
         $user = User::create([
            'username'      => $request->username,
            'password'  => bcrypt($request->password)
         ]);
         $user->assignRole($request->role);
         DB::commit();
         Alert::success('Pemberitahuan', 'Data <b>' . $user->username . '</b> berhasil dibuat')->toToast()->toHtml();
      } catch (\Throwable $th) {
         DB::rollback();

         Alert::error('Pemberitahuan', 'Data <b>' . $request->username . '</b> gagal dibuat : ')->toToast()->toHtml();
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

   public function show(Request $request)
   {
      $user = UserResource::collection(User::where(['id' => $request->id])->get());
      return response()->json([
         'status'    => Response::HTTP_OK,
         'message'   => 'Data user by id',
         'data'      => $user[0]
      ], Response::HTTP_OK);
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
