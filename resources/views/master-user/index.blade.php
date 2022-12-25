@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
<style>
   .filter_result{
      color: blue
   }
</style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Master Data User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengajuan </li>
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
                            <div class="card-header">
                                <h3 class="card-title">
                                    <a href="#" class="btn btn-sm btn-primary" id="btn_input_data"><i
                                            class="fas fa-plus"></i> Input Data</a>
                                    <a href="#" class="btn btn-sm btn-default" id="btn_filter"><i
                                            class="fas fa-filter"></i> Filter Data</a> 
                                            <a id="filter_text" style="font-size: 12px; margin-left: 10px"> </a>
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="card-body table-responsive">
                                        <table id="tabel_user" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Username</th>
                                                    <th>Nama</th>
                                                    <th>OPD</th>
                                                    <th>Last Login</th>
                                                   
                                                    <th>#Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
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
  
@endsection
@push('js')
    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.select2bs4').select2({
                theme: 'bootstrap4',
            })

            let rekom_jenis;
            let tabel_user = $("#tabel_user").DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: @json(route('master-user.index')),
                  //   data: function(e) {
                  //       e.rekom_jenis = rekom_jenis
                  //   }
                },
                columns: [{
                        data: "DT_RowIndex",
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'opd.nunker',
                    },
                    {
                        data: 'created_at',
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false,
                    },
                ]
            });
            
      

            $(".btn_terapkan_filter").click(function() {
                select_rekom = $('#select_rekom_rekom').val();
                if (select_rekom == 'DISIPLIN') {
                    showTableDisiplin()
                    $('#filter_text').html("Filter berdasarkan data : <span class=filter_result>"+ @json(config('global.rekom_jenis.DISIPLIN'))+"</span>")
                }
                if (select_rekom == 'TEMUAN') {
                     $('#filter_text').html("Filter berdasarkan data : <span class=filter_result>"+ @json(config('global.rekom_jenis.TEMUAN'))+"</span>")
                    showTableTemuan()
                }
                if (select_rekom == '') {
                  $('#filter_text').hide()
                  resetKolomTabelRekom();
                }

                rekom_jenis = $('#select_rekom_rekom').val();
                tabel_user.draw();

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
            $("#btn_filter").click(function() {
                $('#modal_filter').modal('show')
            });
        
            $("#btn_input_data").click(function() {
                $('#modal_jenis_rekom').modal('show')
            });

           

            $('body').on('click', '.btn_hapus', function(e) {
                let nama = $(this).attr('data-nama');
                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus data ?',
                    text: nama,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).find('#form-delete').submit();
                    }
                })
            });
        });
    </script>
   
@endpush
