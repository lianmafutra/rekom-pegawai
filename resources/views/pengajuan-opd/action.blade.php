<style>
    .dropdown-menu>li>a:hover {
        background-color: rgba(127, 75, 223, 0.189);
    }
</style>
<div class="btn-group-vertical">

    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
        </button>
        <ul class="dropdown-menu">
            <li><a  data-url="{{ route('pengajuan.histori', $data->uuid) }}" class="btn_lihat_histori dropdown-item" href="#">Lihat Histori </a> </li>
            <div class="dropdown-divider"></div>
            <li><a data-host="{{ "http://".request()->getHttpHost() }}" data-url="{{ route('pengajuan.show', $data) }}" class="btn_detail_pengajuan dropdown-item" href="#">Detail</a></li>
        </ul>
    </div>
</div>
</td>
</tr>
