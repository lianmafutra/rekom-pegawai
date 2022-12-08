@extends('admin.layouts.master')
@push('css')
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
                        <h1 class="m-0">Input Data Temuan Pegawai</h1>
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
                    <div class="col-md-6">
                        <div class="card">
                            <form action="{{ route('master-rekom.store') }}" method="POST">
                                @csrf
                                <div class="card-body">
                                    <div class="tab-content">
                                       <input hidden  name="rekom_jenis" value="TEMUAN">
                                        <div class="form-group">
                                            <label>Nama Pegawai<span style="color: red">*</span></label>
                                            <select name="nip" required type=""
                                                class="select2 select2-pegawai form-control select2bs4"
                                                data-placeholder="-- Pilih Pegawai --" style="width: 100%;">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Nomor LHP </span></label>
                                                <input type="text" class="form-control" name="no_lhp"
                                                    placeholder="Nomor LHP">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun Temuan</span></label>
                                            <input type="text" class="form-control" name="tahun_temuan"
                                                placeholder="Tahun Temuan">
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('master-rekom.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" id="btn_submit" class="btn btn-primary">Simpan Data</button>
                        </div>
                        </form>
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
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2bs4').select2({
            theme: 'bootstrap4',
        })
        $.ajax({
            url: @json(route('pegawai.all')),
        }).done(function(json) {
            let data2 = [];
            json.forEach(function(data) {
                data2.push({
                    id: data.nipbaru,
                    text: `<div> ${data.nama} ( ${data.nipbaru} ) </div>`,
                    html: `<div >${data.nama}  ( ${data.nipbaru} )</div><div style="font-size:10px"> - ${data.nunker}</div>`,
                    title: ''
                });
            });
            $("select").select2({
                data: data2,
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    return data.html;
                },
                templateSelection: function(data) {
                    return data.text;
                }
            })
        });

        
    </script>
@endpush
