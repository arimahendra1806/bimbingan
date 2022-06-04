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
                    <h4 class="mb-sm-0 font-size-18">Konsultasi Proposal</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Konsultasi Proposal</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Info -->
        <div class="hide" id="cetakKonsultasi">
            <div class="row">
                <div class="col-12">
                    <div class="card bg-transparent border-warning">
                        <div class="card-header bg-transparent border-warning">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="card-title text-warning"><i class="fas fa-exclamation-triangle"></i> |
                                        Informasi</h4>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <a class="d-block text-warning" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseCetak" aria-expanded="false" aria-controls="collapseCetak">
                                        <i class="min fas fa-angle-double-down pull-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="collapseCetak">
                            <div class="card-body" style="text-align: justify">
                                <p>
                                    Konsultasi sudah selesai, silahkan cetak kartu konsultasi melalui berikut
                                    <u><a href="{{ route('kartu-proposal.cetak') }}">Cetak Sekarang</a></u>.
                                </p>
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
                        <h4 class="card-title">Konsultasi Proposal</h4>
                        <p class="card-title-desc">
                            Lengkapi form berikut untuk melakukan <b>konsultasi</b>, silahkan upload file hasil pengerjaan
                            kalian.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <h4 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> | Peringatan</h4>
                            <p>
                                Pastikan Anda <b>sudah membaca</b> materi dari <b>Dosen Pembimbing</b>, sebelum melakukan
                                <b>konsultasi</b>.
                            </p>
                            <hr>
                            <div class="row mb-1">
                                <div class="col-md-4">
                                    <label for="kode_bimbingan" class="col-form-label">Kode Bimbingan: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="kode_bimbingan" name="kode_bimbingan"
                                        value="{{ $detail['kode_bimbingan'] }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="tahun_ajaran_id" class="col-form-label">Tahun Ajaran: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="tahun_ajaran_id" name="tahun_ajaran_id"
                                        value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="status_konsultasi" class="col-form-label">Status: <b
                                            class="info">*Otomatis Terisi</b></label>
                                    <input type="text" class="form-control" id="status_konsultasi"
                                        name="status_konsultasi" value="{{ $detail['status_konsultasi'] }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <label for="keterangan" class="col-form-label">Keterangan Konsultasi Sebelumnya: <b
                                            class="info">*Otomatis Terisi</b></label><br>
                                    <textarea class="form-control" name="keterangan" id="keterangan" style="width: 100%" rows="3" aria-valuetext=""
                                        readonly>{{ $detail['keterangan'] }}</textarea>
                                </div>
                            </div>
                            <form id="Store" enctype="multipart/form-data" files="true">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="file_upload" class="col-form-label">File Upload: <b
                                                class="error">*Pastikan format PDF | Max 2MB</b></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control no-outline" id="fileShow" name="fileShow"
                                                value="{{ $detail['file'] }}" style="display: none" readonly>
                                            <a href="javascript:void(0)" class="btn btn-info waves-effect waves-light"
                                                type="button" data-toggle="tooltip" title="Pertinjau File" id="btnShow">
                                                <i class="far fa-file-pdf"></i>
                                            </a>
                                        </div>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                                        <span class="text-danger error-text file_upload_error"></span>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <input type="submit" class="btn btn-primary" name="addSave"
                                            value="Konsultasi Sekarang">
                                    </div>
                                </div>
                            </form>
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

        <!-- Card Riwayat -->
        @include('partial.riwayatKonsul')

    </div>
@endsection

@section('js')
    <!-- alertifyjs Css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/css/alertify.min.css" rel="stylesheet"
        type="text/css" />
    <!-- alertifyjs js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/alertifyjs/build/alertify.min.js"></script>

    <script>
        /* Inisiasi Partial Bab Proposal U/ Materi dan Riwayat */
        var jenis = "Proposal"
    </script>

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
                var x = document.getElementById('fileShow').value;
                console.log(x);
                if (x) {
                    $('#fileShow').show();
                    $('#btnShow').show();
                } else {
                    $('#fileShow').hide();
                    $('#btnShow').hide();
                }
                var y = document.getElementById('status_konsultasi').value;
                if (y == "Disetujui") {
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
                ajax: "{{ route('bimbingan-proposal.index') }}",
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

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Show File */
            $("#btnShow").click(function() {
                $('#Modal').modal('show');
                $('iframe').attr("src", "{{ asset('dokumen/konsultasi/proposal') }}" + "/" + document
                    .getElementById('fileShow').value);
            });

            /* Button Refresh Komen */
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
                    url: "{{ route('bimbingan-proposal.store') }}",
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
                            form.addSave.value = "Konsultasi Sekarang";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            form.addSave.disabled = false;
                            form.addSave.value = "Konsultasi Sekarang";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!',
                                text: data.data
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Konsultasi Sekarang";
                            $("#file_upload").val('');
                            $('#status_konsultasi').val(data.data.status_konsultasi);
                            $('#fileShow').val(data.data.file_upload);
                            $('iframe').attr("src",
                                "{{ asset('dokumen/konsultasi/proposal') }}" +
                                "/" +
                                data.data.file_upload);
                            tampilan();
                            tableRiwayat.ajax.reload();
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
                        form.addSave.value = "Konsultasi Sekarang";
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
                    url: "{{ route('bimbingan-proposal.storeKomen') }}",
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
    @yield('RiwayatJs')
@endsection
