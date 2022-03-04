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
                            <label for="identitas_id_add" class="col-form-label">Identitas Id: <b class="info">*Otomatis Terisi Jika Nama Pengguna Dipilih</b></label>
                            <input type="text" class="form-control" id="identitas_id_add" name="identitas_id_add" placeholder="*Otomatis Terisi" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_ajaran_id_add" class="col-form-label">Tahun Ajaran Id: <b class="error">*Pastikan Pilih Tahun Ajaran</b></label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran_id_add" name="tahun_ajaran_id_add">
                                <option value=""></option>
                                @foreach ($tahun_id as $tahun)
                                    <option value="{{$tahun->id}}">{{$tahun->tahun_ajaran}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nama_pengguna_add" class="col-form-label">Nama Pengguna: <b class="error">*Pastikan Pilih Nama Pengguna</b></label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="nama_pengguna_add" name="nama_pengguna_add">
                                <option value=""></option>
                                @foreach ($dosen_id as $dosen)
                                    <option value="{{$dosen->nama_dosen}}" data-iden="{{$dosen->nidn}}">{{$dosen->nama_dosen}}</option>
                                @endforeach
                                @foreach ($mhs_id as $mhs)
                                    <option value="{{$mhs->nama_mhs}}" data-iden="{{$dosen->nidn}}">{{$mhs->nama_mhs}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="role_pengguna_add" class="col-form-label">Role Pengguna: <b class="error">*Pastikan Pilih Role Pengguna</b></label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="role_pengguna_add" name="role_pengguna_add">
                                <option value=""></option>
                                <option value="koordinator">Koordinator</option>
                                <option value="kaprodi">Kaprodi</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="email_pengguna_add" class="col-form-label">Email Pengguna: <b class="info">*Otomatis Terisi Jika Nama Pengguna Dipilih</b></label>
                            <input type="email" class="form-control" id="email_pengguna_add" name="email_pengguna_add" placeholder="*Otomatis Terisi" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="password_pengguna_add" class="col-form-label">Password Pengguna: <b class="error">*Pastikan Password Terisi | Min 8 Karakter</b></label>
                            <input type="password" class="form-control" id="password_pengguna_add" name="password_pengguna_add" minlength="8" placeholder="e.g: AbCd123">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END Modal Add--}}

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
                            <label for="identitas_id_edit" class="col-form-label">Identitas Id: <b class="info">*Otomatis Terisi Jika Nama Pengguna Dipilih</b></label>
                            <input type="text" class="form-control" id="identitas_id_edit" name="identitas_id_edit" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_ajaran_id_edit" class="col-form-label">Tahun Ajaran Id:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran_id_edit" name="tahun_ajaran_id_edit">
                                <option value=""></option>
                                @foreach ($tahun_id as $tahun)
                                    <option value="{{$tahun->id}}">{{$tahun->tahun_ajaran}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nama_pengguna_edit" class="col-form-label">Nama Pengguna:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="nama_pengguna_edit" name="nama_pengguna_edit">
                                <option value=""></option>
                                @foreach ($dosen_id as $dosen)
                                    <option value="{{$dosen->nama_dosen}}" data-iden="{{$dosen->nidn}}">{{$dosen->nama_dosen}}</option>
                                @endforeach
                                @foreach ($mhs_id as $mhs)
                                    <option value="{{$mhs->nama_mhs}}" data-iden="{{$dosen->nidn}}">{{$mhs->nama_mhs}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="role_pengguna_edit" class="col-form-label">Role Pengguna:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="role_pengguna_edit" name="role_pengguna_edit">
                                <option value=""></option>
                                <option value="koordinator">Koordinator</option>
                                <option value="kaprodi">Kaprodi</option>
                                <option value="dosen">Dosen</option>
                                <option value="mahasiswa">Mahasiswa</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="email_pengguna_edit" class="col-form-label">Email Pengguna: <b class="info">*Otomatis Terisi Jika Nama Pengguna Dipilih</b></label>
                            <input type="email" class="form-control" id="email_pengguna_edit" name="email_pengguna_edit" placeholder="NIDN/NIM@bimbingan.id">
                        </div>
                        <div class="col-md-6">
                            <label for="password_pengguna_edit" class="col-form-label">Password Pengguna: <b class="info">*Kosongkan Jika Tidak Update</b></label>
                            <input type="password" class="form-control" id="password_pengguna_edit" name="password_pengguna_edit" minlength="8">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END Modal Add--}}

{{-- Modal Show --}}
<div class="modal fade" id="PenggunaModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="identitas_id_show" class="col-form-label">Identitas Id:</label>
                        <input type="text" class="form-control no-outline" id="identitas_id_show" name="identitas_id_show" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_ajaran_id_show" class="col-form-label">Tahun Ajaran Id:</label>
                        <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show" name="tahun_ajaran_id_show" readonly>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="nama_pengguna_show" class="col-form-label">Nama Pengguna:</label>
                        <input type="text" class="form-control no-outline" id="nama_pengguna_show" name="nama_pengguna_show" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="role_pengguna_show" class="col-form-label">Role Pengguna:</label>
                        <input type="text" class="form-control no-outline" id="role_pengguna_show" name="role_pengguna_show" readonly>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="email_pengguna_show" class="col-form-label">Email Pengguna:</label>
                        <input type="email" class="form-control no-outline" id="email_pengguna_show" name="email_pengguna_show" readonly>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
{{-- END Modal Add--}}

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Kelola Pengguna Aplikasi</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">Home</a></li>
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
                        <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1" data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                            <i class="fas fa-plus-circle"></i>
                        </a>
                    </div>
                    <table class="table table-bordered dt-responsive  nowrap w-100" id="PenggunaTabels">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Identitas Pengguna</th>
                                <th>Tahun Ajaran</th>
                                <th>Nama Pengguna</th>
                                <th>Role Pengguna</th>
                                <th>Email Pengguna</th>
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
@endsection

@section('js')
<!-- select2 css -->
<link href="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.css" rel="stylesheet" />
<!-- select2 js -->
<script src="{{ asset('vendor/minia') }}/assets/libs/select2/select2.min.js"></script>

{{-- DataTables --}}
<script>
    $(document).ready(function () {
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
            ajax: "{{route('pengguna.index')}}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'identitas_id', name: 'identitas_id'},
                { data: 'tahun.tahun_ajaran', name: 'tahun.tahun_ajaran'},
                { data: 'name', name: 'name'},
                { data: 'role', name: 'role'},
                { data: 'email', name: 'email'},
                { data: 'action', name: 'action'}
            ],
            columnDefs: [
                { searchable: false, orderable: false, targets: [0, 6] },
                { width: '2%', targets: [0] },
                { width: '10%', targets: [6] }
            ],
            order: [
                [ 1, 'asc' ]
            ],
        });

        /* Button Tooltip */
        $('table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        /* Button Add */
        $("#btnAdd").click(function(){
            $('#PenggunaFormAdd').trigger('reset');
            $('#PenggunaModalAdd').modal('show');
            $('#tahun_ajaran_id_add').val('').trigger('change');
            $('#nama_pengguna_add').val('').trigger('change');
            $('#role_pengguna_add').val('').trigger('change');
        });

        /* Button Edit */
        $('body').on('click', '#btnEdit', function () {
            var this_id = $(this).data('id');
            $.get('pengguna/'+this_id, function (data) {
                $('#PenggunaModalEdit').modal('show');
                $('#pengguna_id_edit').val(data.id);
                $('#identitas_id_edit').val(data.identitas_id);
                $('#tahun_ajaran_id_edit').val(data.tahun_ajaran_id).trigger('change');
                $('#nama_pengguna_edit').val(data.name).trigger('change');
                $('#role_pengguna_edit').val(data.role).trigger('change');
                $('#email_pengguna_edit').val(data.email);
                $('#password_pengguna_edit').val(data.password);
            });
        });

        /* Button Show */
        $('body').on('click', '#btnShow', function () {
            var this_id = $(this).data('id');
            $.get('pengguna/'+this_id, function (data) {
                $('#PenggunaModalShow').modal('show');
                $('#pengguna_id_show').val(data.id);
                $('#identitas_id_show').val(data.identitas_id);
                $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                $('#nama_pengguna_show').val(data.name);
                $('#role_pengguna_show').val(data.role);
                $('#email_pengguna_show').val(data.email);
            });
        });

        /* Button Delete */
        $('body').on('click', '#btnDelete', function () {
            var this_id = $(this).data("id");
            Swal.fire({
                    title: 'Apakah anda ingin menghapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "pengguna/delete/"+this_id,
                        type: 'post',
                        data: {
                            "id": this_id,
                        },
                        success: function (response)
                        {
                            table.ajax.reload();
                            Swal.fire({
                                title:"Berhasil Menghapus Data1",
                                icon:"success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });

        /* Ajax Store */
        $("#PenggunaFormAdd").submit(function(e){
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{route('pengguna.store')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response)
                {
                    table.ajax.reload();
                    $("#PenggunaModalAdd").modal('hide');
                    Swal.fire({
                        title: "Berhasil Menambahkan Data!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error:function(response)
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, Muncul Kesalahan !!',
                        text: 'Terdapat kesalahan, pastikan semua data terisi !!'
                    });
                }
            });
        });

        /* Ajax Update */
        $("#PenggunaFormEdit").submit(function(e){
            e.preventDefault();

            var this_id = document.getElementById("pengguna_id_edit").value;

            var formData = new FormData(this);

            $.ajax({
                url: "pengguna/"+this_id,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response)
                {
                    table.ajax.reload();
                    $("#PenggunaModalEdit").modal('hide');
                    Swal.fire({
                        title: "Berhasil Memperbarui Data!",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                error:function(response)
                {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, Muncul Kesalahan !!',
                        text: 'Terdapat kesalahan, pastikan semua data terisi !!'
                    });
                }
            });
        });

        /* Select2 Identitas Add */
        $("#nama_pengguna_add").select2({
            dropdownParent: $('#PenggunaModalAdd'),
            placeholder: "Cari berdasarkan nama ...",
            allowClear: true
        });

        /* Select2 Tahun Ajaran Add */
        $("#tahun_ajaran_id_add").select2({
            dropdownParent: $('#PenggunaModalAdd'),
            placeholder: "Cari berdasarkan tahun ...",
            allowClear: true
        });

        /* Select2 Role Add */
        $("#role_pengguna_add").select2({
            dropdownParent: $('#PenggunaModalAdd'),
            placeholder: "Pilih berdasarkan role ...",
            minimumResultsForSearch: -1
        });

        /* Select2 Identitas Edit */
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
        $('#nama_pengguna_add').on('select2:select', function (e) {
            var kode = $('#nama_pengguna_add option:selected').attr('data-iden');
            $('#identitas_id_add').val(kode);
            $('#email_pengguna_add').val(kode + '@bimbingan.id');
        });

        /* Select2 Event Nama Dipilih Add */
        $('#nama_pengguna_add').on('select2:unselect', function (e) {
            $('#identitas_id_add').val('');
            $('#email_pengguna_add').val('');
        });

        /* Select2 Event Nama Dipilih Edit */
        $('#nama_pengguna_edit').on('select2:select', function (e) {
            var kode = $('#nama_pengguna_edit option:selected').attr('data-iden');
            $('#identitas_id_edit').val(kode);
            $('#email_pengguna_edit').val(kode + '@bimbingan.id');
        });

        /* Select2 Event Nama Dipilih Edit */
        $('#nama_pengguna_edit').on('select2:unselect', function (e) {
            $('#identitas_id_edit').val('');
            $('#email_pengguna_edit').val('');
        });
    });
</script>
{{-- END DataTables --}}
@endsection
