@extends('admin.layouts.master')
@push('css')
<link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
<style>


</style>
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <div class="content-header">
      <div class="container-fluid">
         <div class="row mb-2">
            <div class="col-sm-6">
               <h1 class="m-0">Pengajuan</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
               <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Pengajuan</li>
               </ol>
            </div><!-- /.col -->
         </div><!-- /.row -->
      </div>
      <!-- /.container-fluid -->
   </div>
   <!-- /.content-header -->
   <!-- Main content -->
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  @can('pengajuan create')
                  <div class="card-header">
                     <h3 class="card-title">
                        <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary" id="btn-tambah"><i
                              class="fas fa-plus"></i> Buat Pengajuan</a>
                     </h3>
                  </div>
                  @endcan
                  <div class="card-body">
                     <div class="tab-content">
                        @if ($data->count() == 0)
                        <center>
                           <h5>Anda Belum Memiliki Pengajuan Berkas</h5>
                        </center>
                        @else
                        <div class="card-body table-responsive">
                           <table id="tabel-pengajuan" class="table table-bordered  " style="width:100%">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jenis Rekom</th>
                                    <th>Keperluan</th>
                                    <th>Tgl Kirim</th>
                                    <th>Status</th>
                                    <th>#Aksi</th>
                                 </tr>
                              </thead>
                           </table>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- /.row -->
      </div><!-- /.container-fluid -->
   </section>
   <!-- /.content -->
</div>

@include('pengajuan.modal-histori')
@include('pengajuan.modal-show')
@endsection
@push('js')
<script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
<script>
   $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#tabel-pengajuan").dataTable({
            serverSide: true,
            processing: true,
            ajax: `{{ route('pengajuan.index') }}`,
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: 'nip',
                },
                {
                    data: 'nama',
                },
                {
                    data: 'rekom_jenis_nama',
                },
                {
                    data: 'keperluan.nama',
                },
                {
                    data: 'tgl_kirim',
                },
                {
                    data: 'status',
                },
                {
                    data: "action",
                    orderable: false,
                    searchable: false,
                },
            ]
        });
      
        $('body').on('click', '.btn_lihat_histori', function(e) {
            $('#modal_lihat_histori').modal('show')

            $('#modal_lihat_histori').modal('show')
            $('.modal_content_histori').empty()
            $.ajax({
                url: $(this).attr('data-url'),
                type: 'GET',
                success: function(json) {
                    json.data.histori.forEach($item => {
                        if ($item.pengajuan_aksi_id == 6) {
                            $(".modal_content_histori").append(`<div>
                        <i style="color: white !important" class="${$item.aksi.icon}"></i>
                        <div class="timeline-item">
                           <div class="timeline-body">
                              ${$item.aksi.pesan}  <a href="#"> ${$item.user_nama}</a>
                           </div>
                           <div class="dropdown-divider"></div>
                           <div class="timeline-footer">
                              <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                           </div>
                        </div>
                     </div>`);
                        } else {
                            $(".modal_content_histori").append(`<div>
                        <i style="color: white !important" class="${$item.aksi.icon}"></i>
                        <div class="timeline-item">
                           <div class="timeline-body">
                              <a href="#"> ${$item.user_nama}</a> ${$item.aksi.pesan}
                           </div>
                           <div class="dropdown-divider"></div>
                           <div class="timeline-footer">
                              <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                           </div>
                        </div>
                     </div>`);
                        }
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Gagal Mengambil data histori, silahkan coba lagi ...")
                }
            })
        })
        $('body').on('click', '.btn_detail_pengajuan', function(e) {
            let url = $(this).attr('data-url');
            let host = $(this).attr('data-host');

            $('#modal_detail_pengajuan').modal('show')
            $('.profile-user-img').attr("src", @json(asset('img/avatar2.png')));
            $.ajax({
                url: url,
                type: 'GET',
                success: function(json) {
                    $("#nama").text(json.nama);
                    $("#nip").text(json.nip);
                    $("#pangkat").text(json.pangkat);
                    $("#jabatan").text(json.njab);
                    $("#opd").text(json.nunker);
                    $("#no_pengantar").text(json.nomor_pengantar);
                    $("#tgl_pengantar").text(json.tgl_surat_pengantar);
                    $("#rekom_jenis").text(json.rekom_jenis_nama);
                    $("#rekom_keperluan").text(json.keperluan.nama);
                    $('.profile-user-img').attr("src",
                        @json(config('global.url.bkd.foto')) + json.photo);
                    $("#file_sk").html(
                        `<a onclick="openCenteredWindow('${host}/storage/${json.file_sk[0].path}/${json.file_sk[0].name_random}')" href="#" type="button" class=" btn btn-primary btn-sm">Lihat File</a>`
                    );
                    $("#file_pengantar").html(
                        `<a onclick="openCenteredWindow('${host}/storage/${json.file_pengantar[0].path}/${json.file_pengantar[0].name_random}')" href="#" type="button" class=" btn btn-primary btn-sm">Lihat File</a>`
                    );
                    $("#file_konversi").html(
                        `<a onclick="openCenteredWindow('${host}/storage/${json.file_konversi[0].path}/${json.file_konversi[0].name_random}')" href="#" type="button" class=" btn btn-primary btn-sm">Lihat File</a>`
                    );
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Gagal Mengambil data pegawai, silahkan coba lagi ...")
                }
            });
        });

        function openCenteredWindow(url) {
            const width = 800
            const height = 700
            const pos = {
                x: (screen.width / 2) - (width / 2),
                y: (screen.height / 2) - (height / 2)
            };
            const features = `width=${width} height=${height} left=${pos.x} top=${pos.y}`;
            return window.open(url, '_blank', features).focus();
        }
</script>
@endpush