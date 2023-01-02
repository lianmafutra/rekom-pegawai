@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('template/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link href="{{ asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/filepond/filepond-plugin-image-preview.css') }} " rel="stylesheet" />
@endpush
@section('content')
    <style>
        .filter_result {
            color: blue
        }

        .filepond--image-preview {
            background: #fff;
        }

        .filepond--image-preview-overlay-idle {
            mix-blend-mode: multiply;
            color: rgb(40 40 40 / 21%);
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">- Data User OPD</h1>
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
                                    <a href="#" class="btn_tambah_user btn btn-sm btn-primary" id="btn_input_data"><i
                                            class="fas fa-plus"></i> Tambah User</a>

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
                                                    {{-- <th>Nama</th> --}}
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
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">- User Internal</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="card-body table-responsive">
                                        <table id="tabel_user_ttd" class="table table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>NIP</th>
                                                    <th>Username</th>
                                                    <th>Nama</th>
                                                    <th>TTD</th>
                                                    <th>#Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
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
    @include('master-user.modal-reset-password')
    @include('master-user.modal-tambah-user')
    @include('master-user.modal-edit-user')
    @include('master-user.modal-edit-user-ttd')
@endsection
@push('js')
    <script src="{{ asset('template/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-image-preview.js') }}"></script>
    <script>
        $(document).ready(function() {

            $('.select2bs4').select2({
                theme: 'bootstrap4',
            })

            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,

                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize);

            const img_ttd = FilePond.create(document.querySelector('#img_ttd'));



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
                    //   {
                    //       data: 'name',
                    //   },
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

            let tabel_user_ttd = $("#tabel_user_ttd").DataTable({
                serverSide: true,
                processing: true,
                searching: false,
                lengthChange: false,
                paging: false,
                info: false,
                ordering: false,
                ajax: {
                    url: @json(route('master-user.ttd')),
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
                        data: 'nip',
                    },
                    {
                        data: 'username',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'img_ttd',
                        className: 'dt-body-center',
                    },
                    {
                        data: "action",
                        orderable: false,
                        searchable: false,
                    },
                ]
            });

            $('.btn_tambah_user').click(function(e) {
                e.preventDefault();
                clearInput()
                $('#modal_tambah_user').modal('show')
            });

            $("#show_hide_password1 a").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password1 input').attr("type") == "text") {
                    $('#show_hide_password1 input').attr('type', 'password');
                    $('#show_hide_password1 i').addClass("fa-eye-slash");
                    $('#show_hide_password1 i').removeClass("fa-eye");
                } else if ($('#show_hide_password1 input').attr("type") == "password") {
                    $('#show_hide_password1 input').attr('type', 'text');
                    $('#show_hide_password1 i').removeClass("fa-eye-slash");
                    $('#show_hide_password1 i').addClass("fa-eye");
                }
            });

            $('body').on('click', '.btn_reset_password', function(e) {
                e.preventDefault();
                $('#modal_reset_password').modal('show')
                let name = $(this).attr('data-name');
                let id = $(this).attr('data-id');
                $('#user_id').val(id)
            });

            $('body').on('click', '.btn_edit', function(e) {
                e.preventDefault();
                clearInput()
                $('#modal_edit_user').modal('show')
                let url = $(this).attr('data-url');
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: (response) => {
                        console.log(response)
                        $('#user_id_edit').val(response.data.id)
                        $('#opd_id_edit').val(response.data.opd_id).trigger("change");
                        $('#username_edit').val(response.data.username)
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

            $('body').on('click', '.btn_edit_ttd', function(e) {
                e.preventDefault();
                let username = $(this).attr('data-username');

                if (username != 'inspektur') {
                    $('.img_ttd_layout').hide();
                } else {
                    $('.img_ttd_layout').show();
                }
                $('#modal_edit_user_ttd').modal('show')
                let url = $(this).attr('data-url');
                $.ajax({
                    type: 'GET',
                    url: url,
                    dataType: 'json',
                    success: (response) => {
                        console.log(response)
                        $('#user_id_edit').val(response.data.uuid)
                        $('#nip_ttd').val(response.data.nip).trigger("change");
                        $('#username_edit').val(response.data.username)
                        img_ttd.setOptions({
                            storeAsFile: true,
                            files: [{
                                source: '/storage/template/' + response.data.img_ttd
                                   
                            }]
                        });
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

            $("#form_reset_password").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: @json(route('master-user.password.reset')),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            $('#modal_reset_password').modal('hide')
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Mereset Password User',
                                showCancelButton: true,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                swal.hideLoading()
                                tabel_user.ajax.reload();
                            })
                            swal.hideLoading()
                        }
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

            $("#form_tambah_user").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: @json(route('master-user.store')),
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            $('#modal_tambah_user').modal('hide')
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showCancelButton: true,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                swal.hideLoading()
                                tabel_user.ajax.reload();
                            })
                            swal.hideLoading()
                        }
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

            $("#form_edit_user").submit(function(e) {
                e.preventDefault();
                let id = $('#user_id_edit').val();
                let url = "{{ route('master-user.update', ':id') }}";
                let result = url.replace(':id', id);
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: result,
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showCancelButton: true,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                swal.hideLoading()
                                tabel_user.ajax.reload();
                                $('#modal_edit_user').modal('hide')
                            })
                            swal.hideLoading()
                        }
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

            $("#form_edit_user_ttd").submit(function(e) {
                e.preventDefault();
                let id = $('#user_id_edit').val();
                let url = "{{ route('master-user.ttd.update', ':id') }}";
                let result = url.replace(':id', id);
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: result,
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        showLoading()
                    },
                    success: (response) => {
                        if (response) {
                            this.reset()
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showCancelButton: true,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                swal.hideLoading()
                                tabel_user_ttd.ajax.reload();
                                $('#modal_edit_user_ttd').modal('hide')
                            })
                            swal.hideLoading()
                        }
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
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
