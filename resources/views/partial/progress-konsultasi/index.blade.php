@extends('layouts.minia.header')

@section('content')
    {{-- Modal Show --}}
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Progres</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nim" class="col-form-label">NIM:</label>
                            <input type="text" class="form-control no-outline" id="nim" name="nim" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nama" class="col-form-label">Nama Mahasiswa:</label>
                            <input type="text" class="form-control no-outline" id="nama" name="nama" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="judul" class="col-form-label">Judul:</label><br>
                            <textarea class="form-control" name="judul" id="judul" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="studi" class="col-form-label">Studi Kasus:</label><br>
                            <textarea class="form-control" name="studi" id="studi" style="width: 100%" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="pengerjaan" class="col-form-label">Pengerjaan:</label>
                            <input type="text" class="form-control no-outline" id="pengerjaan" name="pengerjaan" readonly>
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
                    <h4 class="mb-sm-0 font-size-18">Progres Konsultasi </h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Progres Konsultasi </li>
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
                        <h4 class="card-title">Progres Konsultasi Mahasiswa</h4>
                        <p class="card-title-desc">
                            Anda dapat melihat semua progres <b>konsultasi Mahasiswa</b> dan menambahkan filter sesuai
                            dengan <b>parameter</b> yang Anda butuhkan.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="row border mb-2 pb-3">
                            <div class="col-md-5">
                                <label for="dospem" class="col-form-label">Kategori Dosen Pembimbing:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="dospem"
                                    name="dospem">
                                    <option value=""></option>
                                    <option value="Semua">Tampilkan Semua</option>
                                    @foreach ($dosen_id as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_dosen }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text dospem_error"></span>
                            </div>
                            <div class="col-md-5">
                                <label for="urutan" class="col-form-label">Kategori Urutan:</label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="urutan"
                                    name="urutan">
                                    <option value=""></option>
                                    <option value="desc">Tertinggi</option>
                                    <option value="asc">Terendah</option>
                                </select>
                                <span class="text-danger error-text urutan_error"></span>
                            </div>
                            <div class="col-md-2">
                                <br>
                                <button type="button" class="btn btn-md btn-primary mt-3" id="btnFilter"
                                    style="width: 100%">Filter Sekarang</button>
                            </div>
                        </div>
                        <div class="row border mb-2"></div>
                        <div class="row border p-2 pt-3">
                            <div class="col">
                                <div class="table-responsive">
                                    <table id="tabel" class="table table-md" cellspacing="0"
                                        style="width:100%; cursor:pointer; min-height:350px">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Progres</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- cards css -->
    <style>
        .cards tbody tr {
            float: left;
            width: 23.5rem;
            margin: 0.5rem;
            border: 0.0625rem solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
            box-shadow: 0.25rem 0.25rem 0.5rem rgba(0, 0, 0, 0.25);
        }

        .cards tbody td {
            display: block;
        }

        .table tbody label {
            display: none;
        }

        .cards tbody label {
            display: inline;
            position: relative;
            font-size: 85%;
            top: -0.5rem;
            float: left;
            color: #808080;
            min-width: 4rem;
            margin-left: 0;
            margin-right: 1rem;
            text-align: left;
        }

        .table .fa {
            font-size: 2.5rem;
        }

        .cards .fa {
            font-size: 7.5rem;
        }

    </style>
    <!-- select2 css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>
    <!-- datatables select css -->
    <link rel="stylesheet"
        href="{{ asset('vendor/minia') }}/assets/libs/datatables.net-select/css/select.dataTables.min.css">
    <!-- datatables select js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/datatables.net-select/js/dataTables.select.min.js"></script>

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Cards view */
            $(function() {
                $("#tabel").toggleClass("cards");
                $("#tabel thead").toggle();
            });

            /* Get data table progres */
            var table = $('#tabel').DataTable({
                ajax: "{{ route('progres-konsultasi.index') }}",
                columns: [{
                        data: function(data, type, dataToSet) {
                            return "<div class='row'><div class='col-md-10'>" +
                                "<div style='word-wrap: break-word;'>" +
                                data.bimbingan.pembimbing.mahasiswa.nama_mahasiswa +
                                "</div></div><div class='col-md-2 d-flex justify-content-end'>" +
                                "<div class='text-wrap width-50'>" +
                                data.total + "%</div></div></div>"
                        }
                    },
                    {
                        data: function(data, type, dataToSet) {
                            return '<div class="progress" style="height: 20px;"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="" aria-valuemin="0" aria-valuemax="100" style="width:' +
                                data.total + '%"></div></div>'
                        }
                    },
                    {
                        data: 'total',
                        visible: false
                    }
                ],
                select: 'single',
                language: {
                    emptyTable: "Tidak ada data yang tersedia pada tabel ini",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
                    infoFiltered: "(disaring dari _MAX_ entri keseluruhan)",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    loadingRecords: "Sedang memuat...",
                    processing: "Sedang memproses...",
                    search: "Cari:",
                    zeroRecords: "Tidak ditemukan data yang sesuai",
                    thousands: "'",
                    paginate: {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    },
                    select: {
                        rows: "%d kolom terpilih",
                    }
                },
                lengthMenu: [9, 30, 60, 90, 120],
            });

            /* select cards view */
            table.on('select', function(e, dt, type, indexes) {
                var rowData = table.rows(indexes).data().toArray();
                $('#Modal').modal('show');
                $('#nim').val(rowData[0].bimbingan.pembimbing.mahasiswa.nim);
                $('#nama').val(rowData[0].bimbingan.pembimbing.mahasiswa.nama_mahasiswa);
                $('#judul').val(rowData[0].bimbingan.pembimbing.mahasiswa.judul.judul);
                $('#studi').val(rowData[0].bimbingan.pembimbing.mahasiswa.judul.studi_kasus);
                if (rowData[0].bimbingan.pembimbing.mahasiswa.judul.pengerjaan == "Sendiri") {
                    $('#pengerjaan').val(rowData[0].bimbingan.pembimbing.mahasiswa.judul.pengerjaan);
                } else {
                    $('#pengerjaan').val(rowData[0].bimbingan.pembimbing.mahasiswa.judul.pengerjaan +
                        " bersama " + rowData[0].bimbingan.pembimbing.mahasiswa.judul.anggota
                        .nama_mahasiswa);
                }
            });

            /* Function Filter */
            function filter(id, urutan) {
                table.ajax.url("/progres-konsultasi-mahasiswa/" + id + "/" + urutan).load(function() {
                    table.order([2, urutan]).draw();
                });
                $('.dospem_error').text("");
                $('.urutan_error').text("");
                $('#btnFilter').prop('disabled', false);
                $("#btnFilter").html("Filter Sekarang");
            };

            /* Button Filter */
            $('#btnFilter').click(function() {
                var id = document.getElementById("dospem").value;
                var urutan = document.getElementById("urutan").value;

                $('#btnFilter').prop('disabled', true);
                $("#btnFilter").html("Sedang memproses...");

                $('.dospem_error').text("");
                $('.urutan_error').text("");

                if (!id && !urutan) {
                    $('.dospem_error').text("Kategori Dosen Pembimbing wajib diisi.");
                    $('.urutan_error').text("Kategori Urutan wajib diisi.");
                    $('#btnFilter').prop('disabled', false);
                    $("#btnFilter").html("Filter Sekarang");
                } else if (!id) {
                    $('.dospem_error').text("Kategori Dosen Pembimbing wajib diisi.");
                    $('#btnFilter').prop('disabled', false);
                    $("#btnFilter").html("Filter Sekarang");
                } else if (!urutan) {
                    $('.urutan_error').text("Kategori Urutan wajib diisi.");
                    $('#btnFilter').prop('disabled', false);
                    $("#btnFilter").html("Filter Sekarang");
                } else {
                    filter(id, urutan);
                }
            });

            /* Select2 k. dospem */
            $("#dospem").select2({
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 k. urutan */
            $("#urutan").select2({
                placeholder: "Cari berdasarkan status ...",
                allowClear: true,
                minimumResultsForSearch: -1
            });
        });
    </script>
@endsection
