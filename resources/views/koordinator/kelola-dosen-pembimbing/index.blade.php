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
                                <label for="nidn_edit" class="col-form-label">Kode Pembimbing: <b
                                        class="info">*Otomatis Diperbarui</b></label>
                                <input type="text" class="form-control" id="kode_edit" name="kode_edit" readonly>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="nidn_edit" class="col-form-label">NIDN: </label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="nidn_edit"
                                    name="nidn_edit">
                                    <option value=""></option>
                                    @foreach ($dosen_id as $dosen)
                                        <option value="{{ $dosen->nidn }}">{{ $dosen->nama_dosen }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <label for="nim_edit" class="col-form-label">NIM: </label>
                                <select class="js-example-responsive form-control" style="width: 100%" id="nim_edit"
                                    name="nim_edit">
                                    <option value=""></option>
                                    @foreach ($mhs_id as $mhs)
                                        <option value="{{ $mhs->nim }}">{{ $mhs->nama_mahasiswa }}</option>
                                    @endforeach
                                </select>
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
                                            <label for="nidn_add" class="col-form-label">Calon Dosen Pembimbing: <b
                                                    class="error">*Pastikan Pilih Pembimbing</b></label>
                                            <select class="js-example-responsive form-control" style="width: 100%"
                                                id="nidn_add" name="nidn_add">
                                                <option value=""></option>
                                                @foreach ($dosen_id as $dosen)
                                                    <option value="{{ $dosen->nidn }}"
                                                        data-id="{{ $dosen->nama_dosen }}">
                                                        {{ $dosen->nama_dosen }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tahun_ajaran_id_add" class="col-form-label">Tahun Ajaran: <b
                                                    class="info">*Otomatis Terisi</b></label>
                                            <input type="text" class="form-control" id="tahun_ajaran_id_add"
                                                name="tahun_ajaran_id_add" value="{{ $tahun_id->tahun_ajaran }}" readonly>
                                        </div>
                                    </div>
                                    <table class="table table-bordered dt-responsive nowrap w-100" id="JudulTabels">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>NIM</th>
                                                <th>Pengajuan Judul Tugas Akhir</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr></tr>
                                        </tbody>
                                    </table>
                                    <div class="row mb-2 mt-3">
                                        <div class="col-md-6" id="infoJumlah"></div>
                                        <div class="col-md-6 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Tambahkan Data</button>
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
                        <table class="table table-bordered dt-responsive nowrap w-100" id="DosPemTabels">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tahun Ajaran</th>
                                    <th>Kode Pembimbing</th>
                                    <th>NIDN</th>
                                    <th>NIM</th>
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
                ajax: "{{ route('dosen-pembimbing.judul') }}",
                columns: [{
                        data: 'nim',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nim',
                        name: 'nim'
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
                                    "<b>Status Pengerjaan : </b>" + data.pengerjaan + " dengan " +
                                    data.nim_anggota
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
            });

            /* Get data table DosPem */
            var tableDosPem = $('#DosPemTabels').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('dosen-pembimbing.index') }}",
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
                        data: 'nidn',
                        name: 'nidn'
                    },
                    {
                        data: 'nim',
                        name: 'nim'
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
            });

            /* Button Tooltip */
            $('table').on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip();
            });

            /* Button Edit */
            $('body').on('click', '#btnEdit', function() {
                var this_id = $(this).data('id');
                $.get('dosen-pembimbing/' + this_id, function(data) {
                    $('#ModalEdit').modal('show');
                    $('#pembimbing_id_edit').val(data.id);
                    $('#kode_edit').val(data.kode_pembimbing);
                    $('#nidn_edit').val(data.nidn).trigger('change');
                    $('#nim_edit').val(data.nim).trigger('change');
                });
            });

            /* Button Delete */
            $('body').on('click', '#btnDelete', function() {
                var this_id = $(this).data("id");
                console.log(this_id);
                Swal.fire({
                    title: 'Apakah anda ingin menghapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "dosen-pembimbing/delete/" + this_id,
                            type: 'post',
                            data: {
                                "id": this_id,
                            },
                            success: function(response) {
                                tableJudul.ajax.reload();
                                tableDosPem.ajax.reload();
                                Swal.fire({
                                    title: "Berhasil Menghapus Data!",
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

                var rows_selected = tableJudul.column(0).checkboxes.selected();

                // Iterate over all selected checkboxes
                $.each(rows_selected, function(index, rowId) {
                    // Create a hidden element
                    $(form).append(
                        $('<input>')
                        .attr('type', 'hidden')
                        .attr('name', 'nim_add[]')
                        .attr('id', 'nim_add')
                        .val(rowId)
                    );
                });

                e.preventDefault();

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('dosen-pembimbing.store') }}",
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("[id*='nim_add']").each(function() {
                            $(this).remove();
                        });
                        $('#nidn_add').val('').trigger('change');
                        $('#FormAdd').trigger('reset');
                        tableJudul.ajax.reload();
                        tableDosPem.ajax.reload();
                        Swal.fire({
                            title: "Berhasil Menambahkan Data Pembimbing!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!',
                            text: 'Terdapat kesalahan, pastikan semua data terisi !!'
                        });
                    }
                });
            });

            /* Ajax Update */
            $("#FormEdit").submit(function(e) {
                e.preventDefault();
                var this_id = document.getElementById("pembimbing_id_edit").value;

                var formData = new FormData(this);

                $.ajax({
                    url: "dosen-pembimbing/" + this_id,
                    type: "POST",
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        tableJudul.ajax.reload();
                        tableDosPem.ajax.reload();
                        $("#ModalEdit").modal('hide');
                        Swal.fire({
                            title: "Berhasil Memperbarui Data!",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops, Muncul Kesalahan !!',
                            text: 'Terdapat kesalahan, pastikan semua data terisi !!'
                        });
                    }
                });
            });

            /* Select2 NIDN Add */
            $("#nidn_add").select2({
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 NIDN Edit */
            $("#nidn_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 NIM Edit */
            $("#nim_edit").select2({
                dropdownParent: $('#ModalEdit'),
                placeholder: "Cari berdasarkan nama ...",
                allowClear: true
            });

            /* Select2 Event NIDN Dipilih Show Jumlah */
            $('#nidn_add').on('select2:select', function(e) {
                var kode = $('#nidn_add option:selected').attr('value');
                var nm = $('#nidn_add option:selected').attr('data-id');
                $.get('data/jumlah/pembimbing/' + kode, function(data) {
                    $('#infoJumlah').html("Jumlah Mahasiswa yang dibimbing oleh Dosen " + nm +
                        " saat ini adalah " + data.data + " Mahasiswa.");
                });
            });

            /* Select2 Event NIDN Tidak Dipilih Show Jumlah */
            $('#nidn_add').on('select2:unselect', function(e) {
                $('#infoJumlah').html("");
            });
        });
    </script>
@endsection
