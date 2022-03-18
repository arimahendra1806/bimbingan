@extends('layouts.minia.header')

@section('content')
    {{-- Modal Add --}}
    <div class="modal fade" id="MateriTahunanModalAdd" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Data Materi Tahunan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="MateriTahunanFormAdd" enctype="multipart/form-data" files="true">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tahun_ajaran_id_add" class="col-form-label">ID Tahun Ajaran:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran_id_add"
                                name="tahun_ajaran_id_add">
                                <option value=""></option>
                                @foreach ($tahun_id as $tahun)
                                    <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text tahun_ajaran_id_add_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="file_materi_add" class="col-form-label">File Materi: <b
                                    class="error">*Pastikan File PDF | Max 2Mb</b></label>
                            <input type="file" class="form-control" id="file_materi_add" name="file_materi_add">
                            <span class="text-danger error-text file_materi_add_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="keterangan_add" class="col-form-label">Keterangan:</label><br>
                            <textarea class="form-control" name="keterangan_add" id="keterangan_add" style="width: 100%"
                                rows="3"></textarea>
                            <span class="text-danger error-text keterangan_add_error"></span>
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
    <div class="modal fade" id="MateriTahunanModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Materi Tahunan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" id="MateriTahunanFormEdit" enctype="multipart/form-data" files="true">
                    <input type="hidden" class="form-control" id="materi_id_edit" name="materi_id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-1">
                            <label for="tahun_ajaran_id_edit" class="col-form-label">ID Tahun Ajaran:</label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran_id_edit"
                                name="tahun_ajaran_id_edit">
                                <option value=""></option>
                                @foreach ($tahun_id as $tahun)
                                    <option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger error-text tahun_ajaran_id_edit_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="file_materi_edit" class="col-form-label">File Materi:<b
                                    class="info">*Kosongkan Jika Tidak Update</b></label>
                            <input type="text" class="form-control no-outline" id="fileShow" name="fileShow" readonly>
                            <input type="file" class="form-control" id="file_materi_edit" name="file_materi_edit">
                            <span class="text-danger error-text file_materi_edit_error"></span>
                        </div>
                        <div class="mb-1">
                            <label for="keterangan_edit" class="col-form-label">Keterangan:</label><br>
                            <textarea class="form-control" name="keterangan_edit" id="keterangan_edit" style="width: 100%"
                                rows="3"></textarea>
                            <span class="text-danger error-text keterangan_edit_error"></span>
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
    <div class="modal fade" id="MateriTahunanModalShow" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Data Materi Tahunan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-1">
                        <label for="tahun_ajaran_id_show" class="col-form-label">ID Tahun Ajaran:</label>
                        <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show"
                            name="tahun_ajaran_id_show" readonly>
                    </div>
                    <div class="mb-1">
                        <label for="file_materi_show" class="col-form-label">File Materi:</label>
                        <input type="text" class="form-control no-outline" id="file_materi_show" name="file_materi_show"
                            readonly>
                        <iframe style="width:100%; height:400px;" frameborder="0"></iframe>
                    </div>
                    <div class="mb-1">
                        <label for="keterangan_show" class="col-form-label">Keterangan:</label><br>
                        <textarea class="form-control" name="keterangan_show no-outline" id="keterangan_show"
                            style="width: 100%" rows="3" readonly></textarea>
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
                    <h4 class="mb-sm-0 font-size-18">Kelola Materi Tahunan</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Materi Tahunan</li>
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
                        <h4 class="card-title">Materi Tahunan</h4>
                        <p class="card-title-desc">Anda perlu mengelola <b>Materi Tahunan</b>,
                            yang akan di <b>Dipublikaskan</b> kepada Mahasiswa dan Dosen setiap <b>Tahunnya</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-end">
                            <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1"
                                data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </div>
                        <table class="table table-bordered dt-responsive nowrap w-100" id="MateriTahunanTabels">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>File Materi</th>
                                    <th>Keterangan</th>
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
            var table = $('#MateriTahunanTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('materi-tahunan.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'file_materi',
                        name: 'file_materi'
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan'
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
                $('#MateriTahunanFormAdd').trigger('reset');
                $(document).find('span.error-text').text('');
                $('#MateriTahunanModalAdd').modal('show');
                $('#tahun_ajaran_id_add').val("").trigger('change');
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                $(document).find('span.error-text').text('');
                $('#file_materi_edit').val("");
                var this_id = $(this).data('id');
                $.get('materi-tahunan/' + this_id, function(data) {
                    $('#MateriTahunanModalEdit').modal('show');
                    $('#materi_id_edit').val(data.id);
                    $('#tahun_ajaran_id_edit').val(data.tahun_ajaran_id).trigger('change');
                    $('#fileShow').val(data.file_materi);
                    $('#keterangan_edit').val(data.keterangan);
                });
            });

            /* Button Show */
            $('body').on('click', '#btnShow', function() {
                var this_id = $(this).data('id');
                $.get('materi-tahunan/' + this_id, function(data) {
                    $('#MateriTahunanModalShow').modal('show');
                    $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                    $('#file_materi_show').val(data.file_materi);
                    $('#keterangan_show').val(data.keterangan);
                    $('iframe').attr("src", "{{ asset('dokumen/materi-tahunan') }}" + "/" + data
                        .file_materi);
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
                            url: "materi-tahunan/delete/" + this_id,
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
            $("#MateriTahunanFormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "{{ route('materi-tahunan.store') }}",
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
                            $("#MateriTahunanModalAdd").modal('hide');
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
            $("#MateriTahunanFormEdit").submit(function(e) {
                var form = this;
                form.editSave.disabled = true;
                form.editSave.value = "Sedang memproses...";

                e.preventDefault();
                var this_id = document.getElementById("materi_id_edit").value;

                var formData = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: "materi-tahunan/" + this_id,
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
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
                            $("#MateriTahunanModalEdit").modal('hide');
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

            /* Select2 Tahun Ajaran Add */
            $("#tahun_ajaran_id_add").select2({
                dropdownParent: $('#MateriTahunanModalAdd'),
                placeholder: "Cari berdasarkan tahun ...",
                allowClear: true
            });

            /* Select2 Tahun Ajaran Edit */
            $("#tahun_ajaran_id_edit").select2({
                dropdownParent: $('#MateriTahunanModalEdit'),
                placeholder: "Cari berdasarkan tahun ...",
                allowClear: true
            });
        });
    </script>
    {{-- END DataTables --}}
@endsection
