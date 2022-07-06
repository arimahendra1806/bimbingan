@extends('layouts.minia.header')

@section('content')
    {{-- Modal Show --}}
    <div class="modal fade" id="MateriTahunanModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <label for="keterangan_show" class="col-form-label">Keterangan:</label><br>
                        <textarea class="form-control" name="keterangan_show" id="keterangan_show" style="width: 100%" rows="3" readonly></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END Modal Show --}}

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Ketentuan Tugas Akhir</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Ketentuan Tugas Akhir</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ketentuan Tugas Akhir</h4>
                        @if (Auth::check() && Auth::user()->role == 'dosen')
                            <p class="card-title-desc">Dosen perlu <b>membaca dan memahami</b> setiap ketentuan yang
                                ada,
                                hal ini dikarenakan <b>setiap tahun</b> terkadang memiliki ketentuan <b>berbeda</b>.
                            </p>
                        @elseif(Auth::check() && Auth::user()->role == 'mahasiswa')
                            <p class="card-title-desc">Mahasiswa perlu <b>membaca dan memahami</b> setiap ketentuan yang
                                ada,
                                hal ini bertujuan agar Mahasiswa <b>mampu memahami</b> mengenai pengerjaan <b>Tugas
                                    Akhir</b>.
                            </p>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Keterangan</th>
                                        <th>Jumlah File Ketentuan</th>
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
    </div>
@endsection

@section('js')
    <style>
        .tooltip {
            z-index: 100000000;
        }

        td.wrapok {
            white-space: nowrap;
        }
    </style>

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Get data table */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('ketentuan-ta.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
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
                    }
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 4]
                    },
                    {
                        width: '1%',
                        targets: [0, 4]
                    },
                    {
                        targets: [0, 1, 3, 4],
                        class: "wrapok"
                    }
                ],
                order: [
                    [1, 'desc']
                ],
                oLanguage: {
                    sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
                }
            });

            var tShow = $('#tabelShow').DataTable({
                processing: true,
                serverSide: true,
                ajax: "ketentuan-ta-show/0",
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

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('ketentuan-ta/' + this_id, function(data) {
                    $('#MateriTahunanModalShow').modal('show');
                    $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                    $('#keterangan_show').val(data.keterangan);
                });
                tShow.ajax.url("/ketentuan-ta-show/" + this_id).load();
            });
        });
    </script>
@endsection
