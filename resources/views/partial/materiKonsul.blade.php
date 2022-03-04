<!-- Card Materi -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Materi Konsultasi Proposal - Judul</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="d-block text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="max fas fa-angle-double-up pull-right"></i>
                        </a>
                    </div>
                </div>
                <p class="card-title-desc">
                    Berikut adalah lampiran <b>materi konsultasi</b> dari <b>Dosen Pembimbing</b>.
                </p>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card-body">
                    <table class="table table-bordered dt-responsive nowrap w-100" id="MateriTabels">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>File Materi</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
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

@section('MateriJs')
    <script>
        /* Get data table */
        var tableMateri = $('#MateriTabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/materi/" + jenis + "/" + bab,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'file_materi',
                    name: 'file_materi'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'action',
                    name: 'action'
                },
            ],
            columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: '_all'
                },
                {
                    width: '1%',
                    targets: [0, 3]
                },
            ],
            order: false,
            bPaginate: false,
            bLengthChange: false,
            bFilter: false,
            bInfo: false,
        });
    </script>
@endsection
