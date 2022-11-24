@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
@endpush
@section('content')
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
                                        <a href="{{ route('pengajuan.create') }}" class="btn btn-sm btn-primary"
                                            id="btn-tambah"><i class="fas fa-plus"></i> Buat Pengajuan</a>
                                    </h3>
                                </div>
                            @endcan
                            <div class="card-body">
                                <div class="tab-content">
                                    <center>
                                        <h5>Anda Belum Memiliki Pengajuan Berkas</h5>
                                    </center>
                                    <div class="card-body table-responsive">
                                        <table id="tabel-pengajuan" class="table  table-hover " style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>OPD Pemohon</th>
                                                    <th>Tanggal</th>
                                                    <th>#</th>
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
    <script>
        $("#tabel-pengajuan").dataTable({
            serverSide: true,
            processing: true,
            ajax: `{{ route('pengajuan.index') }}`,
            columns: [{
                    data: "DT_RowIndex",
                    orderable: false,
                    searchable: false,
                    width: "40px"
                },
                {
                    data: 'nama',
                },
                {
                    data: 'nip',
                },
                {
                    data: 'pengirim_id',
                },
                {
                    data: 'created_at',
                },
                {
                    data: "action",
                    orderable: false,
                    searchable: false,
                    width: "40px"
                },
            ]
        });
    </script>
@endpush
