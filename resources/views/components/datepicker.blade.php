<div>
    <div class="form-group">
        <div class="bd-highlight">
            <label>{{ $label }}
                @if ($required == 'true')
                    <span style="color: red">*</span>
                @endif
            </label>
            <div style="padding: 0 !important; width: 100%" class="input-group ">
                <input style="width: 90%" id="{{ $id }}" required autocomplete="off" name="{{ $id }}"
                    class="form-control tanggal" type="text" placeholder="Hari/Bulan/Tahun" data-input>
                <div class="input-group-append">
                    <div class="input-group-text"><i class="fa fa-calendar"></i>
                    </div>
                </div>
            </div>
        </div>
        <span class="text-danger error-text {{ $id }}_err"></span>
    </div>
</div>
