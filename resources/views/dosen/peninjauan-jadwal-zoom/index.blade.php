@extends('layouts.minia.header')

@section('content')
    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Peninjauan Jadwal Zoom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="id_edit" name="id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="status_edit" class="col-form-label">Status Pengajuan:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="status_edit"
                                name="status_edit">
                                <option value=""></option>
                                <option value="Diajukan" disabled>Diajukan</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Tidak Diterima">Tidak Diterima</option>
                            </select>
                            <span class="text-danger error-text status_edit_error"></span>
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
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Peninjauan Jadwal Zoom</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nama_show" class="col-form-label">Nama Mahasiswa:</label>
                            <input type="text" class="form-control no-outline" id="nama_show" name="nama_show">
                        </div>
                        <div class="col-md-6">
                            <label for="status_show" class="col-form-label">Status Pengajuan:</label>
                            <input type="text" class="form-control no-outline" id="status_show" name="status_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="tanggal_show" class="col-form-label">Tanggal Pengajuan:</label>
                            <input type="text" class="form-control no-outline" id="tanggal_show" name="tanggal_show">
                        </div>
                        <div class="col-md-6">
                            <label for="jam_show" class="col-form-label">Jam Pengajuan:</label>
                            <input type="text" class="form-control no-outline" id="jam_show" name="jam_show" readonly>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="zoom_show" class="col-form-label" id="zoom_label_show">Detail link Zoom:</label>
                            <textarea class="form-control" name="zoom_show" id="zoom_show" style="width: 100%" rows="3" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="anggota_show" class="col-form-label" id="anggota_label_show">Detail Mahasiswa
                                Yang Bergabung: <b class="info">*Daftar mahasiswa yang bergabung dengan jadwal
                                    zoom ini</b></label>
                            <textarea class="form-control" name="anggota_show" id="anggota_show" style="width: 100%" rows="4" readonly></textarea>
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

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Peninjauan Jadwal Zoom</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Peninjauan Jadwal Zoom</li>
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
                        <h4 class="card-title">Peninjauan Jadwal Zoom</h4>
                        <p class="card-title-desc">
                            Anda dapat meninjau jadwal zoom yang diajukan.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="Tabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Mahasiswa</th>
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

            /* Hidden input */
            $(function() {
                $('#zoom_label_show').hide();
                $('#zoom_show').hide();
                $('#anggota_label_show').hide();
                $('#anggota_show').hide();
            });

            /* Get data table */
            var table = $('#Tabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('peninjauan-jadwal-zoom.indexDsn') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'pembimbing.mahasiswa.nama_mahasiswa',
                        name: 'pembimbing.mahasiswa.nama_mahasiswa'
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
                        targets: [0, 5]
                    },
                    {
                        width: '1%',
                        targets: [0, 5]
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

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                var this_id = $(this).data('id');
                $.get('peninjauan-jadwal-zoom/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#id_edit').val(data.data.id);
                    $('#status_edit').val(data.data.status).trigger('change');
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('peninjauan-jadwal-zoom/' + this_id, function(data) {
                    $('#ModalShow').modal('show');
                    $('#nama_show').val(data.data.pembimbing.mahasiswa.nama_mahasiswa);
                    $('#tanggal_show').val(data.data.tanggal);
                    $('#jam_show').val(data.data.jam);
                    $('#status_show').val(data.data.status);
                    if (data.data.status == 'Diterima') {
                        $('#zoom_label_show').show();
                        $('#zoom_show').show();
                        $('#anggota_label_show').show();
                        $('#anggota_show').show();
                        $('#zoom_show').val("ID Meeting:  " + data.data.pembimbing.zoom.id_meeting +
                            "\nPassode:  " + data.data.pembimbing.zoom.passcode +
                            "\nHost Key:  " +
                            data.data.pembimbing.zoom.host_key +
                            "\nLink Zoom:  " +
                            data.data.pembimbing.zoom.link_zoom);
                        $('#anggota_show').val(data.anggota.join(', '));
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
                    url: "peninjauan-jadwal-zoom/" + this_id,
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

            /* Select2 Status Edit */
            $("#status_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Pilih berdasarkan status ...",
                minimumResultsForSearch: -1
            });

        });
    </script>
    {{-- END DataTables --}}
@endsection
