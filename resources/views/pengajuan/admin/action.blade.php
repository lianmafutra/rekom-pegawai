<style>
    .dropdown-menu>li>a:hover {
        background-color: rgba(127, 75, 223, 0.189);
    }
</style>
<div class="btn-group-vertical">

    <div class="btn-group">
        <button type="button" class="custom_btn_dropdown btn btn-default dropdown-toggle" data-toggle="dropdown">
        </button>
        <ul class="dropdown-menu">
            <li><a data-url="{{ route('pengajuan.histori', $data->uuid) }}" class="btn_lihat_histori dropdown-item"
                    href="#">Lihat Histori </a> </li>
            <div class="dropdown-divider"></div>
            <li><a href="{{ route('pengajuan.verifikasi.detail', $data->uuid) }}" class="dropdown-item">Detail</a></li>
            <div class="dropdown-divider"></div>
            <li><a href="#" data-nama="{{ $data->nama }}" data-url="{{ route('pengajuan.verifikasi.destroy', $data->uuid) }}"
                    class="btn_hapus dropdown-item">Hapus
                    <form hidden id="form-delete" action="{{ route('pengajuan.verifikasi.destroy', $data->uuid) }}"
                        method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                </a></li>

        </ul>
    </div>
</div>
</td>
</tr>
