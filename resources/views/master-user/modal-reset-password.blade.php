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
<div class="modal fade" id="modal_reset_password">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Reset Password User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_reset_password" action="{{ route('master-user.password.reset') }}" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <p>Apakah anda yakin Mereset Password User <span style="font-weight: bold" class="username"></span>
                        ?</p>
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input hidden id="user_id" name="user_id"></input>
                        <input name="password_baru" class="input form-control" rows="3"
                            placeholder="Masukkan Password baru"></input>
                        <span class="text-danger error error-text password_baru_err"></span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ok Reset</button>
                </div>
            </form>
        </div>
    </div>
</div>
