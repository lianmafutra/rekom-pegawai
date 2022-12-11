<?php

namespace App\Http\Controllers\pengajuan;

use App\Config\PengajuanAksi;
use App\Exceptions\CustomException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\PengajuanAksi as ModelsPengajuanAksi;
use App\Models\PengajuanHistori;
use App\Models\User;
use App\Utils\ApiResponse;
use App\Utils\UploadFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Throwable;
use Yajra\DataTables\DataTables;

class PengajuanOPDController extends Controller
{


   private $pengajuanService, $pegawaiService;

   use ApiResponse;

   public function __construct(PengajuanService $pengajuanService, PegawaiService $pegawaiService)
   {
      $this->pengajuanService = $pengajuanService;
      $this->pegawaiService = $pegawaiService;
   }


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

   public function create(User $user)
   {

      abort_if(Gate::denies('pengajuan create'), 403);
      $x['title']     = 'Buat Pengajuan';
      $x['url_foto']     = Config::get('global.url.bkd.foto');
      $x['rekom_jenis']     = Config::get('global.rekom_jenis');

      $pegawai = $this->pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan.opd.create', $x, compact('pegawai', 'keperluan'));
   }


   public function store(PengajuanOPDStoreRequest $request)
   {
      abort_if(Gate::denies('pengajuan store'), 403);

      try {

        
       

         DB::beginTransaction();

         // default opd ,kirim ke admin inspektorat (penerima id)
         $admin_inspektorat_uuid = "26cabc5d-7c32-4e97-83f0-a02a226783c5";  

         // Ambil data pegawai dari cache ( API BKD )
         $pegawai_cache = $this->pegawaiService->filterByNIP($request->pegawai)[0];

         // Insert data pengajuan ke DB
         $pengajuanStore = $this->pengajuanService->storePengajuan($pegawai_cache, $request);
       

         // Insert data histori pengajuan ke DB
         $this->pengajuanService->storeHistori(
            $pengajuanStore->uuid,
            PengajuanAksi::KIRIM_BERKAS
            ,$admin_inspektorat_uuid);

         // upload 3 file syarat pengajuan

         $upload_file_sk        = new UploadFile();
         $upload_file_pengantar = new UploadFile();
         $upload_file_konversi  = new UploadFile();

         $upload_file_sk->file($request->file('file_sk'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_sk_terakhir)
            ->parent_id($pengajuanStore->id)->save();

         $upload_file_pengantar
            ->file($request->file('file_pengantar_opd'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_pengantar_opd)
            ->parent_id($pengajuanStore->id)->save();

         $upload_file_konversi //optional
            ->file($request->file('file_konversi_nip'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_konversi_nip)
            ->parent_id($pengajuanStore->id)->save();

         DB::commit();
         return $this->success('Pengajuan Berkas Rekomendasi Berhasil Dikirim');
      }
      catch (\Exception $th) {
         DB::rollBack();
         return $this->error('Pengajuan Berkas Rekomendasi Gagal Dikirim' . $th, 400);
      }
   }  

   public function show(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan show'), 403);
      $pengajuan = Pengajuan::with(['keperluan', 'file_sk', 'file_pengantar', 'file_konversi'])->where('uuid', $pengajuan->uuid)->first();
      return response()->json($pengajuan);
   }

   public function edit(Pengajuan $pengajuan, PegawaiService $pegawaiService, User $user)
   {
      abort_if(Gate::denies('pengajuan edit'), 403);
      $x['title']       = 'Ubah Pengajuan';
      $x['url_foto']    = Config::get('global.url.bkd.foto');
      $x['rekom_jenis'] = Config::get('global.rekom_jenis');
      $pegawai = $pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan.opd.edit', $x, compact('pegawai', 'keperluan', 'pengajuan'));
   }

   public function update(Request $request, Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan update'), 403);
   }

   public function destroy(Pengajuan $pengajuan)
   {
      abort_if(Gate::denies('pengajuan destroy'), 403);
   }

   public function histori($uuid)
   {
      $pengajuan = Pengajuan::with(['histori', 'histori.aksi'])->whereUuid($uuid)->first();
      return $this->success('Histori Pengajuan', $pengajuan,);
   }
}
