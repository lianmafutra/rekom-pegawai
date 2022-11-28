<?php

namespace App\Http\Controllers\pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Utils\uploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PengajuanOPDController extends Controller
{

   public function index()
   {
      
      abort_if(Gate::denies('pengajuan'), 403);
      

      $x['title']     = 'Pengajuan OPD';
      $data = Pengajuan::get();
      if (request()->ajax()) {
         return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
               return view('pengajuan-opd.action', compact('data'));
            })
            ->rawColumns(['action'])
            ->make(true);
      }
      return view('pengajuan-opd.index', $x, compact('data'));
   }


   public function create(PegawaiService $pegawaiService)
   {

      abort_if(Gate::denies('pengajuan create'), 403);

      $x['title']     = 'Buat Pengajuan';
      $pegawai = $pegawaiService->filterByOPD(4021000000);
      $keperluan = Keperluan::get();


      return view('pengajuan-opd.create', $x, compact('pegawai', 'keperluan'));
   }


   public function store(PengajuanOPDStoreRequest $request, uploadFile $uploadFile)
   {
      abort_if(Gate::denies('pengajuan store'), 403);

      try {
         DB::beginTransaction();
         $input = $request->all();
         dd($input);
         $pengajuan = Pengajuan::create($input);
         $file_sk_pns = $request->file('file_sk_pns');
         $uploadFile->save($file_sk_pns, 'pengajuan');
         DB::commit();
         return redirect()->route('pengajuan.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         DB::rollBack();
         return redirect()->back()->with('error', 'Gagal' . $th, 400)->send();
      }
   }


   public function show(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan show'), 403);
   }


   public function edit(Pengajuan $pengajuan)
   {
      $x['title']     = 'Ubah Pengajuan';
      abort_if(Gate::denies('pengajuan edit'), 403);
      return view('pengajuan-opd.edit',$x, compact('pengajuan'));
   }


   public function update(Request $request, Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan update'), 403);
   }


   public function destroy(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan destroy'), 403);
   }
}
