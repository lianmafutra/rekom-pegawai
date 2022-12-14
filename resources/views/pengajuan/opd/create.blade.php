@extends('admin.layouts.master')
@push('css')
    <link href="{{ asset('plugins/filepond/filepond.css') }}" rel="stylesheet" />
    <link href="{{ asset('plugins/select2/css/select2.min.css') }} " rel="stylesheet">
    <link href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/flatpicker/flatpickr.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <style>
        .info-data-api {
            font-size: 11px;
            color: #9459fd;
        }

        .loading-custom {
            display: none;
            z-index: 9999999;
            left: 0;
            width: 120px;
            right: 0;
            top: 130px;
            margin-left: auto;
            margin-right: auto;
            position: absolute
        }

        .profile-custom {
            border: 1px solid #adb5bd !important;
            margin: 0 auto;
            border-radius: 5%;
            background-position: center center;
            background-repeat: no-repeat;
            width: 250px;
            object-fit: cover;
            height: 300px;
        }

        .form-control {
            font-size: 14px !important;
        }

        /* .filepond--file {
                background: #28a745;
            } */

        .filepond--drop-label.filepond--drop-label label {
            font-weight: 200 !important;
        }
    </style>
    <div class="content-wrapper">
        <x-header title='Buat Pengajuan Rekomendasi' />
        <section class="content">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="row">
                                    <div class="col-md-6 card-body">
                                        <form id="form_pengajuan" name="form_pengajuan" method="POST" autocomplete="off"
                                            enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <x-select2 id="pegawai" label='Nama Pegawai' required="true" placeholder="-- Pilih Pegawai --">
                                                @foreach ($pegawai as $key => $item)
                                                    <option value="{{ $item['nipbaru'] }}"> {{ $item['nama'] }}
                                                        ({{ $item['nipbaru'] }})
                                                    </option>
                                                @endforeach
                                            </x-select2>
                                            <x-input id='nomor_pengantar' label='Nomor Surat Pengantar' required=true />
                                            <div class="form-group">
                                                <input hidden name="penerima_uuid"
                                                    value="26cabc5d-7c32-4e97-83f0-a02a226783c5">

                                               
                                            </div>
                                            <x-datepicker id='tgl_pengantar' label='Tanggal Pengantar Surat'
                                                required='true' />
                                            <x-select2 id="rekom_jenis" label="Jenis Rekomendasi" required="true">
                                                @foreach ($rekom_jenis as $key => $item)
                                                    <option value="{{ $key }}">{{ $item }}
                                                    </option>
                                                @endforeach
                                            </x-select2>
                                            <x-select2 id="keperluan_id" label="Keperluan Rekomendasi" required="true">
                                                @foreach ($keperluan as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </x-select2>
                                            <x-textarea id='catatan' label='Catatan Tambahan'
                                                hint='Tuliskan Catatan Tambahan (Opsional)' required='false' />
                                            <x-filepond id='file_sk' label='File SK PNS' required='true' max='5 MB' info='( Format File Pdf , Maks 5 MB)' />
                                            <x-filepond id='file_pengantar_opd' label='File Surat Pengantar kepala OPD'
                                                required='true' max='5 MB' info='( Format File Pdf , Maks 5 MB)' />
                                            <x-filepond id='file_konversi_nip' label='File Konversi NIP ( Opsional )'
                                                required='false' max='5 MB' info='( Format File Pdf , Maks 5 MB)' />
                                    </div>
                                    <div style="margin-left: 10px;" class="col-md-5 card ">
                                        <div class="card-header">
                                            <h6>Detail Pegawai</h6>
                                        </div>
                                        <div class="card-body box-profile">
                                            <img class="loading loading-custom" src="{{ asset('img/loading.gif') }}">
                                            <div class="profile_data">
                                                <div class="text-center">
                                                    <img class="profile-user-img profile-custom  img-fluid img-circle"
                                                        src="{{ asset('img/avatar2.png') }}" alt="User profile picture">
                                                </div>
                                                <ul class="list-group list-group-unbordered mb-3 mt-3">
                                                    <li class="list-group-item">
                                                        <b>Nama Lengkap : </b> <a class="float-right nama"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>NIP : </b> <a class="float-right nip"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Pangkat/Gol : </b> <a class="float-right pangkat"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>Jabatan : </b> <a class="float-right jabatan"></a>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <b>OPD : </b> <a class="float-right opd"></a>
                                                    </li>
                                                    <div class="info-data-api profile_data"
                                                        style="display: none; font-style: italic; padding : 20px 0 0 0">
                                                        <span>Data Sinkron dari Dinas BKPSDMD ( 10-12-2022 10:09 ),
                                                            Apabila ada data pegawai yang tidak sesuai silahkan
                                                            menghubungi Dinas Komunikasi & Informatika Kota Jambi</span>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" id="btn_submit" class="btn btn-primary">Submit
                                        Berkas</button>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
    @include('pengajuan.modal-view-file')
@endsection
@push('js')
    <script src="{{ asset('plugins/flatpicker/flatpickr.min.js') }}"></script>
    <script src="{{ asset('plugins/flatpicker/id.min.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-metadata.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-encode.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('plugins/filepond/filepond-plugin-file-validate-size.js') }} "></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/bootbox/bootbox.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2-min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // Filepond
            FilePond.registerPlugin(
                FilePondPluginFileEncode,
                FilePondPluginFileValidateType,
                FilePondPluginFileValidateSize);
            const file_sk = FilePond.create(document.querySelector('#file_sk'));
            const file_pengantar = FilePond.create(document.querySelector('#file_pengantar_opd'));
            const file_konversi_nip = FilePond.create(document.querySelector('#file_konversi_nip'));

            file_sk.setOptions({
                storeAsFile: true,
            });
            file_pengantar.setOptions({
                storeAsFile: true,
            });
            file_konversi_nip.setOptions({
                storeAsFile: true,
            });
            flatpickr(".tanggal", {
                allowInput: true,
                dateFormat: "d-m-Y",
                locale: "id",
            });
            $("#btn_submit").click(function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Konfirmasi Pengajuan',
                    text: 'Apakah anda yakin ingin melanjutkan pengajuan berkas rekomendasi ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Lanjutkan',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $("#form_pengajuan").submit();
                    }
                })
            });
            $("#form_pengajuan").submit(function(e) {
                e.preventDefault();
                const formData = new FormData(this);
                file_sk2 = file_sk.getFiles();
                $.ajax({
                    type: 'POST',
                    url: @json(route('pengajuan.store')),
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
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Mengirim Berkas',
                                html: 'Berkas anda akan segera di verifikasi oleh Dinas Inspektorat Kota Jambi ',
                                showCancelButton: true,
                                allowEscapeKey: false,
                                showCancelButton: false,
                                allowOutsideClick: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = @json(route('pengajuan.index'))
                                }
                            })
                           
                        }
                    },
                    error: function(response) {
                        showError(response)
                    }
                });
            });

           
            // select2
            $('.select2bs4').select2({
                theme: 'bootstrap4',
                //  allowClear: true
            })
            // select2 validation
            $('.select2').change(function() {
                $(this).closest("div").find('.just-validate-error-label').remove()
            })
            $('.select2-pegawai').change(function() {
                $('.profile-user-img').attr("src", "");
                $('.loading').css('display', 'block')
                $('.profile_data').css('display', 'none')
                let nip = $(this).val();
                $.ajax({
                    url: `{{ url('admin/pegawai/${nip}') }}`,
                    type: 'GET',
                    tryCount: 0,
                    retryLimit: 3,
                    success: function(json) {
                        $(".profile_data").fadeIn(1100);
                        $('.profile-user-img').attr("src", @json($url_foto) + json
                            .photo);
                        $('.nama').html(json.nama ? json.nama : '-')
                        $('.nip').html(json.nipbaru)
                        $('.pangkat').html(json.pangkat)
                        $('.jabatan').html(json.njab)
                        $('.opd').html(json.nunker)
                        $(".loading").fadeOut(1000);
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert("Gagal Mengambil data pegawai, silahkan coba lagi ...")
                    }
                });
            });
        });
    </script>
@endpush
