<style>
   .bs-example{
       margin: 20px;
   }
   .accordion .fa{
       margin-right: 0.5rem;
        font-size: 24px;
        font-weight: bold;
       position: relative;
      top: 2px;
   }
</style>
<div class="modal fade" id="modal_verifikasi">
    <div class="modal-dialog modal-lg">
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
                                <div class="konten_verifikasi">
                                    {{-- content from Ajax --}}
                                    <div class="bs-example">
                                       <div class="accordion" id="accordionExample">
                                          
                                           <div class="card">
                                               <div class="card-header" id="headingTwo">
                                                   <h2 class="mb-0">
                                                       <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo"><i class="fa fa-angle-right"></i>Pelanggaran Hukuman Disiplin</button>
                                                   </h2>
                                               </div>
                                               <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo" data-parent="#accordionExample">
                                                   <div class="card-body bg_pelanggaran" style="background: aliceblue">
                                                       <p>Bootstrap is a sleek, intuitive, and powerful front-end framework for faster and easier web development. It is a collection of CSS and HTML conventions. <a href="https://www.tutorialrepublic.com/twitter-bootstrap-tutorial/" target="_blank">Learn more.</a></p>
                                                   </div>
                                               </div>
                                           </div>
                                           <div class="card">
                                               <div class="card-header" id="headingThree">
                                                   <h2 class="mb-0">
                                                       <button type="button" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree"><i class="fa fa-angle-right"></i>Pelanggaran Temuan </button>                     
                                                   </h2>
                                               </div>
                                               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                                   <div class="card-body" style="background: aliceblue">
                                                       <p>CSS stands for Cascading Style Sheet. CSS allows you to specify various style properties for a given HTML element such as colors, backgrounds, fonts etc. <a href="https://www.tutorialrepublic.com/css-tutorial/" target="_blank">Learn more.</a></p>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="overlay" style="background-color:rgb(219 219 219 / 70%)">
                            <i class="fas fa-2x fa-sync-alt fa-spin"></i>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div> --}}
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
       
    });
</script>

