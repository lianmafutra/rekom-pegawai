<div class="form-group ">
    <label>{{ $label }}
        @if ($required == 'true')
            <span style="color: red">*</span>
        @endif
    </label>
    <input id="{{ $id }}" type="file" data-max-file-size="{{ $max }}" class="filepond "
        accept="{{ config('upload.pengajuan.filetype') }}" name="{{ $id }}">
    <span class="text-danger error-text {{ $id }}_err"></span>
</div>
