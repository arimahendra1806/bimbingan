@extends('layouts.minia.header')

@section('content')
    {{-- Modal Edit --}}
    <div class="modal fade" id="ModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Perbarui Data Dosen Pembimbing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="FormEdit">
                    <input type="hidden" class="form-control" id="pembimbing_id_edit" name="pembimbing_id_edit">
                    @csrf
                    <div class="modal-body">
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="dosen_edit" class="col-form-label">Nama Dosen: </label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="dosen_edit"
                                    name="dosen_edit">
                                    <option value=""></option>
                                    @foreach ($dosen_id as $dosen)
                                        <option value="{{ $dosen->id }}">{{ $dosen->nama_dosen }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text dosen_edit_error"></span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="mhs_edit" class="col-form-label">Nama Mahasiswa: </label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="mhs_edit"
                                    name="mhs_edit">
                                    <option value=""></option>
                                    @foreach ($mhs_id as $mhs)
                                        <option value="{{ $mhs->id }}">{{ $mhs->nama_mahasiswa }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger error-text mhs_edit_error"></span>
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

    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Kelola Data Dosen Pembimbing</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Kelola Data Dosen Pembimbing</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Card Tambah Data Pembimbing -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="card-title">Tambah Data Dosen Pembimbing</h4>
                            </div>
                            <div class="col-md-6 d-flex justify-content-end">
                                <a class="d-block text-primary" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <i class="max fas fa-angle-double-up pull-right"></i>
                                </a>
                            </div>
                        </div>
                        <p class="card-title-desc">
                            Tambahkan <b>data Dosen Pembimbing</b> sesuai dengan list <b>pengajuan judul</b> yang ada.
                        </p>
                    </div>
                    <div class="collapse" id="collapseExample">
                        <div class="container">
                            <div class="card-body">
                                <form id="FormAdd">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="dosen_add" class="col-form-label">Calon Dosen Pembimbing:</label>
                                            <select class="js-example-responsive form-control" style="width: 100%"
                                                id="dosen_add" name="dosen_add">
                                                <option value=""></option>
                                                @foreach ($dosen_id as $dosen)
                                                    <option value="{{ $dosen->id }}"
                                                        data-id="{{ $dosen->nama_dosen }}">
                                                        {{ $dosen->nama_dosen }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger error-text dosen_add_error"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tahun_ajaran_id_add" class="col-form-label">Tahun Ajaran: <b
                                                    class="info">*Otomatis Terisi</b></label>
                                            <input type="text" class="form-control" id="tahun_ajaran_id_add"
                                                name="tahun_ajaran_id_add" value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped dt-responsive nowrap w-100"
                                            id="JudulTabels">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Nama Mahasiswa</th>
                                                    <th>Pengajuan Judul Tugas Akhir</th>
                                                    <th>Status Judul</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <span class="text-danger error-text mhs_add_error"></span>
                                    <div class="row mb-2 mt-3">
                                        <div class="col-md-2" id="infoTerpilih">0 baris terpilih.</div>
                                        <div class="col-md-7" id="infoJumlah"></div>
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <input type="submit" class="btn btn-primary" name="addSave"
                                                value="Tambahkan Data"></input>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Data Pembimbing -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Data Dosen Pembimbing</h4>
                        <p class="card-title-desc">Anda perlu <b>mengelola data Dosen Pembimbing</b> setiap tahunnya,
                            berdasarkan pengajuan judul dari <b>masing-masing mahasiswa</b>.
                        </p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped dt-responsive nowrap w-100" id="DosPemTabels">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tahun Ajaran</th>
                                        <th>Kode Pembimbing</th>
                                        <th>Nama Dosen</th>
                                        <th>Nama Mahasiswa</th>
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
    <!-- checkbox css -->
    <link type="text/css" href="{{ asset('vendor/minia') }}/assets/libs/gyrocode/dataTables.checkboxes.css"
        rel="stylesheet" />
    <!-- checkbox js -->
    <script type="text/javascript" src="{{ asset('vendor/minia') }}/assets/libs/gyrocode/dataTables.checkboxes.min.js">
    </script>

    <script>
        $(document).ready(function() {
            /* Ajax Token */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            /* Get data table Judul */
            var tableJudul = $('#JudulTabels').DataTable({
                processing: true,
                serverSide: false,
                ajax: "{{ route('kelola-dosen-pembimbing.judul') }}",
                columns: [{
                        data: 'mahasiswa_id',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'mahasiswa.nama_mahasiswa',
                        name: 'mahasiswa.nama_mahasiswa'
                    },
                    {
                        name: 'pengajuan'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                ],
                columnDefs: [{
                        searchable: false,
                        orderable: false,
                        targets: [0]
                    },
                    {
                        width: '1%',
                        targets: [0, 3]
                    },
                    {
                        targets: 0,
                        checkboxes: {
                            selectRow: true
                        }
                    },
                    {
                        targets: [2],
                        data: function(data, type, dataToSet) {
                            if (data.pengerjaan == "Sendiri") {
                                return "<b>Judul : </b>" + data.judul + "<br>" +
                                    "<b>Studi Kasus : </b>" + data.studi_kasus + "<br>" +
                                    "<b>Status Pengerjaan : </b>" + data.pengerjaan
                            } else {
                                return "<b>Judul : </b>" + data.judul + "<br>" +
                                    "<b>Studi Kasus : </b>" + data.studi_kasus + "<br>" +
                                    "<b>Status Pengerjaan : </b>" + data.pengerjaan + " bersama " +
                                    data.anggota.nama_mahasiswa
                            }
                        }
                    }
                ],
                select: {
                    style: 'multi'
                },
                order: [
                    [1, 'asc']
                ],
                oLanguage: {
                    sUrl: "/vendor/minia/assets/libs/datatables.net/js/indonesian.json"
                }
            });

            /* Checkbox terpilih */
            $('#JudulTabels').on('change', 'input[type="checkbox"]', function() {
                var count = tableJudul.column(0).checkboxes.selected().count();
                $('#infoTerpilih').html(count + " " + "baris terpilih.");
            });

            /* Get data table DosPem */
            var tableDosPem = $('#DosPemTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('kelola-dosen-pembimbing.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'tahun.tahun_ajaran',
                        name: 'tahun.tahun_ajaran'
                    },
                    {
                        data: 'kode_pembimbing',
                        name: 'kode_pembimbing'
                    },
                    {
                        data: 'dosen.nama_dosen',
                        name: 'dosen.nama_dosen'
                    },
                    {
                        data: 'mahasiswa.nama_mahasiswa',
                        name: 'mahasiswa.nama_mahasiswa'
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
                    [2, 'asc']
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
                var this_id = $(this).data('id');
                $.get('kelola-dosen-pembimbing/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#pembimbing_id_edit').val(data.id);
                    $('#kode_edit').val(data.kode_pembimbing);
                    $('#dosen_edit').val(data.dosen_id).trigger('change');
                    $('#mhs_edit').val(data.mahasiswa_id).trigger('change');
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
                            url: "kelola-dosen-pembimbing/delete/" + this_id,
                            type: 'post',
                            data: {
                                "id": this_id,
                            },
                            success: function(data) {
                                tableJudul.ajax.reload();
                                tableDosPem.ajax.reload();
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
            $("#FormAdd").submit(function(e) {
                var form = this;
                form.addSave.disabled = true;
                form.addSave.value = "Sedang memproses...";

                var rows_selected = tableJudul.column(0).checkboxes.selected();

                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId) {
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'mhs_add[]')
                        .attr('id', 'mhs_add')
                        .val(rowId)
                    );
                });

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('kelola-dosen-pembimbing.store') }}",
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
                            form.addSave.value = "Tambahkan Data";
                            $.each(data.error, function(prefix, val) {
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                            $("[id*='mhs_add']").each(function() {
                                $(this).remove();
                            });
                        } else {
                            $("[id*='mhs_add']").each(function() {
                                $(this).remove();
                            });
                            $('#dosen_add').val('').trigger('change');
                            $('#FormAdd').trigger('reset');
                            $('#infoJumlah').html("");
                            $('#infoTerpilih').html("0 baris terpilih.");
                            form.addSave.disabled = false;
                            form.addSave.value = "Tambahkan Data";
                            tableJudul.ajax.reload();
                            tableDosPem.ajax.reload();
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
                        form.addSave.value = "Tambahkan Data";
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

                var this_id = document.getElementById("pembimbing_id_edit").value;
                var formData = new FormData(this);

                $.ajax({
                    url: "kelola-dosen-pembimbing/" + this_id,
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
                            tableJudul.ajax.reload();
                            tableDosPem.ajax.reload();
                            $("#ModalEdit").modal('hide');
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

            /* Select2 NIDN Add */
            $("#dosen_add").select2({
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 NIDN Edit */
            $("#dosen_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 NIM Edit */
            $("#mhs_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 Event NIDN Dipilih Show Jumlah */
            $('#dosen_add').on('select2:select', function(e) {
                var kode = $('#dosen_add option:selected').attr('value');
                var nm = $('#dosen_add option:selected').attr('data-id');
                $.get('data/jumlah/pembimbing/' + kode, function(data) {
                    $('#infoJumlah').html("Jumlah Mahasiswa yang dibimbing oleh Dosen " + nm +
                        " saat ini adalah " + data.data + " Mahasiswa.");
                });
            });

            /* Select2 Event NIDN Tidak Dipilih Show Jumlah */
            $('#dosen_add').on('select2:unselect', function(e) {
                $('#infoJumlah').html("");
            });
        });
    </script>
@endsection
