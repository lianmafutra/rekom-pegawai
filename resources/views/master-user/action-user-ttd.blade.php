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
           <li><a data-username='{{ $data->username }}' data-url='{{ route('master-user.edit', $data->id) }}' data-update='{{ route('master-user.update', $data->uuid) }}'  href="#" class="btn_edit_ttd dropdown-item" >Ubah Data</a> </li>
       </ul>
   </div>
</div>
</td>
</tr>
