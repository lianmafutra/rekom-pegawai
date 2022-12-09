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
                        <h1 class="m-0">Input Data Hukuman Disiplin Pegawai</h1>
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
                                        <input hidden name="rekom_jenis" value="DISIPLIN">

                                        <x-select2 id="opd" label='Pilih OPD' required="true">
                                            @foreach ($opd as $item)
                                                <option value='{{ $item->kunker }}'>{{ $item->nunker }}</option>
                                            @endforeach
                                        </x-select2>

                                        <x-select2 id="nip" label='Nama Pegawai' required="true">
                                            <option></option>
                                        </x-select2>

                                        <div class="form-group">
                                            <label>Ketentuan Yang Dilanggar</label>
                                            <textarea name="ketentuan" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Alasan Penjatuhan Hukuman</label>
                                            <textarea name="alasan" class="form-control" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Hukuman Yang Di Jatuhkan</label>
                                            <textarea name="hukuman" class="form-control" rows="3"></textarea>
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

        $('#opd').change(function() {
            var kunker = $(this).val();
            $('#nip').val(null).trigger('change');
            $.ajax({
                url: `{{ url('admin/pegawai/opd/${kunker}') }}`,
            }).done(function(json) {
                let data2 = [];
                json.forEach(function(data) {
                    data2.push({
                        id: data.nipbaru,
                        text: `<div> ${data.nama} ( ${data.nipbaru} ) </div>`,
                        html: `<div >${data.nama}  ( ${data.nipbaru} )</div></div>`,
                        title: ''
                    });
                });



                $("#nip").select2({
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
        });
    </script>
@endpush
