<div>
    <div class="form-group">
        <label> {{ $label }}
            @if ($required == 'true')
                <span style="color: red">*</span>
            @endif
        </label>
        <select id="{{ $id }}" name="{{ $id }}" required type=""
            class="select2 select2-{{ $id }} form-control select2bs4" data-placeholder="{{ $placeholder }}"
            style="width: 100%;">
            <option></option>
                {{ $slot }}
        </select>
        <span class="text-danger error-text {{ $id }}_err"></span>
    </div>
</div>
