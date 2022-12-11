<style>
    .modal-dialog {
        min-height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        justify-content: center;
        overflow: auto;
    }

    @media(max-width: 768px) {
        .modal-dialog {
            min-height: calc(100vh - 20px);
        }
    }
</style>
<div class="modal fade" id="modal_teruskan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Teruskan Pengajuan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengajuan.verifikasi.kirim') }}" method="POST">
               @csrf
            
                <div class="modal-body">
                    <h6 id="nama_file"></h6>
                    <div class="embed_box">
                        <div class="form-group">
                            <label>Kepada :</label>
                            <input hidden name="pengajuan_uuid" value="{{ $pengajuan->uuid }}">
                            
                            @if (auth()->user()->getRoleNames()[0] == "inspektur")
                                 <input hidden name="aksi_id" value="5">
                            @else
                                 <input hidden name="aksi_id" value="4">
                            @endif
                          
                            <select name="penerima_uuid" class="select2 select2-pegawai form-control select2bs4" style="width: 100%;">
                                @foreach ($user_kirim as $item)
                              
                                    <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
