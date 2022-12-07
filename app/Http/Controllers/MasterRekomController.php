<?php

namespace App\Http\Controllers;

use App\Models\MasterRekom;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MasterRekomController extends Controller
{

   public function index(Request $request)
   {

      $x['title'] = 'Master Rekom Pegawai';
      $data = MasterRekom::latest('id');
      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('master-rekom.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('master-rekom.index', $x, compact('data'));      
   }


   public function create()
   {
      //
   }


   public function store(Request $request)
   {
      //
   }

   public function show(MasterRekom $masterRekom)
   {
      //
   }


   public function edit(MasterRekom $masterRekom)
   {
      //
   }

   public function update(Request $request, MasterRekom $masterRekom)
   {
      //
   }


   public function destroy(MasterRekom $masterRekom)
   {
      //
   }
}
