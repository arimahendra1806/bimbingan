@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="DosenModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="DosenFormAdd">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="nidn_add" class="col-form-label">NIDN:</label>
                                <input type="text" class="form-control" id="nidn_add" name="nidn_add"
                                    placeholder="e.g: 17XXXXXXX">
                                <span class="text-danger error-text nidn_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="nama_dosen_add" class="col-form-label">Nama Dosen:</label>
                                <input type="text" class="form-control" id="nama_dosen_add" name="nama_dosen_add"
                                    placeholder="e.g: Budi">
                                <span class="text-danger error-text nama_dosen_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="email_add" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email_add" name="email_add"
                                    placeholder="e.g: Budi@gmail.com">
                                <span class="text-danger error-text email_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="no_telepon_add" class="col-form-label">Nomor Telepon: <b
                                        class="error">*Pastikan Tanpa 0 | Terhubung Whatsapp</b></label>
                                <div class="input-group">
                                    <div class="input-group-text">+62</div>
                                    <input type="text" class="form-control" id="no_telepon_add" name="no_telepon_add"
                                        placeholder="e.g: 81XXXXXXXX">
                                </div>
                                <span class="text-danger error-text no_telepon_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="alamat_add" class="col-form-label">Alamat:</label><br>
                                <textarea class="form-control" name="alamat_add" id="alamat_add" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text alamat_add_error"></span>
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
    <div class="modal fade" id="DosenModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="DosenFormEdit" class="form-inline">
                    <input type="hidden" class="form-control" id="dosen_id_edit" name="dosen_id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="nidn_edit" class="col-form-label">NIDN:</label>
                                <input type="text" class="form-control" id="nidn_edit" name="nidn_edit">
                                <span class="text-danger error-text nidn_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="nama_dosen_edit" class="col-form-label">Nama Dosen:</label>
                                <input type="text" class="form-control" id="nama_dosen_edit" name="nama_dosen_edit">
                                <span class="text-danger error-text nama_dosen_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="email_edit" class="col-form-label">Email:</label>
                                <input type="text" class="form-control" id="email_edit" name="email_edit">
                                <span class="text-danger error-text email_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="no_telepon_edit" class="col-form-label">Nomor Telepon:</label>
                                <div class="input-group">
                                    <div class="input-group-text">+62</div>
                                    <input type="text" class="form-control" id="no_telepon_edit" name="no_telepon_edit">
                                </div>
                                <span class="text-danger error-text no_telepon_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="alamat_edit" class="col-form-label">Alamat:</label><br>
                                <textarea class="form-control" name="alamat_edit" id="alamat_edit" style="width: 100%" rows="2"></textarea>
                                <span class="text-danger error-text alamat_edit_error"></span>
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
    <div class="modal fade" id="DosenModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nidn_show" class="col-form-label">NIDN:</label>
                            <input type="text" class="form-control no-outline" id="nidn_show" name="nidn_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_dosen_show" class="col-form-label">Nama Dosen:</label>
                            <input type="text" class="form-control no-outline" id="nama_dosen_show" name="nama_dosen_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="email_show" class="col-form-label">Email:</label>
                            <input type="text" class="form-control no-outline" id="email_show" name="email_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="no_telepon_show" class="col-form-label">Nomor Telepon:</label>
                            <input type="text" class="form-control no-outline" id="no_telepon_show" name="no_telepon_show"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="alamat_show" class="col-form-label">Alamat:</label><br>
                            <textarea class="form-control" name="alamat_show" id="alamat_show" style="width: 100%" rows="3" readonly></textarea>
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

    {{-- Modal Import --}}
    <div class="modal fade" id="ImportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Impor Data Dosen</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="ImportForm" enctype="multipart/form-data" files="true">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="file_import" class="col-form-label">File Impor: <b
                                    class="error">*Pastikan Format CSV/XLSX/XLS</b></label>
                            <input type="file" class="form-control mb-1" id="file_import" name="file_import">
                            <span class="text-danger error-text file_import_error mb-2"></span>
                        </div>
                        <div class="mb-3">
                            <a href="{{ asset('assets/img') }}/import_dosen_large.png" class="glightbox">
                                <img src="{{ asset('assets/img') }}/import_dosen_small.png" alt="image" width="100%" />
                            </a>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="" aria-valuemin="0"
                                aria-valuemax="100" style="width: 0%">
                                0%
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <input type="submit" class="btn btn-primary" name="imporSave" value="Impor Sekarang">
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- END Modal Import --}}

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Kelola Data Dosen</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Data Dosen</li>
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
                        <h4 class="card-title">Data Dosen</h4>
                        <p class="card-title-desc">Anda perlu mengelola <b>Data Dosen</b>
                            yang <b>Aktif</b>, sehingga mereka bisa menggunakan <b>Sistem Informasi</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                                <i class="fas fa-plus-circle"></i>
                            </a>&nbsp;
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Impor Data" id="btnImport">
                                <i class="fas fa-file-import"></i>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="DosenTabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIDN</th>
                                        <th>Nama Dosen</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
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

    {{-- DataTables --}}
    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Get data table */
            var table = $('#DosenTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelola-dosen.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nidn',
                        name: 'nidn'
                    },
                    {
                        data: 'nama_dosen',
                        name: 'nama_dosen'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'no_telepon',
                        name: 'no_telepon'
                    },
                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0, 5]
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
                    },
                    {
                        targets: [4],
                        render: function(data, type, full, meta) {
                            return '+62' + data;
                        }
                    }
                ],
                order: [
                    [1, 'asc']
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
                $('#DosenFormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#DosenModalAdd').modal('show');
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                var this_id = $(this).data('id');
                $.get('kelola-dosen/' + this_id, function(data) {
                    $('#DosenModalEdit').modal('show');
                    $('#dosen_id_edit').val(data.id);
                    $('#nidn_edit').val(data.nidn);
                    $('#nama_dosen_edit').val(data.nama_dosen);
                    $('#alamat_edit').val(data.alamat);
                    $('#email_edit').val(data.email);
                    $('#no_telepon_edit').val(data.no_telepon);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('kelola-dosen/' + this_id, function(data) {
                    $('#DosenModalShow').modal('show');
                    $('#nidn_show').val(data.nidn);
                    $('#nama_dosen_show').val(data.nama_dosen);
                    $('#alamat_show').val(data.alamat);
                    $('#email_show').val(data.email);
                    $('#no_telepon_show').val('+62' + data.no_telepon);
                });
            });

            /* Button Delete */
            $('body').on('click', '#btnDelete', function() {
                var this_id = $(this).data("id");
                Swal.fire({
                    title: 'Data yang berkaitan akan terhapus secara keseluruhan! <br> Apakah anda ingin menghapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "kelola-dosen/delete/" + this_id,
                            type: 'post',
                            data: {
                                "id": this_id,
                            },
                            success: function(data) {
                                table.ajax.reload();
                                Swal.fire({
                                    title: data.msg,
                                    icon: "success",
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        });
                    }
                });
            });

            /* Button Import */
            $("#btnImport").click(function() {
                $('#ImportForm').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#ImportModal').modal('show');
                $('.progress-bar').text('0%');
                $('.progress-bar').css('width', '0%');
            });

            /* Ajax Store */
            $("#DosenFormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kelola-dosen.store') }}",
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
                        } else {
                            form.addSave.disabled = false;
                            form.addSave.value = "Simpan";
                            table.ajax.reload();
                            $("#DosenModalAdd").modal('hide');
                            Swal.fire({
                                title: "Berhasil Menambahkan Data!",
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

            /* Ajax Update */
            $("#DosenFormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("dosen_id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "kelola-dosen/" + this_id,
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
                            table.ajax.reload();
                            $("#DosenModalEdit").modal('hide');
                            Swal.fire({
                                title: "Berhasil Memperbarui Data!",
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

            /* Ajax Import */
            $("#ImportForm").submit(function(e) {
                var form = this;
                form.imporSave.disabled = true;
                form.imporSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    xhr: function() {
                        var xhr = new window.XMLHttpRequest();
                        xhr.upload.addEventListener("progress", function(evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = (evt.loaded / evt.total) * 100;
                                $('.progress-bar').text(percentComplete + '%');
                                $('.progress-bar').css('width', percentComplete + '%');
                            }
                        }, false);
                        return xhr;
                    },
                    url: "{{ route('kelola-dosen.import') }}",
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
                            form.imporSave.disabled = false;
                            form.imporSave.value = "Impor Sekarang";
                            $('.progress-bar').text('0%');
                            $('.progress-bar').css('width', '0%');
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            form.imporSave.disabled = false;
                            form.imporSave.value = "Impor Sekarang";
                            $('.progress-bar').text('Uploaded');
                            $('.progress-bar').css('width', '100%');
                            table.ajax.reload();
                            Swal.fire({
                                title: data.msg,
                                icon: "success",
                            }).then(function() {
                                $("#ImportModal").modal('hide');
                            });
                        }
                    },
                    error: function(response) {
                        form.imporSave.disabled = false;
                        form.imporSave.value = "Impor Sekarang";
                        $('.progress-bar').text('0%');
                        $('.progress-bar').css('width', '0%');
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!'
                        });
                    }
                });
            });

            /* Import Info Gambar */
            const lightbox = GLightbox({
                touchNavigation: true,
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
