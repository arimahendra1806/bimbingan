@extends('layouts.minia.header')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Konsultasi Program</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Konsultasi Program</li>
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
                        <h4 class="card-title">Konsultasi Program</h4>
                        <p class="card-title-desc">
                            Lengkapi form berikut untuk melakukan <b>konsultasi</b>, silahkan upload link video hasil
                            pengerjaan program kalian.
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
                            <form id="Store">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="link_upload" class="col-form-label">Link Video: <b
                                                class="error">*Pastikan upload di Youtube</b></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control no-outline" id="linkShow" name="linkShow"
                                                value="{{ $detail['link'] }}" style="display: none" readonly>
                                            <a class="btn btn-info waves-effect waves-light image-popup-video-map"
                                                type="button" data-toggle="tooltip" title="Pertinjau Video" id="btnShow">
                                                <i class="fab fa-youtube-square"></i>
                                            </a>
                                        </div>
                                        <input type="text" class="form-control" id="link_upload" name="link_upload">
                                        <span class="text-danger error-text link_upload_error"></span>
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
    <!-- glightbox css -->
    <link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/libs/glightbox/css/glightbox.min.css">
    <!-- glightbox js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/glightbox/js/glightbox.min.js"></script>

    <script>
        /* Inisiasi Partial Bab Program U/ Materi dan Riwayat */
        var jenis = "Program"
        var lightboxvideo = GLightbox({
            selector: ".image-popup-video-map"
        });
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
                var x = document.getElementById('linkShow').value;
                if (x) {
                    $('#linkShow').show();
                    $('#btnShow').show();
                } else {
                    $('#linkShow').hide();
                    $('#btnShow').hide();
                }
            }

            /* Function detail link video */
            function linkVideo() {
                var getLink = document.getElementById('linkShow').value;
                getLink = getLink.replace('https://', '//');

                lightboxvideo.setElements([{
                    href: getLink
                }]);
            }

            /* run function tampilan */
            $(function() {
                tampilan();
            });

            /* Get data table */
            var tableKomen = $('#KomenTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('bimbingan-program.index') }}",
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
                linkVideo();
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
                    url: "{{ route('bimbingan-program.store') }}",
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
                            $('#status_konsultasi').val(data.data.status_konsultasi);
                            $('#linkShow').val(data.data.link_upload);
                            $('#link_upload').val("");
                            linkVideo();
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
                    url: "{{ route('bimbingan-program.storeKomen') }}",
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
