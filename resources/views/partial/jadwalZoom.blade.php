{{-- Modal Riwayat --}}
<div class="modal fade" id="ModalRiwayat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Riwayat Bergabung Zoom</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-1">
                    <label for="tanggal_riwayat" class="col-form-label">Tanggal Pengajuan:</label>
                    <input type="text" class="form-control no-outline" id="tanggal_riwayat" name="tanggal_riwayat">
                </div>
                <div class="mb-1">
                    <label for="jam_riwayat" class="col-form-label">Jam Pengajuan:</label>
                    <input type="text" class="form-control no-outline" id="jam_riwayat" name="jam_riwayat" readonly>
                </div>
                <div class="mb-1">
                    <label for="status_riwayat" class="col-form-label">Status Pengajuan:</label>
                    <input type="text" class="form-control no-outline" id="status_riwayat" name="status_riwayat"
                        readonly>
                </div>
                <div class="mb-3">
                    <label for="zoom_riwayat" class="col-form-label" id="zoom_label_riwayat">Detail link Zoom:</label>
                    <textarea class="form-control" name="zoom_riwayat" id="zoom_riwayat" style="width: 100%" rows="3" readonly></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- END Modal Riwayat --}}

<!-- Card Jadwal -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Gabung Jadwal Zoom</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="d-block text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            <i class="max fas fa-angle-double-up pull-right"></i>
                        </a>
                    </div>
                </div>
                <p class="card-title-desc">
                    Berikut adalah jadwal zoom yang telah berstatus diterima.
                    Anda bisa bergabung dengan jadwal tersebut, jika <b>kuota masih ada</b>.
                </p>
            </div>
            <div class="collapse" id="collapseExample">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-md" id="JadwalTabels" cellspacing="0" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Nama</th>
                                    <th>Tgl</th>
                                    <th>Jam</th>
                                    <th>Total</th>
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

<!-- Card Riwayat -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Riwayat Gabung Jadwal Zoom</h4>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a class="d-block text-primary" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseRiwayat" aria-expanded="false" aria-controls="collapseRiwayat">
                            <i class="max fas fa-angle-double-up pull-right"></i>
                        </a>
                    </div>
                </div>
                <p class="card-title-desc">
                    Berikut adalah riwayat Anda dalam bergabung dengan jadwal zoom lain.
                </p>
            </div>
            <div class="collapse" id="collapseRiwayat">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped dt-responsive nowrap w-100"
                            id="RiwayatJadwalTabels">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Jam Pengajuan</th>
                                    <th>Status</th>
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

@section('JadwalZoomJs')
    <!-- cards css -->
    <style>
        .cards tbody tr {
            float: left;
            width: 36rem;
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

    <script>
        /* Cards view */
        $(function() {
            $("#JadwalTabels").toggleClass("cards");
            $("#JadwalTabels thead").toggle();
        });

        /* Get data table jadwal */
        var jadwalTabel = $('#JadwalTabels').DataTable({
            ajax: "{{ route('partial.JadwalZoom') }}",
            columns: [{
                    data: function(data, type, dataToSet) {
                        return "Jadwal Zoom : " + data.tanggal + " / " + data.jam
                    }
                },
                {
                    data: function(data, type, dataToSet) {
                        return "<div class='row'><div class='col-md-9'>" +
                            "<div style='word-wrap: break-word;'>" +
                            "Permintaan Zoom dari " + data.pembimbing.mahasiswa.nama_mahasiswa +
                            " telah diterima. Silahkan Mahasiswa lain bisa ikut bergabung" +
                            "</div></div><div class='col-md-3 d-flex justify-content-end'>" +
                            "<div class='text-wrap width-50'>" +
                            data.total + "/5" + "&nbsp&nbsp" + data.action + "</div></div></div>"
                    }
                },
                {
                    data: 'pembimbing.mahasiswa.nama_mahasiswa',
                    name: 'pembimbing.mahasiswa.nama_mahasiswa',
                    visible: false
                },
                {
                    data: 'tanggal',
                    name: 'tanggal',
                    visible: false
                },
                {
                    data: 'jam',
                    name: 'jam',
                    visible: false
                },
                {
                    data: 'total',
                    name: 'total',
                    visible: false
                }
            ],
            oLanguage: {
                sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
            }
        });

        /* Get data tablem riwayat */
        var RiwayatJadwalTabel = $('#RiwayatJadwalTabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('partial.RiwayatJadwalZoom') }}",
            autoWidth: false,
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'jadwal.tanggal',
                    name: 'jadwal.tanggal'
                },
                {
                    data: 'jadwal.jam',
                    name: 'jadwal.jam'
                },
                {
                    data: 'jadwal.status',
                    name: 'jadwal.status'
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
                }
            ],
            order: [
                [1, 'desc']
            ],
            oLanguage: {
                sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
            }
        });

        /* Button Gabung */
        $('body').on('click', '#btnGabung', function() {
            var this_id = $(this).data('id');
            Swal.fire({
                title: 'Apakah Anda yakin ingin bergabung?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'jadwal-zoom/' + this_id,
                        type: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (data.status == 1) {
                                Swal.fire({
                                    icon: 'error',
                                    title: data.msg
                                });
                            } else {
                                jadwalTabel.ajax.reload();
                                RiwayatJadwalTabel.ajax.reload();
                                Swal.fire({
                                    title: data.msg,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!'
                            });
                        }
                    });
                }
            });
        });

        /* Button Riwayat */
        $('body').on('click', '#btnRiwayat', function() {
            var this_id = $(this).data('id');
            $.get('riwayat-jadwal-zoom/' + this_id, function(data) {
                $('#ModalRiwayat').modal('show');
                $('#tanggal_riwayat').val(data.jadwal.tanggal);
                $('#jam_riwayat').val(data.jadwal.jam);
                $('#status_riwayat').val(data.jadwal.status);
                if (data.jadwal.status == 'Diterima') {
                    $('#zoom_label_riwayat').show();
                    $('#zoom_riwayat').show();
                    $('#zoom_riwayat').val("ID Meeting:  " + data.jadwal.pembimbing.zoom.id_meeting +
                        "\nPassode:  " + data.jadwal.pembimbing.zoom.passcode + "\nLink Zoom:  " +
                        data.jadwal.pembimbing.zoom.link_zoom);
                }
            });
        });
    </script>
@endsection
