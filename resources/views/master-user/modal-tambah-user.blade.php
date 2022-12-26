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
<div class="modal fade" id="modal_tambah_user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Tambah User Baru</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_tambah_user">
                @csrf
                <div class="modal-body">
                  <x-select2 id="opd_id" label='Pilih OPD' required="true" placeholder='Pilih OPD'>
                     @foreach ($opd as $item)
                         <option></option>
                         <option value='{{ $item->id }}'>{{ $item->nunker }}</option>
                     @endforeach
                 </x-select2>
                 
                    <div class="form-group">
                        <label>Username</label>
                        <input hidden id="user_id" name="user_id"></input>
                        <input required name="username" class="input form-control" rows="3"
                            placeholder="Username Admin OPD"></input>
                        <span style="font-size: 12px"
                            class="text-danger error-text username_err error invalid-feedback"></span>
                    </div>
                 
                    <div class="form-group">
                        <label>Password </label>
                        <div class="input-group mb-3 " id="show_hide_password1">
                            <input required name="password" type="password" class="form-control">
                            <div class="input-group-append">
                                <span class="input-group-text"> <a href="" style="color: inherit"><i
                                            class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            </div>
                            <span style="font-size: 12px"
                                class="text-danger error-text password_err error invalid-feedback"></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
