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
                    <hr>
                    <h4 class="card-title text-secondary"><i class="far fa-comments"> Kolom Diskusi</i></h4>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="komen" class="col-form-label text-secondary">Ketikan Komentar :</label>
                            <form class="row gx-3 gy-2 align-items-center" id="KomenStore">
                                @csrf
                                <div class="hstack gap-3">
                                    <input class="form-control me-auto" type="text"
                                        placeholder="Ketik pesan anda disini.." id="komentar" name="komentar">
                                    <span class="text-danger error-text komentar_error"></span>
                                    <input type="submit" class="btn btn-outline-primary" name="komenSave" value="Kirim">
                                    <div class="vr"></div>
                                    <button type="reset" class="btn btn-outline-danger">Reset</button>
                                    <a type="button" class="btn btn-outline-success" data-toggle="tooltip"
                                        title="Refresh Komentar" id="btnRefresh"><i class="fas fa-sync-alt"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <table class="table dt-responsive nowrap w-100 borderless" id="KomenTabels">
                                <thead style="display: none;">
                                    <tr>
                                        <th></th>
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
                    data: 'waktu',
                    name: 'waktu'
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
            oLanguage: {
                sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
            }
        });
    </script>
@endsection
