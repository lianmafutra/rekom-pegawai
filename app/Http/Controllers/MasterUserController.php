<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Utils\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class MasterUserController extends Controller
{

   use ApiResponse;

   public function index()
   {

      abort_if(Gate::denies('master user'), 403);
      $x['title'] = 'Master Data User';
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
      //
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
