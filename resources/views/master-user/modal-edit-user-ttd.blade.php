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
<div class="modal fade" id="modal_edit_user_ttd">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title">Ubah Data User Penanda Tangan</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form id="form_edit_user_ttd" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                     <label>Nama Pegawai</label>
                        <select id="nip_ttd" name="nip_ttd" required class="select2  form-control select2bs4"
                            style="width: 100%;">
                            @foreach ($user_ttd as $item)
                                <option value={{ $item['nipbaru'] }}>{{ $item['nama'] }} ({{ $item['nipbaru'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group img_ttd_layout">
                        <x-filepond id='img_ttd' label='File TTD' required='true' max='5 MB' info='( Format File png , Maks 3 MB)' />
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Ubah</button>
                </div>
            </form>
        </div>
    </div>
</div>
