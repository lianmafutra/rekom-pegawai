<?php

namespace App\Http\Controllers\Pengajuan;

use App\Config\Pengajuan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PengajuanAdminController extends Controller
{

   public function index()
   {
      abort_if(Gate::denies('pengajuan index'), 403);
     
      $x['title'] = 'Pengajuan OPD';
      $data    = Pengajuan::with('keperluan')->latest()->get();
      $pegawai = Cache::get('pegawai');

      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan.opd.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan.opd.index', $x, compact('data'));
   }

   public function kirim()
   {
   }

   public function tolak()
   {
   }

   public function selesai()
   {
   }
}
