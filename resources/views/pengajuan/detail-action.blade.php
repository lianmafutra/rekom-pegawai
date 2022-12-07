@if(in_array("teruskan", $aksi))
    <a id="btn_teruskan" class="mt-1 btn btn-primary"><i class="fas fa-share"></i> Teruskan</a>
@endisset

@if(in_array("selesaikan", $aksi))
    <a id="btn_selesai" class="mt-1 btn btn-success"><i class="fas fa-check-circle"></i> Selesaikan Berkas</a>
@endisset

@if(in_array("file_rekom", $aksi))
    <a id="btn_file_rekom" class="mt-1 btn btn-warning"> <i class="fas fa-file-alt"></i> File Rekomendasi</a>
@endisset

@if(in_array("tolak", $aksi))
    <a id="btn_tolak" class="mt-1 btn btn-danger"><i class="fas fa-ban"></i> Tolak Berkas</a>
@endif