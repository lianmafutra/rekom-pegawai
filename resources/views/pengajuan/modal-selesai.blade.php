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
<div class="modal fade" id="modal_selesai">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Berkas Telah Selesai</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pengajuan.aksi.selesai') }}" method="POST">
               @csrf
                <div class="modal-body">
                     <input hidden name="pengajuan_uuid" value="{{ $pengajuan->uuid }}">
                    <div class="embed_box">
                        <p>Selesaikan Berkas, dan Kirim Surat Rekomendasi ke OPD Pengirim</p>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
