@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Pengajuan Masuk</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengajuan q</li>
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
                                    @can('pengajuan create')
                                        <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary"
                                            id="btn-tambah"><i class="fas fa-plus"></i> Buat Pengajuan</a>
                                    @endcan
                                    @can('pengajuan filter')
                                        <a href="#" class="btn btn-sm btn-default" id="btn_filter"><i
                                                class="fas fa-filter"></i> Filter Pengajuan</a>
                                    @endcan
                                    @can('pengajuan cetak laporan')
                                        <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-default"
                                            id="btn_laporan"><i class="fas fa-print"></i></i> Cetak Laporan</a>
                                    @endcan
                                </h3>
                            </div>

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
    @include('pengajuan.modal-filter')
@endsection

@push('js')
    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2bs4').select2({
                theme: 'bootstrap4',
                //  allowClear: true
            })
            
        $("#tabel-pengajuan").dataTable({
            serverSide: true,
            processing: true,
            ajax: `{{ route('pengajuan.verifikasi.index') }}`,
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

        $('body').on('click', '.btn_hapus', function(e) {
                let nama = $(this).attr('data-nama');
                let url = $(this).attr('data-url');
                Swal.fire({
                    title: 'Apakah anda yakin ingin menghapus data Permohonan ?',
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

        $("#btn_laporan").click(function() {
           
        });
    </script>
    @include('pengajuan.get-data-histori')
@endpush
