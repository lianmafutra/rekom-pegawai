<?php

namespace App\Http\Controllers\pengajuan;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Models\File;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\User;
use App\Utils\uploadFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PengajuanOPDController extends Controller
{

   public function index()
   {

      abort_if(Gate::denies('pengajuan index'), 403);


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


   public function create(PegawaiService $pegawaiService, User $user)
   {

      abort_if(Gate::denies('pengajuan create'), 403);
      $x['title']     = 'Buat Pengajuan';
      $x['url_foto']     = Config::get('global.url.bkd.foto');
      $x['rekom_jenis']     = Config::get('global.rekom_jenis');
      
      $pegawai = $pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan-opd.create', $x, compact('pegawai', 'keperluan'));
   }


   public function store(PengajuanOPDStoreRequest $request, uploadFile $uploadFile, PegawaiService $pegawaiService)
   {
      abort_if(Gate::denies('pengajuan store'), 403);

      try {
         DB::beginTransaction();
         // $input = $request->all();

         $pegawai_cache = $pegawaiService->filterByNIP($request->pegawai)[0];

         $file_sk_terakhir  = $uploadFile->save($request->file('file_sk'), 'pengajuan', true);
         $file_pengantar    = $uploadFile->save($request->file('file_pengantar_opd'), 'pengajuan', true);
         $file_konversi_nip = $uploadFile->save($request->file('file_konversi_nip'), 'pengajuan', true);

      
         $pegawai = Pengajuan::create([
            'nip'                 => $pegawai_cache['nipbaru'],
            'gldepan'             => $pegawai_cache['gldepan'],
            'glblk'               => $pegawai_cache['glblk'],
            'nama'                => $pegawai_cache['nama'],
            'kunker'              => $pegawai_cache['kunker'],
            'nunker'              => $pegawai_cache['nunker'],
            'kjab'                => $pegawai_cache['kjab'],
            'njab'                => $pegawai_cache['njab'],
            'keselon'             => $pegawai_cache['keselon'],
            'neselon'             => $pegawai_cache['neselon'],
            'kgolru'              => $pegawai_cache['kgolru'],
            'ngolru'              => $pegawai_cache['ngolru'],
            'pangkat'             => $pegawai_cache['pangkat'],
            'photo'               => $pegawai_cache['photo'],
            'nomor_pengantar'     => $request->nomor_pengantar,
            'tgl_surat_pengantar' =>$request->tgl_pengantar,
            'rekom_jenis'         => $request->rekom_jenis,
            'rekom_keperluan_id'  => $request->rekom_keperluan_id,
            'pengirim_id'         => auth()->user()->id,
            // 'penerima_opd_id'     => '',
            // 'pengirim_opd_id'     => '',
            'file_sk_terakhir'  => $file_sk_terakhir->get('file_id') ,
            'file_pengantar'    => $file_pengantar->get('file_id'),
            'file_konversi_nip' => $file_konversi_nip->get('file_id'),
            'catatan'           => $request->catatan,
         ]);


         // $pengajuan = Pengajuan::create($input);

         DB::commit();
         return redirect()->route('pengajuan.index')->with('success', 'Berhasil ', 200)->send();
      } catch (\Throwable $th) {
         dd($th);
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
      return view('pengajuan-opd.edit', $x, compact('pengajuan'));
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
