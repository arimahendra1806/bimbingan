@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Konsultasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormAdd" enctype="multipart/form-data" files="true">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="file_upload_add" class="col-form-label">File Upload: <b class="error">*Pastikan
                                        format PDF | Max 50MB</b></label>
                                <input type="file" class="form-control" id="file_upload_add" name="file_upload_add">
                                <span class="text-danger error-text file_upload_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="keterangan_add" class="col-form-label">Deskripsi Konsultasi Anda: <b
                                        class="info">*Tuliskan deskripsi mengenai isi konsultasi
                                        Anda</b></label>
                                <textarea class="form-control" name="keterangan_add" id="keterangan_add" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text keterangan_add_error"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" name="addSave" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END Modal Add --}}

    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Konsultasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit" enctype="multipart/form-data" files="true">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="file_upload_edit" class="col-form-label">File Upload: <b
                                        class="error">*Pastikan format PDF | Max 50MB</b></label>
                                <input type="text" class="form-control no-outline" id="fileShow" name="fileShow"
                                    readonly>
                                <input type="file" class="form-control" id="file_upload_edit" name="file_upload_edit">
                                <span class="text-danger error-text file_upload_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="keterangan_edit" class="col-form-label">Deskripsi Konsultasi Anda: <b
                                        class="info">*Tuliskan deskripsi mengenai isi konsultasi
                                        Anda</b></label>
                                <textarea class="form-control" name="keterangan_edit" id="keterangan_edit" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text keterangan_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <iframe style="width:100%; height:530px;" frameborder="0" id="fileView"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" name="editSave" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END Modal Edit --}}

    {{-- Modal Show --}}
    <div class="modal fade" id="ModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Konsultasi Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="status_show" class="col-form-label">Status Peninjauan dari Dosen
                                Pembimbing:</label>
                            <input type="text" class="form-control no-outline" id="status_show" name="status_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="keterangan_show" class="col-form-label">Deskripsi Konsultasi Anda:</label>
                            <textarea class="form-control" name="keterangan_show" id="keterangan_show" style="width: 100%" rows="3"
                                readonly></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="tanggapan_show" class="col-form-label">Tanggapan Dosen Pembimbing:</label>
                            <textarea class="form-control" name="tanggapan_show" id="tanggapan_show" style="width: 100%" rows="3"
                                readonly></textarea>
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
                    <h4 class="mb-sm-0 font-size-18">Konsultasi Laporan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Konsultasi Laporan</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Info -->
        <div class="hide" id="cetakKonsultasi">
            <input type="hidden" class="form-control" id="status_konsultasi" name="status_konsultasi"
                value="{{ $detail['status_konsultasi'] }}" readonly>
            <div class="row">
                <div class="col-12">
                    <div class="card bg-transparent border-warning">
                        <div class="card-header bg-transparent border-warning">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h4 class="card-title text-warning"><i class="fas fa-exclamation-triangle"></i> |
                                        Informasi</h4>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a class="d-block text-warning btn-lg"
                                        style="border-radius: 50%; background-color: #ebede3;" type="button"
                                        data-bs-toggle="collapse" data-bs-target="#collapseCetak" aria-expanded="false"
                                        aria-controls="collapseCetak">
                                        <i class="min fas fa-angle-double-down pull-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="collapseCetak">
                            <div class="card-body" style="text-align: justify">
                                @if ($detail['status_konsultasi'] == 'Disetujui')
                                    <p>
                                        Konsultasi laporan sudah disetujui untuk pengujian, silahkan cetak kartu konsultasi
                                        melalui berikut <u><a href="{{ route('kartu-laporan.cetak') }}">Cetak
                                                Sekarang</a></u>.
                                    </p>
                                @elseif ($detail['status_konsultasi'] == 'Selesai')
                                    <p>
                                        Selamat konsultasi laporan Anda sudah selesai.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Materi -->
        @include('partial.materiKonsul')

        <!-- Card Konsultasi -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Konsultasi Laporan</h4>
                        <p class="card-title-desc">
                            Silahkan upload file konsultasi Anda.
                        </p>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> | Peringatan</h4>
                        <div class="row">
                            <div class="col-md-10">
                                <p>
                                    Pastikan Anda <b>sudah membaca</b> materi dari <b>Dosen Pembimbing</b>, sebelum
                                    melakukan <b>konsultasi</b>.
                                </p>
                            </div>
                            <div class="col-md-2">
                                <div class="d-flex justify-content-end">
                                    <a href="javascript:void(0)"
                                        class="btn btn-primary btn-md waves-effect waves-light mb-1" data-toggle="tooltip"
                                        title="Tambah Data" id="btnAdd">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered dt-responsive w-100" id="RiwayatTabels">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Waktu Konsultasi</th>
                                    <th>Deskripsi Konsultasi</th>
                                    <th>Status Peninjauan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr></tr>
                            </tbody>
                        </table>
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
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <table class="table table-responsive nowrap w-100 borderless" id="KomenTabels">
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
            </div>
        </div>
    </div>
@endsection

@section('js')
    <!-- alertifyjs Css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet"
        type="text/css" />
    <!-- alertifyjs js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/alertify.min.js"></script>

    <script>
        /* Inisiasi Partial Bab Laporan U/ Materi*/
        var jenis = "Laporan"
    </script>

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

            /* Kondisi Jika Belum Konsultasi */
            function tampilan() {
                var y = document.getElementById('status_konsultasi').value;
                if (y == "Disetujui" || y == "Selesai") {
                    document.getElementById('cetakKonsultasi').classList.remove("hide");
                    $('#cetakKonsultasi').show();
                } else {
                    document.getElementById('cetakKonsultasi').classList.remove("hide");
                    $('#cetakKonsultasi').hide();
                }
            }

            /* run function tampilan */
            $(function() {
                tampilan();
            });

            /* Get data table */
            var tableKomen = $('#KomenTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('bimbingan-laporan.index') }}",
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
                            return "<div class='text-wrap width-200'><b>" + data.nama.name +
                                "</b>&nbsp;&nbsp;" + data.waktu + "<br>" + data.komentar + "</div>"
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
                paging: false
            });

            /* Get data table */
            var tableRiwayat = $('#RiwayatTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('bimbingan-laporan.riwayat') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
                    },
                    {
                        data: 'stats',
                        name: 'status'
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

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Add */
            $("#btnAdd").click(function() {
                $('#FormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#ModalAdd').modal('show');
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                $('#FormEdit').trigger('reset');
                var this_id = $(this).data('id');
                $.get('konsultasi-laporan/show/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.id);
                    $('#fileShow').val(data.bimbingan.file_upload);
                    $('#keterangan_edit').val(data.keterangan);
                    $('iframe').attr("src", "{{ asset('dokumen/konsultasi/laporan') }}" + "/" +
                        data.bimbingan.file_upload);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('konsultasi-laporan/show/' + this_id, function(data) {
                    $('#ModalShow').modal('show');
                    if (data.status == "Disetujui") {
                        $('#status_show').val("Disetujui untuk pengujian");
                    } else if (data.status == "Selesai") {
                        $('#status_show').val("Selesai revisi pengujian");
                    } else {
                        $('#status_show').val(data.status);
                    }
                    $('#keterangan_show').val(data.keterangan);
                    $('#tanggapan_show').val(data.tanggapan);
                });
            });

            /* Button Refresh Komen */
            $("#btnRefresh").click(function() {
                tableKomen.ajax.reload();
            });

            /* Ajax Store Konsul */
            $("#FormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('bimbingan-laporan.store') }}",
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
                            form.addSave.value = "Simpan";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            form.addSave.disabled = false;
                            form.addSave.value = "Simpan";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!',
                                text: data.data
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Simpan";
                            tableRiwayat.ajax.reload();
                            $("#ModalAdd").modal('hide');
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
                        form.addSave.value = "Simpan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Ajax Update Konsul */
            $("#FormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "konsultasi-laporan/" + this_id,
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
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            tableRiwayat.ajax.reload();
                            $("#ModalEdit").modal('hide');
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function(response) {
                        form.editSave.disabled = false;
                        form.editSave.value = "Simpan"
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
                    url: "{{ route('bimbingan-laporan.storeKomen') }}",
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
        });
    </script>

    @yield('MateriJs')
@endsection
