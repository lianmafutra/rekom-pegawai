<div class="form-group">
    <label>{{ $label }}
        @if ($required == 'true')
            <span style="color: red">*</span>
        @endif
    </label>
    <textarea id="{{ $id }}" name="{{ $id }}" class="form-control" rows="3"
        placeholder="{{ $hint }}"></textarea>
</div>
