@if (in_array($status, [1, 2, 3, 4, 5, 7]))
    <span class="badge badge-primary">Proses</span>
@endisset


@if (in_array($status, [6]))
    <span class="badge badge-success">Selesai</span>
@endisset


@if (in_array($status, [8]))
    <span class="badge badge-danger">Ditolak</span>
@endisset
