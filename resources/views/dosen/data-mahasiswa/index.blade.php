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
                    <h6>Identitas</h6>
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
                            <label for="alamat_show" class="col-form-label">Alamat:</label><br>
                            <textarea class="form-control" name="alamat_show" id="alamat_show" style="width: 100%" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <hr>
                    <h6>Tugas Akhir</h6>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="judul_show" class="col-form-label">Judul:</label><br>
                            <textarea class="form-control" name="judul_show" id="judul_show" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="studi_kasus_show" class="col-form-label">Studi Kasus:</label><br>
                            <textarea class="form-control" name="studi_kasus_show" id="studi_kasus_show" style="width: 100%" rows="2"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="pengerjaan_show" class="col-form-label">Pengerjaan:</label>
                            <input type="text" class="form-control no-outline" id="pengerjaan_show"
                                name="pengerjaan_show" readonly>
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
                    <h4 class="mb-sm-0 font-size-18">Data Mahasiswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Data Mahasiswa</li>
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
                        <h4 class="card-title">Data Mahasiswa</h4>
                        <p class="card-title-desc">
                            Berikut adalah detail dari <b>Mahasiswa yang Anda bimbing</b> untuk mengerjakan
                            <b>Tugas Akhir</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Pengerjaan</th>
                                        <th>Judul</th>
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
                ajax: "{{ route('data-mahasiswa.indexDsn') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'mahasiswa.nama_mahasiswa',
                        name: 'mahasiswa.nama_mahasiswa'
                    },
                    {
                        name: 'judul.pengerjaan',
                        data: function(data, type, dataToSet) {
                            if (data.judul.pengerjaan == "Sendiri") {
                                return data.judul.pengerjaan;
                            } else {
                                return data.judul.pengerjaan + " bersama " + data.judul.anggota
                                    .nama_mahasiswa;
                            }
                        }
                    },
                    {
                        data: 'judul.judul',
                        name: 'judul.judul'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    },
                    {
                        data: null,
                        name: 'judul.anggota.nama_mahasiswa',
                        visible: false
                    }
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
                    {
                        targets: [0, 1, 2, 5],
                        class: "wrapok"
                    }
                ],
                order: [
                    [2, 'asc']
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
                $.get('data-mahasiswa/' + this_id, function(data) {
                    $('#MhsModalShow').modal('show');
                    $('#nim_show').val(data.mahasiswa.nim);
                    $('#nama_mhs_show').val(data.mahasiswa.nama_mahasiswa);
                    $('#email_show').val(data.mahasiswa.email);
                    $('#no_telepon_show').val("+62" + data.mahasiswa.no_telepon);
                    $('#alamat_show').val(data.mahasiswa.alamat);
                    $('#judul_show').val(data.judul.judul);
                    $('#studi_kasus_show').val(data.judul.studi_kasus);
                    if (data.judul.pengerjaan == "Sendiri") {
                        $('#pengerjaan_show').val(data.judul.pengerjaan);
                    } else {
                        $('#pengerjaan_show').val(data.judul.pengerjaan + " bersama " + data.judul
                            .anggota.nama_mahasiswa);
                    }
                });
            });
        });
    </script>
@endsection
