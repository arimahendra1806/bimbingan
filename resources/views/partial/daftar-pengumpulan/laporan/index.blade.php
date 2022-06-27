@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Daftar Pengumpulan Laporan TA dari Mahasiswa</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Pengumpulan Laporan TA dari Mahasiswa</li>
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
                        <h4 class="card-title">Daftar Pengumpulan Laporan TA dari Mahasiswa</h4>
                        <p class="card-title-desc">
                            Berikut adalah daftar mahasiswa yang sudah mengumpulkan laporan TA.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Waktu Upload</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Status Verifikasi</th>
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
    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/libs/glightbox/css/glightbox.min.css">
    <!-- glightbox js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/glightbox/js/glightbox.min.js"></script>
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
                ajax: "{{ route('daftar-laporan.daftarLap') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'mhs.nama_mahasiswa',
                        name: 'mhs.nama_mahasiswa'
                    },
                    {
                        data: 'status',
                        name: 'status'
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
                    }
                ],
                order: [
                    [1, 'desc'],
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

            $('body').on('click', '#btnShow', function() {
                var this_id = 'dokumen/pengumpulan/laporan/' + $(this).data('id');
                const myGallery = GLightbox({
                    elements: [{
                        'href': this_id,
                        'type': 'image',
                    }]
                });
                myGallery.open();
            });

            /* Import Info Gambar */
            const lightbox = GLightbox({});
        });
    </script>
@endsection
