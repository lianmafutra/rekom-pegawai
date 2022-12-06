<script>
    $('body').on('click', '.btn_lihat_histori', function(e) {
            $('#modal_lihat_histori').modal('show')
            $('.modal_content_histori').empty()
            
            $.ajax({
                url: $(this).attr('data-url'),
                type: 'GET',
                success: function(json) {
                  console.log(json.data.histori)
                  json.data.histori.forEach($item => {
                        if ($item.pengajuan_aksi_id == 6) {
                            $(".modal_content_histori").append(`<div>
                        <i style="color: white !important" class="${$item.aksi.icon}"></i>
                        <div class="timeline-item">
                           <div class="timeline-body">
                              ${$item.aksi.pesan}  <a href="#"> ${$item.user_nama}</a>
                           </div>
                           <div class="dropdown-divider"></div>
                           <div class="timeline-footer">
                              <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                           </div>
                        </div>
                     </div>`);
                        } else {
                            $(".modal_content_histori").append(`<div>
                        <i style="color: white !important" class="${$item.aksi.icon}"></i>
                        <div class="timeline-item">
                           <div class="timeline-body">
                              <a href="#"> ${$item.user_nama}</a> ${$item.aksi.pesan}
                           </div>
                           <div class="dropdown-divider"></div>
                           <div class="timeline-footer">
                              <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                           </div>
                        </div>
                     </div>`);
                        }
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Gagal Mengambil data histori, silahkan coba lagi ...")
                }
            })
        })
</script>
