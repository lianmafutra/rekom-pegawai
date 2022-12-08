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
<div class="modal fade" id="modal_jenis_rekom">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Pilih Jenis Inputan Data Rekap: </h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <a href="{{ route('master-rekom.create', 'disiplin') }}" class="btn-block btn btn-md btn-default" id="btn-tambah"></i>Penjatuhan Hukuman
                  Disiplin</a><br>  
                <a href="{{ route('master-rekom.create', 'temuan') }}" class="btn-block btn btn-md btn-default" id="btn-tambah"></i>Data Temuan
                  Catatan</a>
            </div>


        </div>
    </div>
</div>
