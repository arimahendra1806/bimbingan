@extends('layouts.minia.header')

@section('content')
    {{-- Modal Show --}}
    <div class="modal fade" id="MhsModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Mahasiswa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nim_show" class="col-form-label">NIM:</label>
                            <input type="text" class="form-control no-outline" id="nim_show" name="nim_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_mhs_show" class="col-form-label">Nama Mahasiswa:</label>
                            <input type="text" class="form-control no-outline" id="nama_mhs_show" name="nama_mhs_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="email_show" class="col-form-label">Email:</label>
                            <input type="text" class="form-control no-outline" id="email_show" name="email_show"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="no_telepon_show" class="col-form-label">Nomor Telepon:</label>
                            <input type="text" class="form-control no-outline" id="no_telepon_show"
                                name="no_telepon_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="tahun_ajaran_id_show" class="col-form-label">Tahun Ajaran:</label>
                            <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show"
                                name="tahun_ajaran_id_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="alamat_show" class="col-form-label">Alamat:</label><br>
                            <textarea class="form-control" name="alamat_show" id="alamat_show" style="width: 100%" rows="3" readonly></textarea>
                        </div>
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
                    <h4 class="mb-sm-0 font-size-18">Daftar Data Mahasiswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Data Mahasiswa</li>
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
                        <h4 class="card-title">Daftar Data Mahasiswa</h4>
                        <p class="card-title-desc">
                            Berikut adalah data Mahasiswa yang telah dikelola oleh <b>Koordinator</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="MhsTabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIM</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
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
    {{-- DataTables --}}
    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Get data table */
            var table = $('#MhsTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('data-mhs.indexKaprodi') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nim',
                        name: 'nim'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'nama_mahasiswa',
                        name: 'nama_mahasiswa'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_telepon',
                        name: 'no_telepon'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 6]
                    },
                    {
                        width: '1%',
                        targets: [0, 6]
                    },
                    {
                        targets: [5],
                        render: function(data, type, full, meta) {
                            return '+62' + data;
                        }
                    }
                ],
                order: [
                    [2, 'desc'],
                    [3, 'asc']
                ],
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
                $.get('daftar-data-mahasiswa/' + this_id, function(data) {
                    $('#MhsModalShow').modal('show');
                    $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                    $('#nim_show').val(data.nim);
                    $('#nama_mhs_show').val(data.nama_mahasiswa);
                    $('#alamat_show').val(data.alamat);
                    $('#email_show').val(data.email);
                    $('#no_telepon_show').val('+62' + data.no_telepon);
                });
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
