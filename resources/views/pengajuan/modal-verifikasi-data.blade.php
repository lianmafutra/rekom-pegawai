<div class="modal fade" id="modal_verifikasi">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Hasil Verifikasi Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body card-body">
                <section class="content">
                    <div class="container-fluid">
                        <div class="row">
                            <div style="min-height: 100px" class="col-md-12">
                              
                                <center>
                                    {{-- <h4 style="color: green">Data Pelanggaran tidak ditemukan dalam database</h4> --}}
                                    <h6 style="color: red">Data Pelanggaran Ditemukan dalam database</h6>
                                </center>
                            </div>
                        </div>
                        <div class="overlay" style="background-color:rgb(219 219 219 / 70%)">
                           <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                       </div>
                       <div class="modal-footer justify-content-between">
                           <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                       </div>
                    </div>



                    
                </section>
               
            </div>
           
        </div>
    </div>
</div>
