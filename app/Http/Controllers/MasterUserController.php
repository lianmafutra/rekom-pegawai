<?php

namespace App\Http\Controllers;

use App\Models\OPD;
use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MasterUserController extends Controller
{

   use ApiResponse;

   public function index()
   {

      abort_if(Gate::denies('master user'), 403);
      $x['title'] = 'Master Data User';
      $x['opd'] = OPD::get();
      $data    = User::with('opd')->get();
      if (request()->ajax()) {
         return  datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('master-user.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }

      return view('master-user.index', $x);
   }


   public function create()
   {
      //
   }


   public function store(Request $request)
   {

      // dd($request->all());
      Validator::make($request->all(), [
         'username'            => 'required|min:5',
         'password'            => 'required|min:5',
      ])->validate();
      try {
         User::create([
            'username' => $request->username,
            'opd_id' => $request->opd_id,
            'password' => bcrypt($request->password)
         ]);
         return $this->success('Berhasil Membuat User Baru');
      } catch (\Throwable $th) {
         return $this->error('Gagal Membuat User Baru'. $th, 400);
      }
   }


   public function show($id)
   {
      //
   }


   public function edit($id)
   {
      //
   }


   public function update(Request $request, $id)
   {
      //
   }


   public function destroy($id)
   {
      //
   }

   public function resetPassword(Request $request)
   {
         Validator::make($request->all(), [
            'password_baru' => 'required|min:5',
         ])->validate();

      try {
         User::where('id', $request->user_id)->update([
            'password' => bcrypt($request->password_baru)
         ]);
         return $this->success('Berhasil Mereset Password User');
      } catch (\Throwable $th) {
         return $this->error('Gagal Mereset Password User', 400);
      }
   }
}
