@extends('layouts.minia.header')

@section('content')
{{-- Modal Export --}}
<div class="modal fade" id="Modal" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Export Daftar Judul Mahasiswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="ExportForm" enctype="multipart/form-data" files="true">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tahun_ajaran" class="col-form-label">Tahun Ajaran: <b class="error">*Pastikan Pilih Tahun Ajaran</b></label>
                        <select class="js-example-responsive form-control" style="width: 100%" id="tahun_ajaran" name="tahun_ajaran">
                            <option value=""></option>
                            @foreach ($tahun_id as $tahun)
                                <option value="{{$tahun->id}}">{{$tahun->tahun_ajaran}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="progress" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" aria-valuenow=""
                        aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                          0%
                        </div>
                    </div>
                    <a class="btn btn-success btn-sm waves-effect waves-light mt-1 mb-1" style="width: 100%" id="btnDownload">Click To Download</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Generating Link</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- END Modal Export --}}

<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Daftar Judul Mahasiswa</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{route('dashboard.home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Judul Mahasiswa</li>
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
                    <h4 class="card-title">Data Judul Mahasiswa</h4>
                    <p class="card-title-desc">
                        Berikut adalah daftar <b>Judul Mahasiswa</b> setelah mendapatkan <b>Dosen Pembimbing</b>.
                    </p>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end">
                        <a href="javascript:void(0)" class="btn btn-primary btn-md waves-effect waves-light mb-1" data-toggle="tooltip" title="Export Data" id="btnExport">
                            <i class="fas fa-file-export"></i>
                        </a>
                    </div>
                    <table class="table table-bordered dt-responsive nowrap w-100" id="Tabels">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun Ajaran</th>
                                <th>Kode Pembimbing</th>
                                <th>Nama Pembimbing</th>
                                <th>Nama Mahasiswa</th>
                                <th>Judul Mahasiswa</th>
                                <th>Status Judul</th>
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

<script>
    $(document).ready(function () {
        /* Ajax Token */
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /* Get data table */
        var table = $('#Tabels').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{route('judul-mahasiswa.indexKoor')}}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex'},
                { data: 'tahun.tahun_ajaran', name: 'tahun.tahun_ajaran'},
                { data: 'kode_pembimbing', name: 'kode_pembimbing'},
                { data: 'dosen.nama_dosen', name: 'dosen.nama_dosen'},
                { data: 'mahasiswa.nama_mahasiswa', name: 'mahasiswa.nama_mahasiswa'},
                { data: 'judul.judul', name: 'judul.judul'},
                { data: 'judul.status', name: 'judul.status'},
            ],
            columnDefs: [
                { searchable: false, orderable: false, targets: [0] },
                { width: '1%', targets: [0] },
            ],
            order: [
                [ 1, 'asc' ]
            ],
        });

        /* Button Tooltip */
        $('table').on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        /* Button Import */
        $("#btnExport").click(function(){
            $('#ExportForm').trigger('reset');
            $('#Modal').modal('show');
            $('#tahun_ajaran').val('').trigger('change');
            $('.progress-bar').text('0%');
            $('.progress-bar').css('width', '0%');
            document.getElementById('btnDownload').style.display = "none";
        });

        /* Ajax Export */
        $("#ExportForm").submit(function(e){
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
                url: "{{route('judul-mahasiswa.exportKoor')}}",
                type: "POST",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success:function(data)
                {
                    $('.progress-bar').text('Generated');
                    $('.progress-bar').css('width', '100%');
                    document.getElementById('btnDownload').style.display = "block";
                    $('#btnDownload').prop("href", data);
                },
                error:function(response)
                {
                    $('.progress-bar').text('0%');
                    $('.progress-bar').css('width', '0%');
                    document.getElementById('btnDownload').style.display = "none";
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops, Muncul Kesalahan !!',
                        text: 'Terdapat kesalahan pengisian data, pastikan semua data terisi !!'
                    });
                }
            });
        });

        /* Event Timeout btnDownload */
        $("#btnDownload").click(function(){
            setTimeout(function() {
                Swal.fire({
                    title: "Export Daftar Judul Berhasil!",
                    icon: "success",
                }).then(function(){
                    $("#Modal").modal('hide');
                });
            }, 100);
        });

        /* Select2 Tahun Ajaran Add */
        $("#tahun_ajaran").select2({
            dropdownParent: $('#Modal'),
            placeholder: "Cari berdasarkan tahun ...",
            allowClear: true
        });
    });
</script>
@endsection
