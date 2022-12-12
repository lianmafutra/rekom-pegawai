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
                     let data_tracking ='';
                        //status =  meneruskan , selesai
                        if($item.pengajuan_aksi_id == 4 || $item.pengajuan_aksi_id == 6){
                           data_tracking = `<a href="#"> ${$item.pengirim_nama}</a> ${$item.aksi.pesan}  <a href="#"> ${$item.penerima_nama}</a>`
                        }else{
                           data_tracking = `<a href="#"> ${$item.pengirim_nama}</a> ${$item.aksi.pesan}`
                        }
                        $(".modal_content_histori").append(
                           `<div>
                           <i style="color: white !important" class="${$item.aksi.icon}"></i>
                           <div class="timeline-item">
                              <div class="timeline-body">
                                    ${data_tracking}
                              </div>
                              <div class="dropdown-divider"></div>
                              <div class="timeline-footer">
                                 <span class="time"><i class="fas fa-clock"></i> ${$item.tgl_kirim} </span>
                              </div>
                           </div>
                        </div>`);
                        
                    });
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert("Gagal Mengambil data histori, silahkan coba lagi ...")
                }
            })
        })
</script>
