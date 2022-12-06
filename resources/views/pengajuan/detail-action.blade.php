

@if(in_array("teruskan", $aksi))
    <button id="btn_teruskan" class="mt-1 btn btn-primary"><i class="fas fa-share"></i>Teruskan</button>
@endisset

@if(in_array("selesaikan", $aksi))
    <button id="btn_selesai" class="mt-1 btn btn-success"><i class="fas fa-check-circle"></i> Selesaikan Berkas</button>
@endisset

@if(in_array("tolak", $aksi))
    <button id="btn_tolak" class="mt-1 btn btn-danger"><i class="fas fa-ban"></i> Tolak Berkas</button>
@endif

@if(in_array("file_rekom", $aksi))
    <button id="btn_file_rekom" class="mt-1 btn btn-warning"> <i class="fas fa-file-alt"></i> File Rekomendasi</button>
@endisset
