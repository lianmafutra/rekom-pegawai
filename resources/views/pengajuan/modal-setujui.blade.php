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
<div class="modal fade" id="modal_setujui">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Setujui Permohonan Rekomendasi</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_setujui" action="{{ route('pengajuan.aksi.cetak') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <h6 id="nama_file"></h6>
                    <div class="embed_box">
                        <label>Jenis Tanda Tangan :</label>
                        <div style="padding: 20px" class="border rounded form-group">
                            <div style="margin-bottom:0px" class="form-group ">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioPrimary1" name="r1" checked>
                                    <label for="radioPrimary1">
                                        Manual
                                    </label>
                                </div>
                                <div style="margin-left: 20px" class="icheck-success d-inline">
                                    <input type="radio" id="radioPrimary2" name="r1">
                                    <label for="radioPrimary2">
                                        Digital
                                    </label>
                                </div>
                            </div>
                        </div>
                        <label>Password</label>
                        <div class="input-group mb-3"  id="show_hide_password">
                           
                         
                            <input name="password" type="password" class="form-control">
                            
                            <div class="input-group-append" >
                                <span class="input-group-text"> <a href="" style="color: inherit"><i class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            </div>
                        
                          <span style="font-size: 12px" class="text-danger error-text password_err error invalid-feedback"></span>
                        </div>
                        <div hidden style="margin-top: 20px" class="form-group">
                            <label>Diteruskan Kepada :</label>
                            <input hidden name="pengajuan_uuid" value="{{ $pengajuan->uuid }}">
                            <input hidden name="aksi_id" value="4">
                            <select name="penerima_uuid" class="select2 select2-pegawai form-control select2bs4"
                                style="width: 100%;">
                                @foreach ($user_kirim as $item)
                                    <option value="{{ $item->uuid }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <button id="btn_submit_setujui" type="submit" class="btn  btn-primary">Ok, Setujui </button>
                </div>
            </form>
        </div>
    </div>
</div>

