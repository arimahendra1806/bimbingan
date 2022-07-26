@extends('layouts.minia.header')

@section('content')
    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Judul Tugas Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="judul_edit" class="col-form-label">Judul Yang Diajukan:</label>
                                <textarea name="judul_edit" class="form-control" id="judul_edit" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text judul_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="studi_kasus_edit" class="col-form-label">Studi Kasus:</label>
                                <textarea name="studi_kasus_edit" class="form-control" id="studi_kasus_edit" style="width: 100%" rows="3"></textarea>
                                <span class="text-danger error-text studi_kasus_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="pengerjaan_edit" class="col-form-label">Pengerjaan:</label>
                                <input type="text" class="form-control" id="pengerjaan_edit" name="pengerjaan_edit"
                                    value="" readonly>
                                {{-- <select class="js-example-responsive form-control" style="width: 100%" id="pengerjaan_edit"
                                    name="pengerjaan_edit">
                                    <option value=""></option>
                                    <option value="Sendiri">Sendiri</option>
                                    <option value="Kelompok">Kelompok</option>
                                </select>
                                <span class="text-danger error-text pengerjaan_edit_error"></span> --}}
                            </div>
                            <div class="col-md-6">
                                <label for="id_anggota_edit" class="col-form-label">Anggota Kelompok:</label>
                                <input type="text" class="form-control" id="id_anggota_edit" name="id_anggota_edit"
                                    value="" readonly>
                                {{-- <select class="js-example-responsive form-control" style="width: 100%" id="id_anggota_edit"
                                    name="id_anggota_edit">
                                    <option value="Tidak Ada">Tidak Ada</option>
                                    @foreach ($mahasiswa as $mhs)
                                        <option value="{{ $mhs->id }}">
                                            {{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}
                                        </option>
                                    @endforeach
                                </select> --}}
                                {{-- <span class="text-danger error-text id_anggota_edit_error"></span> --}}
                            </div>
                        </div>
                        {{-- <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="status_cek" name="status_cek">
                                    <label class="form-check-label" for="status_cek">
                                        Centang jika ingin memisahkan diri dari kelompok Anda
                                    </label>
                                </div>
                            </div>
                        </div><br>
                        <p style="font-size: 9pt">
                            note : <br>
                            jika memisahkan diri dari kelompok, maka kelompok Anda saat ini akan otomatis dibubarkan!
                        </p> --}}
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

    <div class="container-fluid">
        <!-- u/ kondisi halaman Jika data kosong -->
        <input type="hidden" value="{{ $count }}" id="counts">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Pengajuan Judul Tugas Akhir</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Pengajuan Judul Tugas Akhir</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="hide" id="pertama">
            <!-- Tambah Data -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Tambah Data Pengajuan Judul Tugas Akhir</h4>
                            <p class="card-title-desc">Mahasiswa perlu mengisi form pengajuan <b>Judul Tugas Akhir</b>,
                                agar nantinya segera mendapatkan <b>Dosen Pembimbing</b>.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="container">
                                <h4 class="card-title text-danger"><i class="fas fa-exclamation-triangle"></i> |
                                    Peringatan
                                </h4>
                                <p>
                                    Sebelum mengajukan <b>Judul Tugas Akhir</b>, pastikan <b>Sudah Membaca Ketentuan Tugas
                                        Akhir</b>
                                    yang terdapat pada menu <u><a href="{{ route('ketentuan-ta.index') }}">Ketentuan
                                            TA</a></u>.
                                </p>
                                <hr>
                                <form id="FormAdd">
                                    @csrf
                                    <div class="row mb-1">
                                        <div class="col-md-6">
                                            <label for="mahasiswa_add" class="col-form-label">NIM: <b
                                                    class="info">*Otomatis Terisi</b></label>
                                            <input type="text" class="form-control" id="mahasiswa_add"
                                                name="mahasiswa_add" value="{{ $user->mahasiswa->nim }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tahun_ajaran_id_add" class="col-form-label">Tahun Ajaran: <b
                                                    class="info">*Otomatis Terisi</b></label>
                                            <input type="text" class="form-control" id="tahun_ajaran_id_add"
                                                name="tahun_ajaran_id_add" value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <label for="judul_add" class="col-form-label">Judul Yang Diajukan:</label>
                                            <textarea name="judul_add" class="form-control" id="judul_add" style="width: 100%" rows="3"
                                                placeholder="Kata dalam judul maksimal 15 kata | Judul memuat detail sistem, tempat, dan fitur | Judul yang diajukan bisa berbasis android, website, IOT, maupun desktop &#10;e.g: Sistem Informasi Sekolah Dasar SMPN 1 Gurah Berbasis Website Dengan Framework Laravel"></textarea>
                                            <span class="text-danger error-text judul_add_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-12">
                                            <label for="studi_kasus_add" class="col-form-label">Studi Kasus:</label>
                                            <textarea name="studi_kasus_add" class="form-control" id="studi_kasus_add" style="width: 100%" rows="3"
                                                placeholder="Isikan sesuai dengan tempat pelaksanaan tugas akhir yang diajukan | Mahasiswa harus melaksanakan riset terhadap tempat studi kasus, sebelum mengajukan judul &#10;e.g: SMPN 1 Gurah"></textarea>
                                            <span class="text-danger error-text studi_kasus_add_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="pengerjaan_add" class="col-form-label">Pengerjaan:</label>
                                            <select class="js-example-responsive form-control" style="width: 100%"
                                                id="pengerjaan_add" name="pengerjaan_add">
                                                <option value=""></option>
                                                <option value="Sendiri">Sendiri</option>
                                                <option value="Kelompok">Kelompok</option>
                                            </select>
                                            <span class="text-danger error-text pengerjaan_add_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="id_anggota_add" class="col-form-label">Anggota Kelompok: <b
                                                    class="info">*Pilih "Tidak Ada", jika pengerjaan
                                                    sendiri</b></label>
                                            <select class="js-example-responsive form-control" style="width: 100%"
                                                id="id_anggota_add" name="id_anggota_add" readonly>
                                                <option value="Tidak Ada">Tidak Ada</option>
                                                @foreach ($mahasiswa as $mhs)
                                                    <option value="{{ $mhs->id }}">
                                                        {{ $mhs->nim }} - {{ $mhs->nama_mahasiswa }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text id_anggota_add_error"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-1">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <input type="submit" class="btn btn-primary" name="addSave"
                                                value="Ajukan Sekarang">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hide" id="kedua">
            <!-- Info -->
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
                                        data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample">
                                        <i class="min fas fa-angle-double-down pull-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="collapse show" id="collapseExample">
                            <div class="card-body" style="text-align: justify">
                                <p>
                                    <b>Status Judul Tugas Akhir Anda</b> akan diperbarui setelah mendapat persetujuan dari
                                    <b>Dosen Pembimbing</b>.
                                    Diharapkan Mahasiswa segera melaksanakan konsultasi terkait <b>Pengajuan Judul Tugas
                                        Akhir</b> pada menu <u><a href="{{ route('bimbingan-judul.index') }}">Konsultasi
                                            Judul</a></u>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabel -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Data Pengajuan Judul Tugas Akhir</h4>
                            <p class="card-title-desc">Mahasiswa setelah mengajukan <b>Judul Tugas Akhir</b>,
                                akan segera mendapatkan <b>Dosen Pembimbing</b> sesuai dengan judul yang diajukan.
                            </p>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped dt-responsive w-100" id="Tabels">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Yang Diajukan</th>
                                            <th>Studi Kasus</th>
                                            <th>Pengerjaan</th>
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

    </div>
@endsection

@section('js')
    <!-- select2 css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>

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

            /* Kondisi Jika Data Kosong */
            $(function() {
                const isEmpty = document.getElementById('counts').value == "0";
                if (isEmpty) {
                    document.getElementById('pertama').classList.remove("hide");
                    document.getElementById('kedua').classList.remove("hide");
                    $('#pertama').show();
                    $('#kedua').hide();
                } else {
                    document.getElementById('pertama').classList.remove("hide");
                    document.getElementById('kedua').classList.remove("hide");
                    $('#pertama').hide();
                    $('#kedua').show();
                }
            });

            /* Get data table */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengajuan-judul.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'judul',
                        name: 'judul'
                    },
                    {
                        data: 'studi_kasus',
                        name: 'studi_kasus'
                    },
                    {
                        data: 'pengerjaan',
                        name: 'pengerjaan'
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
                        targets: '_all'
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
                    },
                    {
                        targets: [0, 4, 5],
                        class: "wrapok"
                    }
                ],
                order: false,
                bPaginate: false,
                bLengthChange: false,
                bFilter: false,
                bInfo: false,
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                var this_id = $(this).data('id');
                $.get('pengajuan-judul/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.id);
                    $('#judul_edit').val(data.judul);
                    $('#studi_kasus_edit').val(data.studi_kasus);
                    $('#pengerjaan_edit').val(data.pengerjaan);
                    if (data.id_anggota == 0) {
                        $('#id_anggota_edit').val("Tidak Ada");
                    } else {
                        $('#id_anggota_edit').val(data.anggota.nama_mahasiswa);
                    }
                });
            });

            /* Ajax Store */
            $("#FormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('pengajuan-judul.store') }}",
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
                            form.addSave.value = "Ajukan Sekarang";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else if (data.status == 1) {
                            form.addSave.disabled = false;
                            form.addSave.value = "Ajukan Sekarang";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!',
                                text: data.data
                            });
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Ajukan Sekarang";
                            document.getElementById('pertama').classList.remove("hide");
                            document.getElementById('kedua').classList.remove("hide");
                            $('#pertama').hide();
                            $('#kedua').show();
                            table.ajax.reload();
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
                        form.addSave.value = "Ajukan Sekarang";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!',
                        });
                    }
                });
            });

            /* Ajax Update */
            $("#FormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "pengajuan-judul/" + this_id,
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
                        } else if (data.status == 1) {
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops, Muncul Kesalahan !!',
                                text: data.data
                            });
                        } else {
                            form.editSave.disabled = false;
                            form.editSave.value = "Simpan";
                            table.ajax.reload();
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
                        form.editSave.value = "Simpan";
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Select2 Pengerjaan Add */
            $("#pengerjaan_add").select2({
                placeholder: "Pilih berdasarkan status pengerjaan ..",
                minimumResultsForSearch: -1
            });

            /* Select2 Anggota Add */
            $("#id_anggota_add").select2({});

            /* Select2 Event Pengerjaan Add */
            $('#pengerjaan_add').on('select2:select', function(e) {
                var x = document.getElementById('pengerjaan_add').value;
                if (x == "Sendiri") {
                    $('#id_anggota_add').val('Tidak Ada').trigger('change');
                }
            });

            /* Select2 Pengerjaan Edit */
            // $("#pengerjaan_edit").select2({
            //     dropdownParent: $('#ModalEdit'),
            //     placeholder: "Pilih berdasarkan status pengerjaan ..",
            //     minimumResultsForSearch: -1
            // });

            /* Select2 Anggota Edit */
            // $("#id_anggota_edit").select2({
            //     dropdownParent: $('#ModalEdit')
            // });

            /* Select2 Event Pengerjaan Edit */
            // $('#pengerjaan_edit').on('select2:select', function(e) {
            //     const y = document.getElementById('pengerjaan_edit').value;
            //     if (y == "Sendiri") {
            //         $('#id_anggota_edit').val('Tidak Ada').trigger('change');
            //     }
            // });
        });
    </script>
@endsection
