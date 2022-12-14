<style>
    tr td:first-child {
        color: #313131;
        font-weight: bold;
    }

    .column {
        width: 100%;
    }

    .ico {
        color: orange;
        display: inline-block;
        float: left;
        width: 18px;
        height: 32px;
        margin-top: -6px;
        line-height: 32px;
        background-position: 0 0;
        background-repeat: no-repeat;
    }

    .title {
        display: block;
        overflow: hidden;
    }

    .profile-custom {
        border: 1px solid #adb5bd !important;
        margin: 0 auto;
        border-radius: 5%;
        background-position: center center;
        background-repeat: no-repeat;
        width: 174px;
        object-fit: cover;
        height: 196px;
        margin-bottom: 20px;
    }
    

   
</style>

<div style="z-index: 1041;" class="modal fade" id="modal_detail_pengajuan">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pengajuan Berkas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img class="profile-user-img profile-custom  img-fluid img-circle"
                        src="{{ asset('img/avatar2.png') }}" alt="User profile picture">
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>NIP</td>
                            <td>:</td>
                            <td id="nip"></td>
                        </tr>
                        <tr>
                            <td>Nama Pegawai</td>
                            <td>:</td>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                            <td>Pangkat/Gol</td>
                            <td>:</td>
                            <td id="pangkat"></td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td id="jabatan"></td>
                        </tr>
                        <tr>
                            <td>OPD</td>
                            <td>:</td>
                            <td id="opd"></td>
                        </tr>
                        <tr>
                            <td>Nomor Surat Pengantar</td>
                            <td>:</td>
                            <td id="no_pengantar"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Surat Pengantar</td>
                            <td>:</td>
                            <td id="tgl_pengantar"></td>
                        </tr>
                        <tr>
                            <td>Jenis Rekomendasi</td>
                            <td>:</td>
                            <td id="rekom_jenis"></td>
                        </tr>
                        <tr>
                            <td>Keperluan Rekomendasi</td>
                            <td>:</td>
                            <td id="rekom_keperluan"></td>
                        </tr>
                        <tr>
                            <td style="font-weight: bold">#File</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="column">
                                    <i class="ico fas fa-file"></i>
                                    <span class="title">File Sk Terakhir</span>
                                </div>
                            </td>
                            <td>:</td>
                            <td id="file_sk"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="column">
                                    <i class="ico fas fa-file"></i>
                                    <span class="title">File Surat Pengantar kepala OPD</span>
                                </div>
                            </td>
                            <td>:</td>
                            <td id="file_pengantar"></td>
                        </tr>
                        <tr>
                            <td>
                                <div class="column">
                                    <i class="ico fas fa-file"></i>
                                    <span class="title">File Konversi NIP</span>
                                </div>
                            </td>
                            <td>:</td>
                            <td id="file_konversi"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer ">
                @can('pengajuan verifikasi tolak')
                    <a href="#" type="button" class="btn_pengajuan_tolak btn btn-danger">Tolak</a>
                @endcan
                @can('pengajuan verifikasi kirim')
                    <a href="#" type="button" class="btn_pengajuan_kirim btn btn-success">Teruskan</a>
                @endcan

            </div>
        </div>
    </div>
</div>
