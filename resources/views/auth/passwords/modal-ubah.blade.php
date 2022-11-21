<div class="modal fade" id="modal-password">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Password</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form name="ubah-password" action="{{ route('password.ubah') }}" method="POST" >
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label>Password Lama <span style="color: red"> *</span> </label>
                        <input required name="password" type="password" class="form-control" id=""
                            placeholder="Password Lama">
                    </div>
                    <div class="form-group">
                        <label>Password Baru <span style="color: red"> *</span> </label>
                        <input id="password_baru" required name="password_baru" type="password" class="form-control" id=""
                            placeholder="Password Baru">
                    </div>
                    <div class="form-group">
                        <label>Password Konfirmasi <span style="color: red"> *</span> </label>
                        <input id="password_konfirmasi" required name="password_konfirmasi" type="password" class="form-control" id=""
                            placeholder="Password Konfirmasi">
                    </div>

            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Lanjutkan, Ubah</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
</div>
