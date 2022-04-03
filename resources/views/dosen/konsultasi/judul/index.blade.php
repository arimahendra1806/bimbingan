@extends('layouts.minia.header')

@section('content')
    {{-- Modal Show --}}
    <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">File Konsultasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a class="btn btn-info waves-effect waves-light w-100" type="button" id="fileDownload" download="">Unduh
                        File</a>
                    <div class="mb-1">
                        <iframe style="width:100%; height:530px;" frameborder="0" id="fileView"></iframe>
                    </div>
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
                    <h4 class="mb-sm-0 font-size-18">Peninjauan Konsultasi Judul</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Peninjauan Konsultasi Judul</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-8">
                <div class="card" style="min-height: 200px">
                    <div class="card-header">
                        <h4 class="card-title">Peninjauan Konsultasi Judul</h4>
                        <p class="card-title-desc">
                            Diharapkan Dosen segara melakukan peninjauan terhadap konsultasi Mahasiswa dan <b>perbarui
                                status konfirmasi</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="text-center" id="pertama">
                            <h5>Silahkan pilih nama <b>Mahasiswa</b> pada <b>daftar konsultasi Mahasiswa</b> untuk
                                <b>melakukan peninjauan</b>!
                            </h5>
                        </div>
                        <div class="hide" id="kedua">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <label for="nama_show" class="col-form-label">Nama Mahasiswa: </label>
                                    <input type="text" class="form-control no-outline" id="nama_show" name="nama_show"
                                        readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="tanggal_show" class="col-form-label">Tanggal Konsultasi: </label>
                                    <input type="text" class="form-control no-outline" id="tanggal_show" name="tanggal_show"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label for="judul_show" class="col-form-label">Judul Tugas Akhir:</label><br>
                                    <textarea class="form-control" name="judul_show" id="judul_show" style="width: 100%" rows="2" readonly></textarea>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label for="fileShow" class="col-form-label">File Konsultasi:</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control no-outline" id="fileShow" name="fileShow"
                                            readonly>
                                        <a href="javascript:void(0)" class="btn btn-info waves-effect waves-light"
                                            type="button" data-toggle="tooltip" title="Pertinjau File" id="btnShow">
                                            <i class="far fa-file-pdf"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <form id="Store">
                                    @csrf
                                    <input type="hidden" name="kd" id="kd">
                                    <div class="col-md-12 mb-1">
                                        <label for="progres" class="col-form-label">Status Konsultasi: </label>
                                        <select class="js-example-responsive form-control" style="width: 100%" id="progres"
                                            name="progres">
                                            <option value=""></option>
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Revisi">Revisi</option>
                                        </select>
                                        <span class="text-danger error-text progres_error"></span>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="keterangan" class="col-form-label">Keterangan:</label><br>
                                        <textarea class="form-control" name="keterangan" id="keterangan" style="width: 100%" rows="3"></textarea>
                                        <span class="text-danger error-text keterangan_error"></span>
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <input type="submit" class="btn btn-primary" name="addSave"
                                            value="Perbarui Peninjauan">
                                    </div>
                                </form>
                            </div>
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
                                            <input type="submit" class="btn btn-outline-primary" name="komenSave"
                                                value="Kirim">
                                            <div class="vr"></div>
                                            <button type="reset" class="btn btn-outline-danger">Reset</button>
                                            <a type="button" class="btn btn-outline-success" data-toggle="tooltip"
                                                title="Refresh Komentar" id="btnRefresh"><i class="fas fa-sync-alt"></i></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table nowrap w-100 borderless" id="KomenTabels">
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
            <div class="col-4">
                <div class="card" style="min-height: 200px">
                    <div class="container mt-4">
                        <h4 class="card-title">Daftar Konsultasi Judul</h4>
                        <p class="card-title-desc">
                            <i class="fas fa-comment-dots text-danger"></i> : Belum Dilihat |
                            <i class="fas fa-comment-dots text-warning"></i> : Sudah Dilihat |
                            <i class="fas fa-comment-dots text-success"></i> : Sudah Dibalas |
                            <i class="fas fa-comment-dots text-primary"></i> : Telah Disetujui
                        </p>
                        <div class="table-responsive mt-2">
                            <table class="table nowrap w-100 borderless" style="cursor:pointer" id="Tabels">
                                <thead style="display: none;">
                                    <tr>
                                        <th>Mahasiswa Konsultasi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr></tr>
                                </tbody>
                            </table><br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- select2 css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>
    <!-- datatables select css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css">
    <!-- datatables select js -->
    <script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
    <!-- alertifyjs Css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet"
        type="text/css" />
    <!-- alertifyjs js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/alertify.min.js"></script>

    <script>
        $(document).ready(function() {
            var selectRowId = "";

            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* function show div pertama */
            function pertama() {
                $('#pertama').show();
                $('#kedua').hide();
            }

            /* function show div kedua */
            function kedua() {
                document.getElementById('kedua').classList.remove("hide");
                $('#pertama').hide();
                $('#kedua').show();
            }

            /* run function pertama */
            $(function() {
                pertama();
            });

            /* Function detail daftar mhs */
            function detail(kode) {
                $.get('peninjauan-konsultasi-judul/' + kode, function(data) {
                    $('#kd').val(data.detail.kd);
                    $('#nama_show').val(data.detail.nama);
                    $('#tanggal_show').val(data.detail.tanggal);
                    $('#judul_show').val(data.detail.judul);
                    $('#fileShow').val(data.detail.file);
                    $('#progres').val(data.detail.status).trigger('change');
                    $('#keterangan').val(data.detail.keterangan);
                });
            }

            /* Get data table daftar mhs */
            var table = $('#Tabels').DataTable({
                processing: false,
                serverSide: true,
                ajax: "{{ route('peninjauan-judul.index') }}",
                columns: [{
                    name: 'pembimbing.mahasiswa.nama_mahasiswa',
                    data: function(data, type, dataToSet) {
                        if (data.status_pesan == 0) {
                            return '<i class="fas fa-comment-dots text-danger">&nbsp;&nbsp;</i>' +
                                data.pembimbing.mahasiswa.nama_mahasiswa;
                        } else if (data.status_pesan == 1) {
                            return '<i class="fas fa-comment-dots text-warning"> &nbsp;&nbsp;</i>' +
                                data.pembimbing.mahasiswa.nama_mahasiswa;
                        } else if (data.status_konsultasi == "Disetujui") {
                            return '<i class="fas fa-comment-dots text-primary"> &nbsp;&nbsp;</i>' +
                                data.pembimbing.mahasiswa.nama_mahasiswa;
                        } else {
                            return '<i class="fas fa-comment-dots text-success"> &nbsp;&nbsp;</i>' +
                                data.pembimbing.mahasiswa.nama_mahasiswa;
                        }
                    }
                }],
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
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
                oLanguage: {
                    sEmptyTable: "Belum terdapat konsultasi dari Mahasiswa"
                },
                scrollY: "200px",
                scrollCollapse: true,
                fnCreatedRow: function(nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData.id);
                }
            });

            /* Get data table komen */
            var tableKomen = $('#KomenTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: 'peninjauan-konsultasi-judul/komen/0',
                columns: [{
                    name: 'komentar'
                }, ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: '_all'
                    },
                    {
                        targets: [0],
                        data: function(data, type, dataToSet) {
                            return "<div class='text-wrap width-200'><b>" + data.nama +
                                "</b>&nbsp;&nbsp;" + data.waktu_komentar
                                .toLocaleString() +
                                "<br>" + data.komentar + "</div>"
                        }
                    }
                ],
                order: false,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
                oLanguage: {
                    sEmptyTable: "Belum terdapat komentar",
                    sProcessing: "Sedang memproses..."
                },
                scrollY: "200px",
                scrollCollapse: true,
                paging: false,
            });

            /* Button Selected daftar mhs */
            $('#Tabels tbody').on('click', 'tr', function() {
                var has = $(this).hasClass('selected');
                var data = $('#Tabels').DataTable().row(this).data();
                var this_id = data.kode_bimbingan;
                selectRowId = $(this).attr('id');
                if (!has) {
                    table.$('tr.selected').removeClass('selected');
                    $(this).addClass('selected');
                    table.ajax.reload(function() {
                        $("#" + selectRowId).addClass('selected');
                    });
                    detail(this_id);
                    tableKomen.ajax.url("peninjauan-konsultasi-judul/komen/" + this_id).load();
                    kedua();
                } else {
                    $("#" + selectRowId).removeClass('selected');
                    pertama();
                }
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Show File*/
            $("#btnShow").click(function() {
                $('#Modal').modal('show');
                $('iframe').attr("src", "{{ asset('dokumen/konsultasi/judul') }}" + "/" + document
                    .getElementById('fileShow').value);
                $('#fileDownload').attr("href", "{{ asset('dokumen/konsultasi/judul') }}" + "/" +
                    document.getElementById('fileShow').value);
            });

            /* Button Refresh Komen*/
            $("#btnRefresh").click(function() {
                tableKomen.ajax.reload();
            });

            /* Ajax Store Konsul */
            $("#Store").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('peninjauan-judul.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            form.addSave.disabled = false;
                            form.addSave.value = "Perbarui Peninjauan";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Perbarui Peninjauan";
                            $('#kd').val(data.data.kode_bimbingan);
                            $('#progres').val(data.data.status_konsultasi).trigger('change');
                            $('#keterangan').val(data.data.keterangan_konsultasi);
                            table.ajax.reload(function() {
                                $("#" + selectRowId).addClass('selected');
                            })
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(response) {
                        form.addSave.disabled = false;
                        form.addSave.value = "Perbarui Peninjauan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Ajax Store Komen */
            $("#KomenStore").submit(function(e) {
                var form = this;
                form.komenSave.disabled = true;
                form.komenSave.value = "Mengirim...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('peninjauan-judul.storeKomen') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            form.komenSave.disabled = false;
                            form.komenSave.value = "Kirim";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            form.komenSave.disabled = false;
                            form.komenSave.value = "Kirim";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!',
                                text: data.data
                            });
                        } else {
                            form.komenSave.disabled = false;
                            form.komenSave.value = "Kirim";
                            $('#komentar').val('');
                            tableKomen.ajax.reload();
                            alertify.set('notifier', 'position', 'top-right');
                            alertify.success(data.msg);
                        }
                    },
                    error: function(response) {
                        form.komenSave.disabled = false;
                        form.komenSave.value = "Kirim";
                        alertify.set('notifier', 'position', 'top-right');
                        alertify.error('Oops, Muncul Kesalahan !!');
                    }
                });
            });

            /* Select2 */
            $("#progres").select2({
                placeholder: "Cari berdasarkan status ...",
                allowClear: true,
                minimumResultsForSearch: -1
            });
        });
    </script>
@endsection
