@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Data Dosen Pembimbing</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Data Dosen Pembimbing</li>
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
                        <h4 class="card-title">Data Dosen Pembimbing</h4>
                        <p class="card-title-desc">
                            Berikut adalah detail dari <b>Dosen Pembimbing</b> Anda selama mengerjakan <b>Tugas Akhir</b>,
                            diharapkan Mahasiswa memanfaatkan waktu untuk <b>konsultasi</b> sebaik mungkin.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode Pembimbing</th>
                                        <th>Nama Pembimbing</th>
                                        <th>NIDN</th>
                                        <th>Email</th>
                                        <th>No Telepon</th>
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
                ajax: "{{ route('data-pembimbing.indexMhs') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'kode_pembimbing',
                        name: 'kode_pembimbing'
                    },
                    {
                        data: 'dosen.nama_dosen',
                        name: 'dosen.nama_dosen'
                    },
                    {
                        data: 'dosen.nidn',
                        name: 'dosen.nidn'
                    },
                    {
                        data: 'dosen.email',
                        name: 'dosen.email'
                    },
                    {
                        data: 'dosen.no_telepon',
                        name: 'dosen.no_telepon'
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
                    {
                        targets: [5],
                        render: function(data, type, full, meta) {
                            return '+62' + data;
                        }
                    }
                ],
                order: false,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
                oLanguage: {
                    sEmptyTable: "Anda belum mendapatkan Pembimbing. Segera ajukan <b> Judul Tugas Akhir</b> pada menu <u><a href='pengajuan-judul/'>Pengajuan Judul</a></u>."
                }
            });
        });
    </script>
@endsection
