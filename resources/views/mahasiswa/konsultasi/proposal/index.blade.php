@extends('layouts.minia.header')

@section('content')
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
                            <form id="Store" enctype="multipart/form-data" files="true">
                                <div class="row mb-1">
                                    <div class="col-md-4">
                                        <label for="pembimbing_kode" class="col-form-label">Kode Bimbingan: <b
                                                class="info">*Otomatis Terisi</b></label>
                                        <input type="text" class="form-control" id="pembimbing_kode"
                                            name="pembimbing_kode"
                                            value="{{ $user->mahasiswa->dospem->bimbingan->kode_bimbingan }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="tahun_ajaran_id" class="col-form-label">Tahun Ajaran: <b
                                                class="info">*Otomatis Terisi</b></label>
                                        <input type="text" class="form-control" id="tahun_ajaran_id"
                                            name="tahun_ajaran_id" value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="status_konsultasi" class="col-form-label">Status: <b
                                                class="info">*Otomatis Terisi</b></label>
                                        <input type="text" class="form-control" id="status_konsultasi"
                                            name="status_konsultasi"
                                            value="{{ $user->mahasiswa->dospem->bimbingan->status_konsultasi }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="file_upload" class="col-form-label">File Upload: <b
                                                class="error">*Pastikan format PDF | Max 2MB</b></label>
                                        <input type="text" class="form-control no-outline" id="fileShow" name="fileShow"
                                            value="{{ $user->mahasiswa->dospem->bimbingan->file_upload }}"
                                            style="display: none" readonly>
                                        <input type="file" class="form-control" id="file_upload" name="file_upload">
                                        <span class="text-danger error-text file_upload_error"></span>
                                        <iframe style="width:100%; height:400px;" frameborder="0" id="fileView"></iframe>
                                    </div>
                                </div>
                                <div class="row mb-1">
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
                                    <table class="table dt-responsive nowrap w-100 borderless" id="KomenTabels">
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
            $(function() {
                var x = document.getElementById('fileShow').value;
                if (x == 0) {
                    document.getElementById('fileShow').style.display = "none";
                    document.getElementById('fileView').style.display = "none";
                } else {
                    document.getElementById('fileShow').style.display = "block";
                    document.getElementById('fileView').style.display = "block";
                    $('iframe').attr("src", "{{ asset('dokumen/konsultasi/proposal') }}" + "/" + x);
                }
            })

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
                            return "<b>" + data.nama + "</b>&nbsp;&nbsp;" + data.waktu_komentar
                                .toLocaleString() +
                                "<br>" + data.komentar
                        }
                    }
                ],
                order: false,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
                oLanguage: {
                    sEmptyTable: "Belum terdapat komentar"
                },
                scrollY: "200px",
                scrollCollapse: true,
                paging: false
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

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
                            document.getElementById('fileShow').style.display = "block";
                            document.getElementById('fileView').style.display = "block";
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