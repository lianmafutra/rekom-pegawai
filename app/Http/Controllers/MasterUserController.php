<?php

namespace App\Http\Controllers;

use App\Http\Requests\MasterUserRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\OPD;
use App\Models\User;
use App\Utils\ApiResponse;
use App\Utils\RemoveSpace;
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
      $data    = User::whereIn('id', [4, 5, 3])->with('opd')->orderBy('position', 'ASC');
      if (request()->ajax()) {
         return  datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('master-user.action-user-ttd', compact('data'));
            })
            ->editColumn('img_ttd', function ($data) {
               if($data->img_ttd == ""){
                  return '-';
               }
               return '<img src="'.url('storage/template/'.$data->img_ttd).'" width=100px; height="100px">';
            })
            ->rawColumns(['action','img_ttd'])
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

         return $this->success('Berhasil Merubah Data User');
      } catch (\Throwable $th) {
         return $this->error('Gagal Merubah Data User' . $th, 400);
      }
   }


   public function updateUserTTD(Request $request, $uuid, PegawaiService $pegawaiService)
   {
      try {
         $pegawai = $pegawaiService->filterByNIP($request->nip_ttd)[0];

         $user       = User::where('uuid', $uuid)->firstOrFail();
         $user->nip  = $pegawai['nipbaru'];
         $user->name = $pegawai['nama'];
        
         if ($request->hasFile('img_ttd')) {
            $file_ttd   = $request->file('img_ttd');
            $name_uniqe = RemoveSpace::removeDoubleSpace('ttd-' . now()->timestamp . '.' . $file_ttd->getClientOriginalExtension());
            $file_ttd->storeAs('public/template/', $name_uniqe);
            $user->img_ttd = $name_uniqe;
         }

         $user->save();
         
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
