<div class="form-group ">
    <label>{{ $label }}
        @if ($required == 'true')
            <span style="color: red">*</span>
        @endif
        <span class="file_info"
            style="font-size: 10px !important; color: #737373!important; font-style: italic;">
          {{ $info }} </span>
    </label>
    <input id="{{ $id }}" type="file" data-max-file-size="{{ $max }}" class="filepond "
        accept="{{ config('upload.pengajuan.filetype') }}" name="{{ $id }}">
    <span  class="text-danger error-text {{ $id }}_err"></span>
</div>
