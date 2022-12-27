<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterUserRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\OPD;
use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class MasterUserController extends Controller
{

   use ApiResponse;

   public function index(PegawaiService $pegawaiService)
   {

      abort_if(Gate::denies('master user'), 403);
      $x['title']    = 'Master Data User';
      $x['opd']      = OPD::get();
      $x['user_ttd'] = $pegawaiService->filterByOPD('4002000000');
         $data       = User::whereNotIn('id', [1])->with('opd');
   

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

   public function indexPenandaTangan()
   {
      $data    = User::where('is_penanda_tangan', 'TRUE')->with('opd');

      if (request()->ajax()) {
         return  datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('master-user.action-user-ttd', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
   }


   public function create()
   {
      //
   }

   public function show()
   {
      //
   }


   public function store(MasterUserRequest $request)
   {

      try {
         User::create([
            'username' => $request->username,
            'opd_id' => $request->opd_id,
            // 'name' => $request->name,
            'password' => bcrypt($request->password)
         ]);

         return $this->success('Berhasil Membuat User Baru');
      } catch (\Throwable $th) {
         return $this->error('Gagal Membuat User Baru' . $th, 400);
      }
   }


   public function edit($id)
   {
      $user = User::where('id', $id)->first();
      return $this->success('Data User OPD', $user);
   }


   public function update(MasterUserRequest $request, $id)
   {
      try {
         User::where('id', $id)->update([
            'username' => $request->username,
            'opd_id' => $request->opd_id,
         ]);

         return $this->success('Berhasil Merubah User Baru');
      } catch (\Throwable $th) {
         return $this->error('Gagal Merubah User Baru' . $th, 400);
      }
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
