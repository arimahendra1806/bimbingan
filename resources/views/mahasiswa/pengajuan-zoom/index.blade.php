@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="ModalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Pengajuan Jadwal Zoom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormAdd">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tanggal_add" class="col-form-label">Tanggal Pengajuan:</label>
                            <input type="date" class="form-control" id="tanggal_add" name="tanggal_add">
                            <span class="text-danger error-text tanggal_add_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="jam_add" class="col-form-label">Jam Pengajuan:</label>
                            <input type="time" class="form-control" id="jam_add" name="jam_add">
                            <span class="text-danger error-text jam_add_error"></span>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Pengajuan Zoom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tanggal_edit" class="col-form-label">Tanggal Pengajuan:</label>
                            <input type="date" class="form-control" id="tanggal_edit" name="tanggal_edit">
                            <span class="text-danger error-text tanggal_edit_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="jam_edit" class="col-form-label">Jam Pengajuan:</label>
                            <input type="time" class="form-control" id="jam_edit" name="jam_edit">
                            <span class="text-danger error-text jam_edit_error"></span>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Pengajuan Zoom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="tanggal_show" class="col-form-label">Tanggal Pengajuan:</label>
                        <input type="text" class="form-control no-outline" id="tanggal_show" name="tanggal_show">
                    </div>
                    <div class="mb-1">
                        <label for="jam_show" class="col-form-label">Jam Pengajuan:</label>
                        <input type="text" class="form-control no-outline" id="jam_show" name="jam_show" readonly>
                    </div>
                    <div class="mb-1">
                        <label for="status_show" class="col-form-label">Status Pengajuan:</label>
                        <input type="text" class="form-control no-outline" id="status_show" name="status_show" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="zoom_show" class="col-form-label" id="zoom_label_show">Detail link Zoom:</label>
                        <textarea class="form-control" name="zoom_show" id="zoom_show" style="width: 100%" rows="3" readonly></textarea>
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
                    <h4 class="mb-sm-0 font-size-18">Pengajuan Jadwal Zoom</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Pengajuan Jadwal Zoom</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Card Jadwal Zoom -->
        @include('partial.jadwalZoom')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pengajuan Jadwal Zoom</h4>
                        <p class="card-title-desc">
                            Anda dapat mengajukan jadwal zoom kepada Dosen Pembimbing.
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
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
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
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Hide input */
            $(function() {
                $('#zoom_label_show').hide();
                $('#zoom_show').hide();
            });

            /* Get data table */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('pengajuan-zoom.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'jam',
                        name: 'jam'
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
                var this_id = $(this).data('id');
                $.get('pengajuan-zoom/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.id);
                    $('#tanggal_edit').val(data.tanggal);
                    $('#jam_edit').val(data.jam);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('pengajuan-zoom/' + this_id, function(data) {
                    $('#ModalShow').modal('show');
                    $('#tanggal_show').val(data.tanggal);
                    $('#jam_show').val(data.jam);
                    $('#status_show').val(data.status);
                    if (data.status == 'Diterima') {
                        $('#zoom_label_show').show();
                        $('#zoom_show').show();
                        $('#zoom_show').val("ID Meeting:  " + data.pembimbing.zoom.id_meeting +
                            "\nPassode:  " + data.pembimbing.zoom.passcode + "\nLink Zoom:  " +
                            data.pembimbing.zoom.link_zoom);
                    } else {
                        $('#zoom_label_show').hide();
                        $('#zoom_show').hide();
                        $('#zoom_show').val("");
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
                    url: "{{ route('pengajuan-zoom.store') }}",
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

            /* Ajax Update */
            $("#FormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();

                var this_id = document.getElementById("id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "pengajuan-zoom/" + this_id,
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
                            Swal.fire({
                                icon: 'error',
                                title: data.msg
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

        });
    </script>

    @yield('JadwalZoomJs')
@endsection
