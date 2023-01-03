<style>
    .timeline-footer {
        padding: 0 0 5px 10px !important;
    }

    .timeline-footer .time {
        font-size: 12px;
        color: rgb(147, 147, 147) !important;
    }
</style>
<div class="modal fade" id="modal_filter">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Laporan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Status Pengajuan</label>
                                    <select name="status" required type=""
                                        class="select2 select2-status form-control select2bs4" style="width: 100%;">
                                        <option value=""> Semua </option>
                                        <option value="proses">Proses</option>
                                        <option value="tolak">Tolak</option>
                                        <option value="selesai">Selesai</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Rekomendasi</label>
                                    <select name="rekom_jenis"
                                        class="select2 select2-rekom-jenis form-control select2bs4"
                                        style="width: 100%;">
                                        <option value=""> Semua Jenis Rekom </option>
                                        <option value="DISIPLIN">Bebas Hukuman Disiplin</option>
                                        <option value="TEMUAN">Bebas Temuan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>OPD Pengirim</label>
                                    <select name="opd_id"
                                        class="select2 select2-filter select2-opd form-control select2bs4"
                                        style="width: 100%;">
                                        <option value=""> Semua OPD </option>
                                        @foreach ($opd as $item)
                                            <option value="{{ $item->nunker }}"> {{ $item->nunker }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn_terapkan_filter btn btn-primary">Terapkan</button>
            </div>
        </div>
    </div>
</div>
