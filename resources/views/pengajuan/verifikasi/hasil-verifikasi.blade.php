<center>
    @if ($hasil->count() > 0)
        <h6 style="color: red"><i class="fas fa-exclamation-triangle"></i>  {{ $hasil->count() }} Data Pelanggaran Ditemukan Dalam Database Pelanggaran </h6>
    @else
        <h6 style="color: green; margin-top:30px"><i class="far fa-check-circle"></i> Data Pelanggaran tidak ditemukan dalam database Pelanggaran</h6>
    @endif
</center>
<div class="bs-example">
    <div class="accordion" id="accordionExample">
        @foreach ($hasil as $item)
            @if ($item->rekom_jenis == 'TEMUAN')
                <div class="card">
                    <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseTwo"><i class="fa fa-angle-right"></i>Pelanggaran Hukuman
                                Disiplin</button>
                        </h2>
                    </div>
                    <div id="collapseTwo" class="collapse " aria-labelledby="headingTwo"
                        data-parent="#accordionExample">
                        <div class="card-body bg_pelanggaran" style="background: aliceblue">
                            <table class="table table-bordered" style="width:100%">
                                <tr>
                                    <th>NIP</th>
                                    <td>{{ $item->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Nama:</th>
                                    <td>{{ $item->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Ketentuan</th>
                                    <td>{{ $item->ketentuan }}</td>
                                </tr>
                                <tr>
                                    <th>Alasan</th>
                                    <td>{{ $item->alasan }}</td>
                                </tr>
                                <tr>
                                    <th>Hukuman</th>
                                    <td>{{ $item->hukuman }}</td>
                                </tr>
                                <tr>
                                    <th>Tgl Input</th>
                                    <td>{{ $item->tgl_input }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                            <button type="button" class="btn btn-link collapsed" data-toggle="collapse"
                                data-target="#collapseThree"><i class="fa fa-angle-right"></i>Pelanggaran Temuan
                            </button>
                        </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                        data-parent="#accordionExample">
                        <div class="card-body" style="background: aliceblue">
                            <table class="table table-bordered" style="width:100%">
                                <tr>
                                    <th>NIP</th>
                                    <td>{{ $item->nip }}</td>
                                </tr>
                                <tr>
                                    <th>Nama:</th>
                                    <td>{{ $item->nama }}</td>
                                </tr>
                                <tr>
                                    <th>No LHP</th>
                                    <td>{{ $item->no_lhp }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun Temuan</th>
                                    <td>{{ $item->tahun_temuan }}</td>
                                </tr>
                                <tr>
                                    <th>Tgl Input</th>
                                    <td>{{ $item->tgl_input }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
