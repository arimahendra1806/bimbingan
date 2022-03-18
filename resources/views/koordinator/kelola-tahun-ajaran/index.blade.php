@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="TahunAjaranModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="TahunAjaranFormAdd">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tahun_ajaran_add" class="col-form-label">Tahun Ajaran:</label>
                            <input type="text" class="form-control" id="tahun_ajaran_add" name="tahun_ajaran_add"
                                placeholder="e.g: 2019/2020">
                            <span class="text-danger error-text tahun_ajaran_add_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="tahun_status_add" class="col-form-label">Status:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_status_add"
                                name="tahun_status_add">
                                <option value=""></option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <span class="text-danger error-text tahun_status_add_error"></span>
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
    <div class="modal fade" id="TahunAjaranModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="TahunAjaranFormEdit">
                    <input type="hidden" class="form-control" id="tahun_ajaran_id_edit" name="tahun_ajaran_id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tahun_ajaran_edit" class="col-form-label">Tahun Ajaran:</label>
                            <input type="text" class="form-control" id="tahun_ajaran_edit" name="tahun_ajaran_edit"
                                placeholder="e.g: 2019/2020">
                            <span class="text-danger error-text tahun_ajaran_edit_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="tahun_status_edit" class="col-form-label">Status:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_status_edit"
                                name="tahun_status_edit">
                                <option value=""></option>
                                <option value="Aktif">Aktif</option>
                                <option value="Tidak Aktif">Tidak Aktif</option>
                            </select>
                            <span class="text-danger error-text tahun_status_edit_error"></span>
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
    <div class="modal fade" id="TahunAjaranModalShow" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Tahun Ajaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="tahun_ajaran_show" class="col-form-label">Tahun Ajaran:</label>
                        <input type="text" class="form-control no-outline" id="tahun_ajaran_show" name="tahun_ajaran_show"
                            readonly>
                    </div>
                    <div class="mb-1">
                        <label for="tahun_status_show" class="col-form-label">Status:</label>
                        <input type="text" class="form-control no-outline" id="tahun_status_show" name="tahun_status_show"
                            readonly>
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
                    <h4 class="mb-sm-0 font-size-18">Kelola Tahun Ajaran</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Tahun Ajaran</li>
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
                        <h4 class="card-title">Tahun Ajaran</h4>
                        <p class="card-title-desc">Anda perlu mengelola <b>Tahun Ajaran</b>,
                            yang akan di <b>Aktifkan</b> untuk memberikan pemisah setiap <b>Tahunnya</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </div>
                        <table class="table table-bordered dt-responsive nowrap w-100" id="TahunAjaranTabels">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
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
            var table = $('#TahunAjaranTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tahun-ajaran.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun_ajaran',
                        name: 'tahun_ajaran'
                    },
                    {
                        data: 'status',
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
                        targets: [0, 3]
                    },
                    {
                        width: '1%',
                        targets: [0, 3]
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
                $('#TahunAjaranFormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#TahunAjaranModalAdd').modal('show');
                $('#tahun_status_add').val('').trigger('change');
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                var this_id = $(this).data('id');
                $.get('tahun-ajaran/' + this_id, function(data) {
                    $('#TahunAjaranModalEdit').modal('show');
                    $('#tahun_ajaran_id_edit').val(data.id);
                    $('#tahun_ajaran_edit').val(data.tahun_ajaran);
                    $('#tahun_status_edit').val(data.status).trigger('change');
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('tahun-ajaran/' + this_id, function(data) {
                    $('#TahunAjaranModalShow').modal('show');
                    $('#tahun_ajaran_show').val(data.tahun_ajaran);
                    $('#tahun_status_show').val(data.status);
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
                            url: "tahun-ajaran/delete/" + this_id,
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
            $("#TahunAjaranFormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('tahun-ajaran.store') }}",
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
                            $("#TahunAjaranModalAdd").modal('hide');
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

            /* Ajax Update */
            $("#TahunAjaranFormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("tahun_ajaran_id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "tahun-ajaran/" + this_id,
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
                            $("#TahunAjaranModalEdit").modal('hide');
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

            /* Select2 Tahun Ajaran Add */
            $("#tahun_status_add").select2({
                dropdownParent: $('#TahunAjaranModalAdd'),
                placeholder: "Pilih berdasarkan status ...",
                minimumResultsForSearch: -1
            });

            /* Select2 Tahun Ajaran Edit */
            $("#tahun_status_edit").select2({
                dropdownParent: $('#TahunAjaranModalEdit'),
                placeholder: "Pilih berdasarkan status ...",
                minimumResultsForSearch: -1
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
