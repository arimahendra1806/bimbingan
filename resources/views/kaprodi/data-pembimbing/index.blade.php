@extends('layouts.minia.header')

@section('content')
    {{-- Modal Show --}}
    <div class="modal fade" id="ModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Pembimbing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nama_dosen_show" class="col-form-label">Nama Dosen Pembimbing:</label>
                            <input type="text" class="form-control no-outline" id="nama_dosen_show" name="nama_dosen_show"
                                readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_mhs_show" class="col-form-label">Nama Mahasiswa:</label>
                            <input type="text" class="form-control no-outline" id="nama_mhs_show" name="nama_mhs_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="judul_show" class="col-form-label">Judul:</label><br>
                            <textarea class="form-control" name="judul_show" id="judul_show" style="width: 100%" rows="3" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="studi_show" class="col-form-label">Studi Kasus:</label><br>
                            <textarea class="form-control" name="studi_show" id="studi_show" style="width: 100%" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="status_pengerjaan_show" class="col-form-label">Status Pengerjaan:</label>
                            <input type="text" class="form-control no-outline" id="status_pengerjaan_show"
                                name="status_pengerjaan_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="status_judul_show" class="col-form-label">Status Judul:</label>
                            <input type="text" class="form-control no-outline" id="status_judul_show"
                                name="status_judul_show" readonly>
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
                    <h4 class="mb-sm-0 font-size-18">Daftar Data Pembimbing</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Data Pembimbing</li>
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
                        <h4 class="card-title">Daftar Data Pembimbing</h4>
                        <p class="card-title-desc">
                            Berikut adalah data Pembimbing yang telah dikelola oleh <b>Koordinator</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nama Pembimbing</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Judul Mahasiswa</th>
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
                ajax: "{{ route('data-dospem.indexKaprodi') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'dosen.nama_dosen',
                        name: 'dosen.nama_dosen'
                    },
                    {
                        data: 'mahasiswa.nama_mahasiswa',
                        name: 'mahasiswa.nama_mahasiswa'
                    },
                    {
                        data: 'judul.judul',
                        name: 'judul.judul'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 5]
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
                    },
                ],
                order: [
                    [1, 'asc']
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
                $.get('daftar-data-pembimbing/' + this_id, function(data) {
                    $('#ModalShow').modal('show');
                    $('#nama_dosen_show').val(data.dosen.nama_dosen);
                    $('#nama_mhs_show').val(data.mahasiswa.nama_mahasiswa);
                    $('#judul_show').val(data.judul.judul);
                    $('#studi_show').val(data.judul.studi_kasus);
                    if (data.judul.pengerjaan == "Kelompok") {
                        $('#status_pengerjaan_show').val(data.judul.pengerjaan + ' dengan ' + data
                            .judul.anggota.nama_mahasiswa);
                    } else {
                        $('#status_pengerjaan_show').val(data.judul.pengerjaan);
                    }
                    $('#status_judul_show').val(data.judul.status);
                });
            });
        });
    </script>
@endsection
