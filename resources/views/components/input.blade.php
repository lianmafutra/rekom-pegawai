<div class="form-group">
    <label>{{ $label }} 
      @if ($required == 'true')
                    <span style="color: red">*</span>
                @endif
    </label>
    <input id="{{ $id }}" type="text" class="form-control" name="{{ $id }}"
        placeholder="" value="">
    <span class="text-danger error-text {{ $id }}_err"></span>
</div>
