{{-- Modal Show --}}
<div class="modal fade" id="MateriDosenModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Materi Tahunan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-1">
                    <label for="tahun_ajaran_id_show" class="col-form-label">Tahun Ajaran:</label>
                    <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show"
                        name="tahun_ajaran_id_show" readonly>
                </div>
                <div>
                    <label for="file_materi_show" class="col-form-label">File Materi:</label>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="tabelShow">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama File</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mb-1">
                    <label for="jenis_materi_show" class="col-form-label">Jenis Materi Konsultasi:</label>
                    <input type="text" class="form-control no-outline" id="jenis_materi_show"
                        name="jenis_materi_show" readonly>
                </div>
                <div class="mb-1">
                    <label for="keterangan_materi_show" class="col-form-label">Keterangan:</label><br>
                    <textarea class="form-control" name="keterangan_materi_show no-outline" id="keterangan_materi_show" style="width: 100%"
                        rows="3" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- END Modal Show --}}

<!-- Card Materi -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h4 class="card-title">Materi Konsultasi</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="d-block text-primary btn-lg" style="border-radius: 50%; background-color: #ebede3;"
                            type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample"
                            aria-expanded="false" aria-controls="collapseExample">
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
                                <th>Keterangan</th>
                                <th>Jumlah File Materi</th>
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
    <style>
        .tooltip {
            z-index: 100000000;
        }
    </style>

    <script>
        /* Get data table */
        var tableMateri = $('#MateriTabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/materi/" + jenis,
            autoWidth: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'keterangan',
                    name: 'keterangan'
                },
                {
                    data: 'jml_file',
                    name: 'jml_file'
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
                    targets: [0, 2, 3]
                },
            ],
            order: false,
            bPaginate: false,
            bLengthChange: false,
            bFilter: false,
            bInfo: false,
            oLanguage: {
                sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
            }
        });

        var tShow = $('#tabelShow').DataTable({
            processing: true,
            serverSide: true,
            ajax: "materi-show/0",
            autoWidth: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nama_file',
                    name: 'nama_file'
                },
                {
                    data: 'action',
                    name: 'action'
                }
            ],
            columnDefs: [{
                    searchable: false,
                    orderable: false,
                    targets: [0, 2]
                },
                {
                    width: '1%',
                    targets: [0, 2]
                }
            ],
            order: [
                [1, 'desc']
            ],
            bPaginate: false,
            bLengthChange: false,
            bFilter: false,
            bInfo: false,
            oLanguage: {
                sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
            }
        });

        /* Button Show */
        $('body').on('click', '#btnDetailMateri', function() {
            var this_id = $(this).data('id');
            $.get('materi/show/' + this_id, function(data) {
                $('#MateriDosenModalShow').modal('show');
                $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                $('#jenis_materi_show').val(data.jenis_materi);
                $('#keterangan_materi_show').val(data.keterangan);
            });
            tShow.ajax.url("/materi-show/" + this_id).load();
        });
    </script>
@endsection
