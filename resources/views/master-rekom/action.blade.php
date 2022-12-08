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
            <li><a  data-url="{{ route('master-rekom.edit', $data) }}" class="btn_edit dropdown-item" href="#">Edit</a> </li>
            <div class="dropdown-divider"></div>
            <li><a data-nama="{{ $data->nama }}"  data-url="{{ route('master-rekom.destroy', $data->id) }}" class="btn_hapus dropdown-item" href="#">Hapus
               <form hidden id="form-delete" action="{{ route('master-rekom.destroy', $data->id) }}" method="POST"> @csrf
                  @method('DELETE')
              </form>
            </a> </li>
            <div class="dropdown-divider"></div>
            <li><a  href="#" class="btn_detail dropdown-item">Detail</a></li>
        </ul>
    </div>
</div>
</td>
</tr>
