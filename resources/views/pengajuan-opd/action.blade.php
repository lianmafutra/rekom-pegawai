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
            <li><a class="btn_lihat_histori dropdown-item" href="#">Lihat Histori </a> </li>
            <div class="dropdown-divider"></div>
            <li><a class="dropdown-item" href="{{ route('pengajuan.edit', $data->id) }}">Detail</a></li>
        </ul>
    </div>
</div>
</td>
</tr>
