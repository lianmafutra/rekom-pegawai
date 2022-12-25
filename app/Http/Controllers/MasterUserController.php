<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MasterUserController extends Controller
{

   public function index()
   {

      abort_if(Gate::denies('master user'), 403);
      $x['title'] = 'PeMaster Data User';
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
}
