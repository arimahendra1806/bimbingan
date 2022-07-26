@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="PenggunaModalAdd" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="PenggunaFormAdd">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="nama_pengguna_add" class="col-form-label">Nama Pengguna:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="nama_pengguna_add" name="nama_pengguna_add">
                                    <option value=""></option>
                                    @foreach ($dosen_id as $dosen)
                                        <option value="{{ $dosen->nama_dosen }}" data-iden="{{ $dosen->nidn }}">
                                            {{ $dosen->nama_dosen }}</option>
                                    @endforeach
                                    @foreach ($mhs_id as $mhs)
                                        <option value="{{ $mhs->nama_mahasiswa }}" data-iden="{{ $mhs->nim }}">
                                            {{ $mhs->nama_mahasiswa }}</option>
                                    @endforeach
                                    @foreach ($admin_id as $admin)
                                        <option value="{{ $admin->nama_admin }}" data-iden="{{ $admin->nip }}">
                                            {{ $admin->nama_admin }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text nama_pengguna_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="username_add" class="col-form-label">Username: <b class="info">*Otomatis
                                        Terisi Jika Nama Pengguna Dipilih</b></label>
                                <input type="text" class="form-control" id="username_add" name="username_add"
                                    placeholder="*e.g: NIDN/NIM" readonly>
                                <span class="text-danger error-text username_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_id_add" class="col-form-label">Tahun Ajaran:</label>
                                <input type="text" class="form-control" id="tahun_ajaran_id_add"
                                    name="tahun_ajaran_id_add" value="{{ $tahun_aktif->tahun_ajaran }}" readonly>
                                <span class="text-danger error-text tahun_ajaran_id_add_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="role_pengguna_add" class="col-form-label">Role Pengguna:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="role_pengguna_add" name="role_pengguna_add">
                                    <option value=""></option>
                                    <option value="koordinator">Koordinator</option>
                                    <option value="kaprodi">Kaprodi</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="admin">Admin Prodi</option>
                                </select>
                                <span class="text-danger error-text role_pengguna_add_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="password_pengguna_add" class="col-form-label">Password Pengguna: <b
                                        class="error">*Pastikan Password Terisi | Min 8 Karakter</b></label>
                                <input type="password" class="form-control" id="password_pengguna_add"
                                    name="password_pengguna_add" minlength="8" placeholder="e.g: AbCd123">
                                <span class="text-danger error-text password_pengguna_add_error"></span>
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
    <div class="modal fade" id="PenggunaModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="PenggunaFormEdit">
                    <input type="hidden" class="form-control" id="pengguna_id_edit" name="pengguna_id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="nama_pengguna_edit" class="col-form-label">Nama Pengguna:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="nama_pengguna_edit" name="nama_pengguna_edit">
                                    <option value=""></option>
                                    @foreach ($dosen_id as $dosen)
                                        <option value="{{ $dosen->nama_dosen }}" data-iden="{{ $dosen->nidn }}">
                                            {{ $dosen->nama_dosen }}</option>
                                    @endforeach
                                    @foreach ($mhs_id as $mhs)
                                        <option value="{{ $mhs->nama_mahasiswa }}" data-iden="{{ $mhs->nim }}">
                                            {{ $mhs->nama_mahasiswa }}</option>
                                    @endforeach
                                    @foreach ($admin_id as $admin)
                                        <option value="{{ $admin->nama_admin }}" data-iden="{{ $admin->nip }}">
                                            {{ $admin->nama_admin }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text nama_pengguna_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="username_edit" class="col-form-label">Username: <b class="info">*Otomatis
                                        Terisi Jika Nama Pengguna Dipilih</b></label>
                                <input type="text" class="form-control" id="username_edit" name="username_edit"
                                    placeholder="e.g: NIDN/NIM" readonly>
                                <span class="text-danger error-text username_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-6">
                                <label for="tahun_ajaran_id_edit" class="col-form-label">Tahun Ajaran:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="tahun_ajaran_id_edit" name="tahun_ajaran_id_edit">
                                    <option value=""></option>
                                    @foreach ($tahun_id as $tahun)
                                        <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text tahun_ajaran_id_edit_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label for="role_pengguna_edit" class="col-form-label">Role Pengguna:</label>
                                <select class="js-example-responsive form-control" style="width: 100%"
                                    id="role_pengguna_edit" name="role_pengguna_edit">
                                    <option value=""></option>
                                    <option value="koordinator">Koordinator</option>
                                    <option value="kaprodi">Kaprodi</option>
                                    <option value="dosen">Dosen</option>
                                    <option value="mahasiswa">Mahasiswa</option>
                                    <option value="admin">Admin Prodi</option>
                                </select>
                                <span class="text-danger error-text role_pengguna_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="password_pengguna_edit" class="col-form-label">Password Pengguna: <b
                                        class="info">*Kosongkan Jika Tidak Update</b></label>
                                <input type="password" class="form-control" id="password_pengguna_edit"
                                    name="password_pengguna_edit" minlength="8">
                                <span class="text-danger error-text password_pengguna_edit_error"></span>
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
    {{-- END Modal Add --}}

    {{-- Modal Show --}}
    <div class="modal fade" id="PenggunaModalShow" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Pengguna</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="username_show" class="col-form-label">Username:</label>
                            <input type="text" class="form-control no-outline" id="username_show"
                                name="username_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_ajaran_id_show" class="col-form-label">ID Tahun Ajaran:</label>
                            <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show"
                                name="tahun_ajaran_id_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nama_pengguna_show" class="col-form-label">Nama Pengguna:</label>
                            <input type="text" class="form-control no-outline" id="nama_pengguna_show"
                                name="nama_pengguna_show" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="role_pengguna_show" class="col-form-label">Role Pengguna:</label>
                            <input type="text" class="form-control no-outline" id="role_pengguna_show"
                                name="role_pengguna_show" readonly>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    {{-- END Modal Add --}}

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Kelola Pengguna Aplikasi</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Pengguna Aplikasi</li>
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
                        <h4 class="card-title">Pengguna Bimbingan Online</h4>
                        <p class="card-title-desc">Anda perlu mengelola <b>Pengguna Bimbingan Online</b>,
                            agar dapat memanfaatkan <b>Sistem Informasi</b> sesuai dengan <b>ROLE</b> pengguna.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100"
                                id="PenggunaTabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Nama Pengguna</th>
                                        <th>Role Pengguna</th>
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
    <!-- select2 css -->
    <link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
    <!-- select2 js -->
    <script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>

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
            var table = $('#PenggunaTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelola-pengguna.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'role',
                        name: 'role'
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
                        width: '2%',
                        targets: [0]
                    },
                    {
                        width: '10%',
                        targets: [5]
                    }
                ],
                order: [
                    [2, 'desc'],
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

            /* Button Add */
            $("#btnAdd").click(function() {
                $('#PenggunaFormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#PenggunaModalAdd').modal('show');
                $('#nama_pengguna_add').val('').trigger('change');
                $('#role_pengguna_add').val('').trigger('change');
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                var this_id = $(this).data('id');
                $.get('kelola-pengguna/' + this_id, function(data) {
                    $('#PenggunaModalEdit').modal('show');
                    $('#pengguna_id_edit').val(data.id);
                    $('#username_edit').val(data.username);
                    $('#tahun_ajaran_id_edit').val(data.tahun_ajaran_id).trigger('change');
                    $('#nama_pengguna_edit').val(data.name).trigger('change');
                    $('#role_pengguna_edit').val(data.role).trigger('change');
                    $('#password_pengguna_edit').val(data.password);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('kelola-pengguna/' + this_id, function(data) {
                    $('#PenggunaModalShow').modal('show');
                    $('#pengguna_id_show').val(data.id);
                    $('#username_show').val(data.username);
                    $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                    $('#nama_pengguna_show').val(data.name);
                    $('#role_pengguna_show').val(data.role);
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
                            url: "kelola-pengguna/delete/" + this_id,
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

            /* Ajax Store */
            $("#PenggunaFormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kelola-pengguna.store') }}",
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
                            $("#PenggunaModalAdd").modal('hide');
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
                            title: 'Oops, Muncul Kesalahan !!',
                        });
                    }
                });
            });

            /* Ajax Update */
            $("#PenggunaFormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("pengguna_id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "kelola-pengguna/" + this_id,
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
                            $("#PenggunaModalEdit").modal('hide');
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
                            title: 'Oops, Muncul Kesalahan !!',
                        });
                    }
                });
            });

            /* Select2 Username Add */
            $("#nama_pengguna_add").select2({
                dropdownParent: $('#PenggunaModalAdd'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 Role Add */
            $("#role_pengguna_add").select2({
                dropdownParent: $('#PenggunaModalAdd'),
                placeholder: "Pilih berdasarkan role ...",
                minimumResultsForSearch: -1
            });

            /* Select2 Username Edit */
            $("#nama_pengguna_edit").select2({
                dropdownParent: $('#PenggunaModalEdit'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 Tahun Ajaran Edit */
            $("#tahun_ajaran_id_edit").select2({
                dropdownParent: $('#PenggunaModalEdit'),
                placeholder: "Cari berdasarkan tahun ...",
                allowClear: true
            });

            /* Select2 Role Edit */
            $("#role_pengguna_edit").select2({
                dropdownParent: $('#PenggunaModalEdit'),
                placeholder: "Pilih berdasarkan role ...",
                minimumResultsForSearch: -1
            });

            /* Select2 Event Nama Dipilih Add */
            $('#nama_pengguna_add').on('select2:select', function(e) {
                var kode = $('#nama_pengguna_add option:selected').attr('data-iden');
                $('#username_add').val(kode);
            });

            /* Select2 Event Nama Dipilih Add */
            $('#nama_pengguna_add').on('select2:unselect', function(e) {
                $('#username_add').val('');
            });

            /* Select2 Event Nama Dipilih Edit */
            $('#nama_pengguna_edit').on('select2:select', function(e) {
                var kode = $('#nama_pengguna_edit option:selected').attr('data-iden');
                $('#username_edit').val(kode);
            });

            /* Select2 Event Nama Dipilih Edit */
            $('#nama_pengguna_edit').on('select2:unselect', function(e) {
                $('#username_id_edit').val('');
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
