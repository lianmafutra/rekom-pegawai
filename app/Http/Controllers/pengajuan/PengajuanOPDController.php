<?php
// 
namespace App\Http\Controllers\pengajuan;

use App\Config\PengajuanAksi;
use App\Http\Controllers\Controller;
use App\Http\Requests\PengajuanOPDStoreRequest;
use App\Http\Services\Pegawai\PegawaiService;
use App\Http\Services\Pegawai\PengajuanService;
use App\Models\File;
use App\Models\Keperluan;
use App\Models\Pengajuan;
use App\Models\User;
use App\Utils\ApiResponse;
use App\Utils\UploadFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
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
               $status = $this->pengajuanService->cekPengajuanStatus($data->uuid);
               return view('pengajuan.opd.action', compact('data', 'status'));
            })
            ->editColumn('status', function ($data) {
               $status = $this->pengajuanService->cekPengajuanStatus($data->uuid);
               return view('pengajuan.status', compact('status'));
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
      }
      return view('pengajuan.opd.index', $x, compact('data'));
   }

   public function create(User $user)
   {

      abort_if(Gate::denies('pengajuan create'), 403);
      $x['title']       = 'Buat Pengajuan';
      $x['url_foto']    = Config::get('global.url.bkd.foto');
      $x['rekom_jenis'] = Config::get('global.rekom_jenis');

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
            PengajuanAksi::KIRIM_BERKAS,
            $admin_inspektorat_uuid
         );
         // upload 3 file syarat pengajuan
         $uploadFile = new UploadFile();
         
         $uploadFile->file($request->file('file_sk'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_sk_terakhir)
            ->parent_id($pengajuanStore->id)
            ->save();
            
         $uploadFile
            ->file($request->file('file_pengantar_opd'))
            ->path('pengajuan')
            ->uuid($pengajuanStore->file_pengantar_opd)
            ->parent_id($pengajuanStore->id)
            ->save();

         if ($request->hasFile('file_konversi_nip')) {
            $uploadFile //optional
               ->file($request->file('file_konversi_nip'))
               ->path('pengajuan')
               ->uuid($pengajuanStore->file_konversi_nip)
               ->parent_id($pengajuanStore->id)
               ->save();
         }
         DB::commit();
         return $this->success('Pengajuan Berkas Rekomendasi Berhasil Dikirim');
      } catch (\Throwable $th) {
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

   public function revisi($pengajuan_uuid, Pengajuan $pengajuan, User $user)
   {
     
      abort_if(Gate::denies('pengajuan revisi'), 403);
      $x['title']       = 'Revisi Pengajuan';
      $x['url_foto']    = Config::get('global.url.bkd.foto');
      $x['rekom_jenis'] = Config::get('global.rekom_jenis');
      $pengajuan = $pengajuan->getPengajuanWithData($pengajuan_uuid);

      $pegawai = $this->pegawaiService->filterByOPD($user->getWithOpd()->kunker);
      $keperluan = Keperluan::get();
      return view('pengajuan.opd.revisi', $x, compact('pegawai', 'pengajuan', 'keperluan'));
   }


   public function updateRevisi(Request $request)
   {

      try {
         DB::beginTransaction();

         // default opd ,kirim ke admin inspektorat (penerima id)
         $admin_inspektorat_uuid = "26cabc5d-7c32-4e97-83f0-a02a226783c5";

         // Ambil data pegawai dari cache ( API BKD )
         $pegawai_cache = $this->pegawaiService->filterByNIP($request->pegawai)[0];

         // Update data pengajuan ke DB
         $pengajuanUpdate = $this->pengajuanService->updatePengajuan($pegawai_cache, $request);

         //Insert data histori pengajuan ke DB dengan status revisi
         $this->pengajuanService->storeHistori(
            $request->pengajuan_uuid,
            PengajuanAksi::REVISI,
            $admin_inspektorat_uuid
         );

         //Upload Syarat File 
         $UpdateFile = new UploadFile();

         $UpdateFile
            ->file($request->file('file_sk'))
            ->path('pengajuan')
            ->uuid($pengajuanUpdate->uuid)
            ->parent_id($pengajuanUpdate->id)
            ->update($pengajuanUpdate->file_sk_terakhir);

         $UpdateFile
            ->file($request->file('file_pengantar_opd'))
            ->path('pengajuan')
            ->uuid($pengajuanUpdate->uuid)
            ->parent_id($pengajuanUpdate->id)
            ->update($pengajuanUpdate->file_pengantar_opd);

         $UpdateFile
            ->file($request->file('file_konversi_nip'))
            ->path('pengajuan')
            ->uuid($pengajuanUpdate->uuid)
            ->parent_id($pengajuanUpdate->id)
            ->update($pengajuanUpdate->file_konversi_nip);
            
         DB::commit();
         return $this->success('Pengajuan Berkas Rekomendasi Berhasil Dikirim');
      } catch (\Exception $th) {
         DB::rollBack();
         return $this->error('Pengajuan Berkas Rekomendasi Gagal Dikirim', 400);
      }
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
