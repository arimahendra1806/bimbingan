@extends('layouts.minia.header')

@section('content')
{{-- Modal Add --}}
<div class="modal fade" id="LinkModalAdd" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Link Zoom Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="LinkFormAdd">
                @csrf
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nidn_add" class="col-form-label">NIDN: <b class="error">*Pastikan NIDN Terisi</b></label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="nidn_add" name="nidn_add">
                                <option value=""></option>
                                @foreach ($dosen_id as $dosen)
                                    <option value="{{$dosen->nidn}}">{{$dosen->nama_dosen}}</option>
                                @endforeach
                            </select>
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
                            <label for="id_meeting_add" class="col-form-label">ID Meeting: <b class="error">*Pastikan ID Meeting Terisi</b></label>
                            <input type="text" class="form-control" id="id_meeting_add" name="id_meeting_add" placeholder="e.g: 1922 1922 1922">
                        </div>
                        <div class="col-md-6">
                            <label for="passcode_add" class="col-form-label">Passcode: <b class="error">*Pastikan Passcode Terisi</b></label>
                            <input type="text" class="form-control" id="passcode_add" name="passcode_add" placeholder="e.g: 4b6casJS">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="link_add" class="col-form-label">Link Zoom: <b class="error">*Pastikan Link Zoom Terisi</b></label><br>
                            <textarea class="form-control" name="link_add" id="link_add" style="width: 100%" rows="3"></textarea>
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
{{-- END Modal Add --}}

{{-- Modal Edit --}}
<div class="modal fade" id="LinkModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Perbarui Data Link Zoom Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="LinkFormEdit">
                <input type="hidden" class="form-control" id="link_id_edit" name="link_id_edit">
                @csrf
                <div class="modal-body">
                    <div class="row mb-1">
                        <div class="col-md-6">
                            <label for="nidn_edit" class="col-form-label">NIDN: </label>
                            <select class="js-example-responsive form-control" style="width: 100%" id="nidn_edit" name="nidn_edit">
                                <option value=""></option>
                                @foreach ($dosen_id as $dosen)
                                    <option value="{{$dosen->nidn}}">{{$dosen->nama_dosen}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="tahun_ajaran_id_edit" class="col-form-label">Tahun Ajaran Id: </label>
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
                            <label for="id_meeting_edit" class="col-form-label">ID Meeting: </label>
                            <input type="text" class="form-control" id="id_meeting_edit" name="id_meeting_edit">
                        </div>
                        <div class="col-md-6">
                            <label for="passcode_edit" class="col-form-label">Passcode: </label>
                            <input type="text" class="form-control" id="passcode_edit" name="passcode_edit">
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-12">
                            <label for="link_edit" class="col-form-label">Link Zoom: </label><br>
                            <textarea class="form-control" name="link_edit" id="link_edit" style="width: 100%" rows="3"></textarea>
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

{{-- Modal Show --}}
<div class="modal fade" id="LinkModalShow" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Link Zoom Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="nidn_show" class="col-form-label">NIDN: </label>
                        <input type="text" class="form-control no-outline" id="nidn_show" name="nidn_show" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="tahun_ajaran_id_show" class="col-form-label">Tahun Ajaran Id: </label>
                        <input type="text" class="form-control no-outline" id="tahun_ajaran_id_show" name="tahun_ajaran_id_show" readonly>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-6">
                        <label for="id_meeting_show" class="col-form-label">ID Meeting: </label>
                        <input type="text" class="form-control no-outline" id="id_meeting_show" name="id_meeting_show" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="passcode_show" class="col-form-label">Passcode: </label>
                        <input type="text" class="form-control no-outline" id="passcode_show" name="passcode_show" readonly>
                    </div>
                </div>
                <div class="row mb-1">
                    <div class="col-md-12">
                        <label for="link_show" class="col-form-label">Link Zoom: </label><br>
                        <textarea class="form-control" name="link_show" id="link_show" style="width: 100%" rows="3" readonly></textarea>
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
                <h5 class="modal-title">Import Data Link Zoom Dosen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="ImportForm" enctype="multipart/form-data" files="true">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="file_import" class="col-form-label">File Import: <b class="error">*Pastikan Format CSV/XLSX/XLS</b></label>
                        <input type="file" class="form-control mb-1" id="file_import" name="file_import">
                        <a href="{{ asset('assets/img') }}/import_link_large.png" class="glightbox">
                            <img src="{{ asset('assets/img') }}/import_link_small.png" alt="image" width="100%" />
                        </a>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" aria-valuenow=""
                        aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                          0%
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import Sekarang</button>
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
                <h4 class="mb-sm-0 font-size-18">Kelola Data Link Zoom Dosen</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Data Link Zoom Dosen</li>
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
                    <h4 class="card-title">Data Link Zoom Dosen</h4>
                    <p class="card-title-desc">Anda perlu mengelola <b>Data Link Zoom Dosen</b>,
                        agar mereka bisa menggunakan <b>Sistem Informasi</b> khususnya untuk <b>Jadwal Zoom Konsultasi</b>.
                    </p>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1" data-toggle="tooltip" title="Tambah Data" id="btnAdd">
                            <i class="fas fa-plus-circle"></i>
                        </a>&nbsp;
                        <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1" data-toggle="tooltip" title="Import Data" id="btnImport">
                            <i class="fas fa-file-import"></i>
                        </a>
                    </div>
                    <table class="table table-bordered dt-responsive nowrap w-100" id="LinkTabels">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIDN</th>
                                <th>Tahun Ajaran</th>
                                <th>ID Meeting</th>
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
<!-- glightbox css -->
<link rel="stylesheet" href="{{ asset('vendor/minia') }}/assets/libs/glightbox/css/glightbox.min.css">
<!-- glightbox js -->
<script src="{{ asset('vendor/minia') }}/assets/libs/glightbox/js/glightbox.min.js"></script>

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
        var table = $('#LinkTabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('link-zoom.index')}}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'nidn', name: 'nidn'},
                { data: 'tahun.tahun_ajaran', name: 'tahun.tahun_ajaran'},
                { data: 'id_meeting', name: 'id_meeting'},
                { data: 'action', name: 'action'}
            ],
            columnDefs: [
                { searchable: false, orderable: false, targets: [0, 4] },
                { width: '1%', targets: [0,4] }
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
            $('#LinkFormAdd').trigger('reset');
            $('#LinkModalAdd').modal('show');
            $('#tahun_ajaran_id_add').val('').trigger('change');
            $('#nidn_add').val('').trigger('change');
        });

        /* Button Edit */
        $('body').on('click', '#btnEdit', function () {
            var this_id = $(this).data('id');
            $.get('link-zoom/'+this_id, function (data) {
                $('#LinkModalEdit').modal('show');
                $('#link_id_edit').val(data.id);
                $('#tahun_ajaran_id_edit').val(data.tahun_ajaran_id).trigger('change');
                $('#nidn_edit').val(data.nidn).trigger('change');
                $('#id_meeting_edit').val(data.id_meeting);
                $('#passcode_edit').val(data.passcode);
                $('#link_edit').val(data.link_zoom);
            });
        });

        /* Button Show */
        $('body').on('click', '#btnShow', function () {
            var this_id = $(this).data('id');
            $.get('link-zoom/'+this_id, function (data) {
                $('#LinkModalShow').modal('show');
                $('#tahun_ajaran_id_show').val(data.tahun.tahun_ajaran);
                $('#nidn_show').val(data.nidn);
                $('#id_meeting_show').val(data.id_meeting);
                $('#passcode_show').val(data.passcode);
                $('#link_show').val(data.link_zoom);
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
                        url: "link-zoom/delete/"+this_id,
                        type: 'post',
                        data: {
                            "id": this_id,
                        },
                        success: function (response) {
                            table.ajax.reload();
                            Swal.fire({
                                title:"Berhasil Menghapus Data!",
                                icon:"success",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });

        /* Button Import */
        $("#btnImport").click(function(){
            $('#ImportForm').trigger('reset');
            $('#ImportModal').modal('show');
            $('.progress-bar').text('0%');
            $('.progress-bar').css('width', '0%');
        });

        /* Ajax Store */
        $("#LinkFormAdd").submit(function(e){
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: "{{route('link-zoom.store')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response)
                {
                    table.ajax.reload();
                    $("#LinkModalAdd").modal('hide');
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
        $("#LinkFormEdit").submit(function(e){
            e.preventDefault();
            var this_id = document.getElementById("link_id_edit").value;

            var formData = new FormData(this);

            $.ajax({
                url: "link-zoom/"+this_id,
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response)
                {
                    table.ajax.reload();
                    $("#LinkModalEdit").modal('hide');
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

        /* Ajax Import */
        $("#ImportForm").submit(function(e){
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
                url: "{{route('link-zoom.import')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(response)
                {
                    $('.progress-bar').text('Uploaded');
                    $('.progress-bar').css('width', '100%');
                    table.ajax.reload();
                    Swal.fire({
                        title: "Import Data Link Zoom Dosen Berhasil!",
                        icon: "success",
                    }).then(function(){
                        $("#ImportModal").modal('hide');
                    });
                },
                error:function(response)
                {
                    $('.progress-bar').text('0%');
                    $('.progress-bar').css('width', '0%');
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, Muncul Kesalahan !!',
                        text: 'Terdapat kesalahan pengisian data, pastikan semua data terisi !!'
                    });
                }
            });
        });

        /* Import Info Gambar */
        const lightbox = GLightbox({
            touchNavigation: true,
        });

        /* Select2 Tahun Ajaran Add */
        $("#tahun_ajaran_id_add").select2({
            dropdownParent: $('#LinkModalAdd'),
            placeholder: "Cari berdasarkan tahun ...",
            allowClear: true
        });

        /* Select2 NIDN Add */
        $("#nidn_add").select2({
            dropdownParent: $('#LinkModalAdd'),
            placeholder: "Cari berdasarkan nama ...",
            allowClear: true
        });

        /* Select2 Tahun Ajaran Edit */
        $("#tahun_ajaran_id_edit").select2({
            dropdownParent: $('#LinkModalEdit'),
            placeholder: "Cari berdasarkan tahun ...",
            allowClear: true
        });

        /* Select2 NIDN Edit */
        $("#nidn_edit").select2({
            dropdownParent: $('#LinkModalEdit'),
            placeholder: "Cari berdasarkan nama ...",
            allowClear: true
        });

    });
</script>
{{-- END DataTables --}}
@endsection
