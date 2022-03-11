<!-- Card Riwayat -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Riwayat Konsultasi</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="d-block text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRiwayat" aria-expanded="false" aria-controls="collapseRiwayat">
                            <i class="min fas fa-angle-double-down pull-right"></i>
                        </a>
                    </div>
                </div>
                <p class="card-title-desc">
                    Berikut adalah detail <b>riwayat konsultasi anda</b>.
                </p>
            </div>
            <div class="collapse show" id="collapseRiwayat">
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap w-100" id="RiwayatTabels">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Bimbingan</th>
                                <th>Jenis Konsultasi</th>
                                <th>Waktu Konsultasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@section('RiwayatJs')
    <script>
        /* Get data table */
        var tableRiwayat = $('#RiwayatTabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/riwayat/" + jenis,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'bimbingan_kode',
                    name: 'bimbingan_kode'
                },
                {
                    data: 'bimbingan_jenis',
                    name: 'bimbingan_jenis'
                },
                {
                    data: 'waktu_bimbingan',
                    name: 'waktu_bimbingan'
                },
            ],
            columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: '_all'
                },
                {
                    width: '1%',
                    targets: [0]
                },
            ],
            order: false,
            bPaginate: true,
            bLengthChange: true,
            bFilter: false,
            bInfo: true,
        });
    </script>
@endsection
