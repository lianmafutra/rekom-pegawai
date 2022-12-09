@extends('admin.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }} ">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@section('content')
    <div class="content-wrapper">
      
      <x-header title='Ubah Data Temuan' />

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                           <form action="{{ route('master-rekom.update', $masterRekom) }}" method="POST">
                              @csrf
                              @method('PUT')
                                <div class="card-body">
                                    <div class="tab-content">
                                       <input hidden name="rekom_jenis" value="TEMUAN">
                                        <x-select2 id="opd" label='Pilih OPD' required="true">
                                            @foreach ($opd as $item)
                                                <option value='{{ $item->kunker }}'>{{ $item->nunker }}</option>
                                            @endforeach
                                        </x-select2>
                                        <x-select2 id="nip" label='Nama Pegawai' required="true">
                                            <option></option>
                                        </x-select2>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Nomor LHP </span></label>
                                                <input type="text" class="form-control" name="no_lhp"
                                                    placeholder="Nomor LHP" value="{{ $masterRekom->no_lhp }}">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Tahun Temuan</span></label>
                                            <input type="text" class="form-control" name="tahun_temuan"
                                                placeholder="Tahun Temuan" value="{{ $masterRekom->tahun_temuan }}">
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

      $('#opd').val(@json($kunker)).trigger('change');
      getPegawai(@json($kunker))
   
      $('#opd').change(function() {
          var kunker = $(this).val();
          $('#nip').val(null).trigger('change');
          getPegawai(kunker)
      });

      function getPegawai(kunker) {
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
              $('#nip').val(@json($masterRekom->nip)).trigger('change');
          });
      }
  </script>
@endpush
