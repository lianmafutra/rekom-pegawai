<style>
   .modal-dialog {
       min-height: calc(100vh - 60px);
       display: flex;
       flex-direction: column;
       justify-content: center;
       overflow: auto;
   }

   @media(max-width: 768px) {
       .modal-dialog {
           min-height: calc(100vh - 20px);
       }
   }
</style>
<div class="modal fade" id="modal_tolak">
   <div class="modal-dialog modal-md">
       <div class="modal-content">
           <div class="modal-header">
               <h6 class="modal-title">Konfirmasi Penolakan Berkas</h6>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <form action="{{ route('pengajuan.verifikasi.kirim') }}" method="POST">
               @csrf
               <div class="modal-body">
                   <input hidden name="selesai">
                   <input hidden name="pengajuan_uuid" value="{{ $pengajuan->uuid }}">
                   <p>Berkas akan dikembalikan ke OPD Pengirim, Tuliskan Informasi Pesan Penolakan</p>
                   <div class="form-group">
                       <label></label>
                       <textarea class="form-control" rows="3" placeholder="Pesan Penolakan"></textarea>
                   </div>
               </div>
               <div class="modal-footer">
                   <button type="submit" class="btn btn-primary">Ok, Lanjutkan Penolakan</button>
               </div>
           </form>
       </div>
   </div>
</div>
