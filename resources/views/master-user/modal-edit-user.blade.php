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
<div class="modal fade" id="modal_edit_user">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Data User</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_edit_user" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                  <div class="form-group">
                     <label> Pilih OPD
                       
                             <span style="color: red">*</span>
                        
                     </label>
                     <select id="opd_id_edit" name="opd_id" required 
                         class="select2  form-control select2bs4" 
                         style="width: 100%;">
                         @foreach ($opd as $item)
                         <option></option>
                         <option value='{{ $item->id }}'>{{ $item->nunker }}</option>
                     @endforeach
                     </select>
                     <span class="text-danger error-text opd_id_err"></span>
                 </div>
                  
               
                 
                    <div class="form-group">
                        <label>Username</label>
                        <input hidden id="user_id_edit" name="user_id"></input>
                        <input required id="username_edit" name="username" class="input form-control" rows="3"
                            placeholder="Username Admin OPD"></input>
                        <span style="font-size: 12px"
                            class="text-danger error-text username_err error invalid-feedback"></span>
                    </div>

                    {{-- <div class="form-group">
                    <label>Nama</label>
                    <input hidden id="user_id" name="user_id"></input>
                    <input required name="name" class="input form-control" rows="3"
                        placeholder="Nama Admin OPD"></input>
                    <span style="font-size: 12px"
                        class="text-danger error-text name_err error invalid-feedback"></span>
                </div> --}}
                 
                    {{-- <div class="form-group">
                        <label>Password </label>
                        <div class="input-group mb-3 " id="show_hide_password1">
                            <input required name="password" type="password" class="form-control input">
                            <div class="input-group-append">
                                <span class="input-group-text"> <a href="" style="color: inherit"><i
                                            class="fa fa-eye-slash" aria-hidden="true"></i></a></span>
                            </div>
                            <span style="font-size: 12px"
                                class="text-danger error-text password_err error invalid-feedback"></span>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
