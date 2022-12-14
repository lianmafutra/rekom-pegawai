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
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Filter Data </h5>
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
                              <label>Jenis Rekomendasi</label>
                              <select name="rekom_jenis" id="select_rekom_rekom" class="select2 select2-opd form-control select2bs4" style="width: 100%;">
                                  <option value=""> Semua Data </option>
                                  <option value="DISIPLIN">Bebas Hukuman Disiplin</option>
                                  <option value="TEMUAN">Bebas Temuan</option>
                              </select>
                          </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer justify-content-between">
               <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
               <button type="button" class="btn_terapkan_filter btn btn-primary" data-dismiss="modal">Terapkan</button>
            </div>
        </div>
    </div>
</div>
